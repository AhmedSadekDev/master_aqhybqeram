@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')

<div style=" margin-bottom: 14px; position: relative; text-align: left; ">
    <a type="button" class="btn btn-primary my-action"  href="{{route('dashboard.intros.create')}}">@lang('Create new intro')</a>
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
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        <img src="{{ display_image_by_model($list,'image') }}" alt="" class="avatar-sm">
                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14"><a href="{{route('dashboard.intros.edit' , $list->id)}}" class="text-dark">{{ $list->name ?? '' }}</a></h5>
                                    </td>
                                    <td>
                                        {{ $list->created_at->format('d-m-Y') }}
                                    </td>
                                    <td style="display: inline-flex;">
                                        <a style="margin-left: 5px;" 
                                            class="btn btn-outline-secondary btn-sm edit" 
                                            href="{{ route('dashboard.intros.edit',$list->id) }}">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                        {!! action_table_delete(route('dashboard.intros.destroy',$list->id),$list->id) !!}
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

@endsection