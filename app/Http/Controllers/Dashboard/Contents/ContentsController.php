<?php

namespace App\Http\Controllers\Dashboard\Contents;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Contents\CreateContentsRequest;
use App\Http\Requests\Dashboard\Contents\UpdateContentsRequest;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentsController extends Controller
{

    public function index(Request $request) {
        $breadcrumb = [
            'title' =>  __("Contents lists"),
            'items' =>  [
                [
                    'title' =>  __("Contents lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Content::orderBy('id', 'desc')->paginate();
        return view('dashboard.pages.contents.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'=> $lists,
        ]);
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("Create new content"),
            'items' =>  [
                [
                    'title' =>  __("Contents lists"),
                    'url'   => route('dashboard.contents.index'),
                ],
                [
                    'title' =>  __("Create new content"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.contents.create',[
            'breadcrumb'    =>  $breadcrumb
        ]);
    }

    public function store(CreateContentsRequest $request) {
        Content::create($request->all());
        return redirect()->route('dashboard.contents.index')->with('success', __("This row has been created."));
    }

    public function edit(Content $content) {
        $breadcrumb = [
            'title' =>  __("Edit content"),
            'items' =>  [
                [
                    'title' => __("Contents lists"),
                    'url'   => route('dashboard.contents.index'),
                ],
                [
                    'title' =>  __("Edit content"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.contents.edit',[
            'breadcrumb'    =>  $breadcrumb,
            'content'         =>  $content,
        ]);
    }

    public function update(UpdateContentsRequest $request, Content $content) {
        $content->update($request->all());
        return redirect()->route('dashboard.contents.index')->with('success', __("This row has been updated."));
    }

    public function destroy(Request $request,Content $content) {
        $content->delete();
        return redirect()->route('dashboard.contents.index')->with('success', __("This row has been deleted."));
    }
}
