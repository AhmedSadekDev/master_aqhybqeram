<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use App\Helpers\API\API;

class CheckUserSubscription
{

    public function handle(Request $request, Closure $next, ...$guards)
    {
        // if(request()->is('*api*')) {
        //     if(auth()->check()) {
        //         $item = auth()->user()->subscriptions()->where('active',1)->first();
        //         if(is_null($item)) {
        //             return (new API())->isError(__('برجاء الإشتراك أولا'))->build();
        //         }
        //     }
        // }
        return $next($request);
    }

}
