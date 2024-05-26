<?php

namespace App\Http\Controllers\Dashboard\Sliders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Sliders\CreateSlidersRequest;
use App\Http\Requests\Dashboard\Sliders\UpdateSlidersRequest;
use App\Models\Slider;
use Illuminate\Http\Request;

class SlidersController extends Controller
{

    public function index(Request $request) {
        $breadcrumb = [
            'title' =>  __("Sliders lists"),
            'items' =>  [
                [
                    'title' =>  __("Sliders lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Slider::orderBy('id', 'desc')->paginate();
        return view('dashboard.pages.sliders.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'=> $lists,
        ]);
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("Create new slider"),
            'items' =>  [
                [
                    'title' =>  __("Sliders lists"),
                    'url'   => route('dashboard.sliders.index'),
                ],
                [
                    'title' =>  __("Create new slider"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.sliders.create',[
            'breadcrumb'    =>  $breadcrumb
        ]);
    }

    public function store(CreateSlidersRequest $request) {
        $data = $request->all();
        $data = $this->uploadFiles($request , $data);
        Slider::create($data);
        return redirect()->route('dashboard.sliders.index')->with('success', __("This row has been created."));
    }

    public function edit(Slider $slider) {
        $breadcrumb = [
            'title' =>  __("Edit slider"),
            'items' =>  [
                [
                    'title' => __("Sliders lists"),
                    'url'   => route('dashboard.sliders.index'),
                ],
                [
                    'title' =>  __("Edit slider"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.sliders.edit',[
            'breadcrumb'    =>  $breadcrumb,
            'slider'         =>  $slider,
        ]);
    }

    public function update(UpdateSlidersRequest $request, Slider $slider) {
        $data = $request->all();
        $data = $this->uploadFiles($request , $data);
        $slider->update($data);
        return redirect()->route('dashboard.sliders.index')->with('success', __("This row has been updated."));
    }

    
    public function changeStatus(Request $request,Slider $slider) {
        $slider->update([
            'active'    => ($slider->active == 1) ? 0 : 1
        ]);
        return redirect()->route('dashboard.sliders.index')->with('success', __("This row status has been updated."));
    }

    public function destroy(Request $request,Slider $slider) {
        $slider->delete();
        return redirect()->route('dashboard.sliders.index')->with('success', __("This row has been deleted."));
    }

    public function uploadFiles($request , $data)
    {
        if(request()->has('image') && !is_null(request('image'))) {
            $data['image'] = imageUpload($request['image'],'sliders');
        } else {
            if (isset($request['image'])){
                unset($request['image']);
            }
        }

        return $data;
    }
}
