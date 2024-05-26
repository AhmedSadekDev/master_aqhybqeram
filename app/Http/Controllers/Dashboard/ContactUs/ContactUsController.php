<?php

namespace App\Http\Controllers\Dashboard\ContactUs;

use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Contact\CreateNewMessageRequest;
// Models
use App\Models\Contact;

class ContactUsController extends Controller
{
    public function index(Request $request) {
        $breadcrumb = [
            'title' =>  __("Messages lists"),
            'items' =>  [
                [
                    'title' =>  __("Messages lists"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = new Contact;
        if(request()->has('status') && request('status') != "2") {
            $lists = $lists->where('seen',$request->status);
        }
        if(request()->has('name')) {
            if(filter_var(request('name'), FILTER_VALIDATE_EMAIL)) {
                $lists = $lists->where('email','like','%'.$request->name.'%');
            } else {
                $lists = $lists->where('name','like','%'.$request->name.'%');
            }
        }
        $lists = $lists->orderBy('id','desc')->paginate();
        return view('dashboard.pages.contact-us.index',[
            'breadcrumb'    =>  $breadcrumb,
            'lists'         =>  $lists,
        ]);
    }

    public function show(Contact $contact_u) {
        if($contact_u->seen != 1) {
            $contact_u->update([
                'seen'    => 1
            ]);
        }
        $breadcrumb = [
            'title' =>  __("Show message"),
            'items' =>  [
                [
                    'title' =>  __("Messages lists"),
                    'url'   =>  route('dashboard.contact-us.index'),
                ],
                [
                    'title' =>  __("Show message"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        return view('dashboard.pages.contact-us.show',[
            'breadcrumb'=>$breadcrumb,
            'contact_u'=>$contact_u,
        ]);
    }

    public function destroy(Request $request,Contact $contact_u) {
        $contact_u->delete();
        return redirect()->route('dashboard.contact-us.index')->with('success', __("This message has been deleted."));
    }
}
