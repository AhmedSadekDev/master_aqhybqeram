<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index() {
        $breadcrumb = [
            'title' =>  __("Settings lists"),
            'items' =>  [
                [
                    'title' =>  __("Settings Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Setting::FORM_INPUTS;
        return view('dashboard.pages.settings.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'=>$lists,
        ]);
    }

    public function edit($group_by = null) {
        $lists = Setting::FORM_INPUTS;
        if(is_null($group_by) || !key_exists($group_by,$lists)) {
            abort(404);
        }
        $breadcrumb = [
            'title' =>  __("Edit Settings"),
            'items' =>  [
                [
                    'title' =>  __("Settings Lists"),
                    'url'   =>  route('dashboard.settings.index'),
                ],
                [
                    'title' =>  __("Edit Settings"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $form = $lists[$group_by]['form'];
        return view('dashboard.pages.settings.edit',[
            'breadcrumb'=>$breadcrumb,
            'group_by'=>$group_by,
            'form'=>$form,
        ]);
    }

    public function update(Request $request, $group_by = null) {
        $lists = Setting::FORM_INPUTS;
        if(is_null($group_by) || !key_exists($group_by,$lists)) {
            abort(404);
        }
        $request = $request->all();
        unset($request['_token']);
        unset($request['_method']);
        foreach($request as $key=>$value) {
            $check = Setting::where(['key' => $key,'group_by'=> $group_by])->first();
            if(!is_null($check)) {
                $check->update([
                    'value'=>$this->filterValue($value)
                ]);
            } else {
                $data['key']        = $key;
                $data['group_by']   = $group_by;
                $data['value']      = $this->filterValue($value);
                Setting::create($data);
            }
        }
        return redirect()->route('dashboard.settings.index')->with('success', __("This data has been updated."));
    }

    public function filterValue($value) {
        if ($value instanceof UploadedFile) {
            $value   = imageUpload($value, 'stander');
        }
        return $value;
    }
}
