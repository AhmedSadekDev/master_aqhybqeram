<?php

namespace App\Http\Controllers\Dashboard\Home;

use App\Http\Controllers\Controller;
// Models
use App\Models\User;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Store;
use App\Models\Coupon;
use App\Models\Subscription;
// Auth
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {

        $statistic = [
            [
                'title'     => __('Admins'),
                'icon'      => 'bxs-archive',
                'count'     => User::where('user_type',User::TYPE_ADMIN)->count(),
                'route'     => route('dashboard.admins.index'),
                'col'       => 4
            ],
            [
                'title'     => __('Customers'),
                'icon'      => 'bxs-archive',
                'count'     => User::where('user_type',User::TYPE_CUSTOMER)->count(),
                'route'     => route('dashboard.customers.index'),
                'col'       => 4
            ],
            [
                'title'     => __('Contact'),
                'icon'      => 'bxs-archive',
                'count'     => Contact::where('seen',0)->count(),
                'route'     => route('dashboard.contact-us.index'),
                'col'       => 4
            ],
            [
                'title'     => __('Categories'),
                'icon'      => 'bxs-archive',
                'count'     => Category::count(),
                'route'     => route('dashboard.categories.index'),
                'col'       => 4
            ],
            [
                'title'     => __('Subscriptions'),
                'icon'      => 'bxs-archive',
                'count'     => Subscription::count(),
                'route'     => route('dashboard.subscriptions.index'),
                'col'       => 4
            ],
            [
                'title'     => __('Sliders'),
                'icon'      => 'bxs-archive',
                'count'     => Slider::count(),
                'route'     => route('dashboard.sliders.index'),
                'col'       => 4
            ],
            [
                'title'     => __('Stores'),
                'icon'      => 'bxs-archive',
                'count'     => Store::count(),
                'route'     => route('dashboard.stores.index'),
                'col'       => 4
            ],
            [
                'title'     => __('Coupons'),
                'icon'      => 'bxs-archive',
                'count'     => Coupon::count(),
                'route'     => route('dashboard.coupons.index'),
                'col'       => 4
            ],
        ];
        return view('dashboard.pages.home.index' , get_defined_vars());
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
