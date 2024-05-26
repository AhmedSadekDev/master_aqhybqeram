<?php

namespace App\Http\Controllers\Dashboard\Subscriptions;

// Controllers
use App\Http\Controllers\Controller;
// Requests
use App\Http\Requests\Dashboard\Subscriptions\CreateSubscriptionsRequest;
use App\Http\Requests\Dashboard\Subscriptions\UpdateSubscriptionsRequest;
// Models
use App\Models\Subscription;
// Http
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{

    public function index(Request $request) {
        $breadcrumb = [
            'title' =>  __("Subscriptions lists"),
            'items' =>  [
                [
                    'title' =>  __("Subscriptions lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Subscription::orderBy('id', 'desc')->paginate();
        return view('dashboard.pages.subscriptions.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'=> $lists,
        ]);
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("Create new Subscription"),
            'items' =>  [
                [
                    'title' =>  __("Subscriptions lists"),
                    'url'   => route('dashboard.subscriptions.index'),
                ],
                [
                    'title' =>  __("Create new Subscription"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.subscriptions.create',[
            'breadcrumb'    =>  $breadcrumb
        ]);
    }

    public function store(CreateSubscriptionsRequest $request) {
        $data = $request->all();
        $data = $this->uploadFiles($request , $data);
        Subscription::create($data);
        return redirect()->route('dashboard.subscriptions.index')->with('success', __("This row has been created."));
    }

    public function edit(Subscription $subscription) {
        $breadcrumb = [
            'title' =>  __("Edit Subscription"),
            'items' =>  [
                [
                    'title' => __("Subscriptions lists"),
                    'url'   => route('dashboard.subscriptions.index'),
                ],
                [
                    'title' =>  __("Edit Subscription"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('dashboard.pages.subscriptions.edit',[
            'breadcrumb'    =>  $breadcrumb,
            'subscription'  =>  $subscription,
        ]);
    }

    public function update(UpdateSubscriptionsRequest $request, Subscription $subscription) {
        $data = $request->all();
        $data = $this->uploadFiles($request , $data);
        $subscription->update($data);
        return redirect()->route('dashboard.subscriptions.index')->with('success', __("This row has been updated."));
    }

    public function destroy(Request $request,Subscription $subscription) {
        $subscription->delete();
        return redirect()->route('dashboard.subscriptions.index')->with('success', __("This row has been deleted."));
    }

    public function uploadFiles($request , $data)
    {
        if(request()->has('image') && !is_null(request('image'))) {
            $data['image'] = imageUpload($request['image'],'subscriptions');
        } else {
            if (isset($request['image'])){
                unset($request['image']);
            }
        }

        return $data;
    }
}
