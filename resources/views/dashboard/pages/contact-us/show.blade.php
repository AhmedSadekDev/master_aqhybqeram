@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')



<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body" style=" position: relative; ">
                <h5 class="font-size-15">@lang('Message Details') :</h5>
                <p class="text-muted">
                    {!! $contact_u->message !!}
                </p>
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
                                {{ $contact_u->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Email')
                            </td>
                            <td>
                                <a href="mailto:{{ $contact_u->email }}">{{ $contact_u->email }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Status')
                            </td>
                            <td>
                                {!! $contact_u->showStatus() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Created At')
                            </td>
                            <td>
                                {{ $contact_u->created_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection