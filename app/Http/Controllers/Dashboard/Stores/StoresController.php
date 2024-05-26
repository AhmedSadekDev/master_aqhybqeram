<?php

namespace App\Http\Controllers\Dashboard\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Stores\CreateStoresRequest;
use App\Http\Requests\Dashboard\Stores\UpdateStoresRequest;
use App\Models\Store;
use App\Models\Category;
use App\Models\Rate;

class StoresController extends Controller
{
    public function index() {

        $breadcrumb = [
            'title' =>  __("Stores lists"),
            'items' =>  [
                [
                    'title' =>  __("Stores Lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Store::orderBy('id', 'desc')->paginate();
        return view('dashboard.pages.stores.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'     =>$lists,
        ]);
    }

    public function create() {
        $categories = Category::all();
        if($categories->count() == 0) {
            return redirect()->route('dashboard.stores.index')->with('danger', __("Oops, Please Add Categories First"));
        }
        $breadcrumb = [
            'title' =>  __("Create New Store"),
            'items' =>  [
                [
                    'title' =>  __("Stores Lists"),
                    'url'   => route('dashboard.stores.index'),
                ],
                [
                    'title' =>  __("Create New Store"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.stores.create',[
            'breadcrumb'=>$breadcrumb,
            'categories'=>$categories,
        ]);
    }

    public function store(CreateStoresRequest $request) {
        $data = $request->all();
        $data = $this->uploadFiles($request , $data);
        $store = Store::create($data);
        $store->categories()->sync(request('categories',[]));
        return redirect()->route('dashboard.stores.index')->with('success', __("This row has been created."));
    }
    
    public function edit(Store $store) {
        $breadcrumb = [
            'title' =>  __("Edit Store"),
            'items' =>  [
                [
                    'title' =>  __("Stores Lists"),
                    'url'   => route('dashboard.stores.index'),
                ],
                [
                    'title' =>  __("Edit Store"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view('dashboard.pages.stores.edit',[
            'breadcrumb'    =>  $breadcrumb,
            'categories'    =>  Category::all(),
            'store'         =>  $store,
        ]);
    }

    public function update(UpdateStoresRequest $request, Store $store) {
        $data = $request->all();
        $data = $this->uploadFiles($request , $data);
        $store->update($data);
        $store->categories()->sync(request('categories',[]));
        return redirect()->route('dashboard.stores.index')->with('success', __("This row has been updated."));
    }

    public function destroy(Request $request,Store $store) {
        $store->delete();
        return redirect()->route('dashboard.stores.index')->with('success', __("This row has been deleted."));
    }

    public function changeOffer(Request $request,Store $store) {
        $store->update([
            'offer' => ($store->offer == 0) ? 1 : 0, 
        ]);
        return redirect()->route('dashboard.stores.index')->with('success', __("تم تغير حاله العرض"));
    }

    public function changeMoreChoice(Request $request,Store $store) {
        $store->update([
            'more_choice' => ($store->more_choice == 0) ? 1 : 0, 
        ]);
        return redirect()->route('dashboard.stores.index')->with('success', __("تم تغير حاله العرض"));
    }

    public function changeRecommend(Request $request,Store $store) {
        $store->update([
            'recommend' => ($store->recommend == 0) ? 1 : 0, 
        ]);
        return redirect()->route('dashboard.stores.index')->with('success', __("تم تغير حاله العرض"));
    }

    public function changeUnmissableOffer(Request $request,Store $store) {
        $store->update([
            'unmissable_offer' => ($store->unmissable_offer == 0) ? 1 : 0, 
        ]);
        return redirect()->route('dashboard.stores.index')->with('success', __("تم تغير حاله العرض"));
    }

    public function uploadFiles($request , $data)
    {
        if(request()->has('logo') && !is_null(request('logo'))) {
            $data['logo'] = imageUpload($request['logo'],'stores');
        } else {
            if (isset($request['logo'])){
                unset($request['logo']);
            }
        }

        if(request()->has('cover') && !is_null(request('cover'))) {
            $data['cover'] = imageUpload($request['cover'],'stores');
        } else {
            if (isset($request['cover'])){
                unset($request['cover']);
            }
        }

        return $data;
    }


    public function rateIndex(Store $store) {
        $breadcrumb = [
            'title' =>  __("Stores Rates"),
            'items' =>  [
                [
                    'title' =>  __("Stores Lists"),
                    'url'   =>  route('dashboard.stores.index'),
                ],
                [
                    'title' =>  __("Stores Rates"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $lists = Rate::where('store_id',$store->id)->orderBy('id', 'desc')->paginate();
        return view('dashboard.pages.stores.rates',[
            'breadcrumb'=>$breadcrumb,
            'lists'     =>$lists,
            'store'         =>  $store,
        ]);
    }

    public function rateDestroy(Request $request,Store $store,Rate $rate) {
        $rate->delete();
        return redirect()->route('dashboard.stores.rates.index',$store->id)->with('success', __("This row has been deleted."));
    }
}
