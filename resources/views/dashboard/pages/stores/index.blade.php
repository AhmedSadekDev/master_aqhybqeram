@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')

<div style=" margin-bottom: 14px; position: relative; text-align: left; ">
    <a type="button" class="btn btn-primary"  href="{{route('dashboard.stores.create')}}">@lang('Create New Store')</a>
</div>

@if ($lists->count() > 0)

    <div class="row">
        <div class="col-lg-12">
            <div class="">
                <div class="table-responsive">
                    <table class="table project-list-table table-nowrap align-middle table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('التقيم')</th>
                                <th scope="col">@lang('عرض')</th>
                                <th scope="col">@lang('اكتر اختيارا')</th>
                                <th scope="col">@lang('موصي به')</th>
                                <th scope="col">@lang('عرض لا يفوت')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        <a href="{{ route('dashboard.stores.edit',$list->id) }}">
                                            {{ $list->name ?? '' }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $list->rate }}
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.stores.offer',$list->id) }}">
                                            {!! $list->showOffer() !!}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.stores.more_choice',$list->id) }}">
                                            {!! $list->showMoreChoice() !!}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.stores.recommend',$list->id) }}">
                                            {!! $list->showRecommend() !!}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.stores.unmissable_offer',$list->id) }}">
                                            {!! $list->showUnmissableOffer() !!}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $list->created_at}}
                                    </td>
                                    <td style="display: inline-flex;">
                                        <a style="margin-left: 5px;"
                                            class="btn btn-outline-secondary btn-sm edit"
                                            href="{{ route('dashboard.stores.rates.index',$list->id) }}">
                                            <i class="bx bx-star"></i>
                                        </a>
                                        <a style="margin-left: 5px;"
                                            class="btn btn-outline-secondary btn-sm edit"
                                            href="{{ route('dashboard.stores.edit',$list->id) }}">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                        {!! action_table_delete(route('dashboard.stores.destroy',$list->id),$list->id) !!}
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
                            <img src="{{ url('assets/images/123.svg') }}" alt="" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                </div>
                <h4 class="mt-5">@lang("Let's get started")</h4>
                <p class="text-muted">@lang("Oops, We don't have data").</p>
            </div>
        </div>
    </div>


@endif


@endsection
