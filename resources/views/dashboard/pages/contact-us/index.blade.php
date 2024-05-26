@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')



<div style=" margin-bottom: 14px; position: relative; text-align: left; ">
    <button
        class="btn btn-primary my-action"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasWithBothOptionsFilter"
        data-title="@lang('Filter')"
        aria-controls="offcanvasWithBothOptionsFilter"><i class="bx bx-filter-alt"></i></button>
</div>

@if ($lists->count() > 0)


    <div class="row">
        <div class="col-lg-12">
            <div class="">
                <div class="table-responsive">
                    <table class="table project-list-table table-nowrap align-middle table-borderless">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 100px">#</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        {{ $list->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $list->name ?? '' }}
                                    </td>
                                    <td>
                                        {!! $list->showStatus() !!}
                                    </td>
                                    <td>
                                        {{ $list->created_at->format('d-m-Y') }}
                                    </td>
                                    <td style="display: inline-flex;">
                                        <a style="margin-left: 5px;" 
                                            class="btn btn-outline-success btn-sm edit" 
                                            href="{{ route('dashboard.contact-us.show',$list->id) }}">
                                            <i class="bx bx-comment-dots"></i>
                                        </a>
                                        {!! action_table_delete(route('dashboard.contact-us.destroy',$list->id),$list->id) !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $lists->links('dashboard.layouts.inc.paginator') }}

@else

    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <div class="row justify-content-center mt-5">
                    <div class="col-sm-4">
                        <div class="maintenance-img">
                            <img src="{{ url('assets/images/verification-img.png') }}" alt="" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                </div>
                <h4 class="mt-5">@lang("Let's get started")</h4>
                <p class="text-muted">@lang("Oops, We don't have data").</p>
            </div>
        </div>
    </div>

@endif


<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptionsFilter" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">@lang('Filter')</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('dashboard.contact-us.index') }}" method="get" enctype="multipart/form-data">

            <div class="mb-3 row">
                <div class="col-md-12">
                    <input class="form-control" value="{{ old('name') }}" name="name" type="name" placeholder="@lang('Search by name or email')"
                        id="example-text-input">
                </div>
            </div>
                
            <div class="row" style="margin-top: 20px">
                <div class="col-md-12">
                    <select name="status" class="form-select">
                        <option @if(!request()->has('status')) selcted @endif value="2" disabled>@lang('Select status')</option>
                        <option @if(request()->has('status') && request('status') == "1") selcted @endif value="1">{{ __('Seen') }}</option>
                        <option @if(request()->has('status') && request('status') == "0") selcted @endif value="0">{{ __('Unseen') }}</option>
                    </select>
                </div>
            </div>

            <div class="row" style=" margin-top: 20px; ">
                <div style="text-align: right">
                    <a href="{{ route('dashboard.contact-us.index') }}" style=" float: left; " class="btn btn-primary w-md">
                        @lang('Reset')
                    </a>
                    <button type="submit" class="btn btn-primary w-md">@lang('Submit')</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection