<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="direction:rtl">
<head>
    @includeIf('dashboard.layouts.inc.head') 
</head>
<body data-sidebar="dark">
     <!-- Loader -->
     <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    <div id="layout-wrapper">
        @includeIf('dashboard.layouts.inc.header') 
        @includeIf('dashboard.layouts.inc.menu') 
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('PageContent')
                    @includeIf('ldashboard.ayouts.inc.footer') 
                </div>
            </div>
        </div>
    </div>
    @includeIf('dashboard.layouts.inc.footer')
    @includeIf('dashboard.layouts.inc.right-bar')
    @includeIf('dashboard.layouts.inc.scripts')
</body>
</html>
