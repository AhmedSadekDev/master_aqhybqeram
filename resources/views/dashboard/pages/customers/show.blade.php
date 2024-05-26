@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')



<div class="row">
    <div class="col-lg-8">
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Name')</th>
                            <th scope="col">@lang('Start')</th>
                            <th scope="col">@lang('End')</th>
                            <th scope="col">@lang('Price')</th>
                            <th scope="col">@lang('Status')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lists as $list)
                            <tr>
                                <td>
                                   {{ $list->subscription->name ?? '' }}
                                </td>
                                <td>
                                   {{ $list->start }}
                                </td>
                                <td>
                                   {{ $list->end }}
                                </td>
                                <td>
                                   {{ $list->price }}
                                </td>
                                <td>
                                   {!! $list->showStatus() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $lists->links('dashboard.layouts.inc.paginator') }}
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">##</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @lang('Name')
                            </td>
                            <td>
                                {{ $customer->first_name }} {{ $customer->last_name }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Email')
                            </td>
                            <td>
                                <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                الجوال
                            </td>
                            <td>
                                <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('تفعيل الجوال')
                            </td>
                            <td>
                                {!! $customer->phoneVerified() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('إستكمال البيانات')
                            </td>
                            <td>
                                {!! $customer->completedData() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Created At')
                            </td>
                            <td>
                                {{ $customer->created_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection