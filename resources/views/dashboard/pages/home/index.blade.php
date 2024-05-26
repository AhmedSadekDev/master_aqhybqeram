@extends('dashboard.layouts.master')
@section('PageTitle',__('Home'))
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')

<div class="row">
    <div class="col-xl-12">
        <div class="row">
            @foreach ($statistic as $item)
                <div class="col-md-{{$item['col']}}">
                    <a href="{{ $item['route'] }}">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">{{$item['title']}}</p>
                                        <h4 class="mb-0">
                                            {{$item['count']}}
                                        </h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx {{ $item['icon'] }} font-size-24"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>



@endsection
@push('scripts')

@endpush