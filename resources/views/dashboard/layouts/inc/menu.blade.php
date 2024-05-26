<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('Menu')</li>
                <li>
                    <a href="{{ route('dashboard.home') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">
                            @lang('Statictis')
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.admins.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('Admins')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.customers.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('Customers')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.stores.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('Stores')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.subscriptions.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('Subscriptions')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.sliders.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('Sliders')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.intros.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('صفحات الإفتتاحيه')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.contact-us.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('Contact')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.categories.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('Categories')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.coupons.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('Coupons')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.contents.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('Contents')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.notifications.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('الإشعارات')</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
