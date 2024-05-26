<?php

namespace App\Http\Controllers\Dashboard\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Categories\CreateCategoriesRequest;
use App\Http\Requests\Dashboard\Categories\UpdateCategoriesRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index(Request $request) {
        $breadcrumb = [
            'title' =>  __("Categories lists"),
            'items' =>  [
                [
                    'title' =>  __("Categories lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Category::orderBy('id', 'desc')->paginate();
        return view('dashboard.pages.categories.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'=> $lists,
        ]);
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("Create new admin"),
            'items' =>  [
                [
                    'title' =>  __("Categories lists"),
                    'url'   => route('dashboard.categories.index'),
                ],
                [
                    'title' =>  __("Create new Category"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.categories.create',[
            'breadcrumb'    =>  $breadcrumb
        ]);
    }

    public function store(CreateCategoriesRequest $request) {
        $data = $request->all();
        $data = $this->uploadFiles($request , $data);
        Category::create($data);
        return redirect()->route('dashboard.categories.index')->with('success', __("This row has been created."));
    }

    public function edit(Category $category) {
        $breadcrumb = [
            'title' =>  __("Edit Category"),
            'items' =>  [
                [
                    'title' => __("Categories lists"),
                    'url'   => route('dashboard.categories.index'),
                ],
                [
                    'title' =>  __("Edit Category"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.categories.edit',[
            'breadcrumb'    =>  $breadcrumb,
            'category'         =>  $category,
        ]);
    }

    public function update(UpdateCategoriesRequest $request, Category $category) {
        $data = $request->all();
        $data = $this->uploadFiles($request , $data);
        $category->update($data);
        return redirect()->route('dashboard.categories.index')->with('success', __("This row has been updated."));
    }

    
    public function changeStatus(Request $request,Category $category) {
        $category->update([
            'active'    => ($category->active == 1) ? 0 : 1
        ]);
        return redirect()->route('dashboard.categories.index')->with('success', __("This row status has been updated."));
    }

    public function destroy(Request $request,Category $category) {
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', __("This row has been deleted."));
    }

    public function uploadFiles($request , $data)
    {
        if(request()->has('image') && !is_null(request('image'))) {
            $data['image'] = imageUpload($request['image'],'Categories');
        } else {
            if (isset($request['image'])){
                unset($request['image']);
            }
        }

        return $data;
    }
}
