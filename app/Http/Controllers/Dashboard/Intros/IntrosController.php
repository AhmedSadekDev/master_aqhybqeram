<?php

namespace App\Http\Controllers\Dashboard\Intros;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Intros\CreateIntrosRequest;
use App\Http\Requests\Dashboard\Intros\UpdateIntrosRequest;
use App\Models\Intro;
use Illuminate\Http\Request;

class IntrosController extends Controller
{

    public function index(Request $request) {
        $breadcrumb = [
            'title' =>  __("Intros lists"),
            'items' =>  [
                [
                    'title' =>  __("Intros lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Intro::orderBy('id', 'desc')->paginate();
        return view('dashboard.pages.intros.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'=> $lists,
        ]);
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("Create new intro"),
            'items' =>  [
                [
                    'title' =>  __("Intros lists"),
                    'url'   => route('dashboard.intros.index'),
                ],
                [
                    'title' =>  __("Create new intro"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.intros.create',[
            'breadcrumb'    =>  $breadcrumb
        ]);
    }

    public function store(CreateIntrosRequest $request) {
        $data = $request->all();
        $data = $this->uploadFiles($request , $data);
        Intro::create($data);
        return redirect()->route('dashboard.intros.index')->with('success', __("This row has been created."));
    }

    public function edit(Intro $intro) {
        $breadcrumb = [
            'title' =>  __("Edit intro"),
            'items' =>  [
                [
                    'title' => __("Intros lists"),
                    'url'   => route('dashboard.intros.index'),
                ],
                [
                    'title' =>  __("Edit intro"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.intros.edit',[
            'breadcrumb'    =>  $breadcrumb,
            'intro'         =>  $intro,
        ]);
    }

    public function update(UpdateIntrosRequest $request, Intro $intro) {
        $data = $request->all();
        $data = $this->uploadFiles($request , $data);
        $intro->update($data);
        return redirect()->route('dashboard.intros.index')->with('success', __("This row has been updated."));
    }

    public function destroy(Request $request,Intro $intro) {
        $intro->delete();
        return redirect()->route('dashboard.intros.index')->with('success', __("This row has been deleted."));
    }

    public function uploadFiles($request , $data)
    {
        if(request()->has('image') && !is_null(request('image'))) {
            $data['image'] = imageUpload($request['image'],'Intros');
        } else {
            if (isset($request['image'])){
                unset($request['image']);
            }
        }

        return $data;
    }
}
