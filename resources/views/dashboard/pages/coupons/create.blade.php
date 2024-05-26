@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')



<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.coupons.store') }}" method="post" enctype="multipart/form-data">

                    <div class="form-floating mb-3">
                        <select name="store_id" class="form-select">
                            <option value="0">{{ __('Choose Store') }}</option>
                            @foreach ($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('Stores')</label>
                        @error('store_id')
                            <span style="color:red;">
                                {{ $errors->first('store_id') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{ old('name') }}" id="floatingPriceInput" name="name" placeholder="@lang('Coupon Name')" />
                        <label for="floatingPriceInput">@lang('Name')</label>
                        @error('name')
                            <span style="color:red;">
                                {{ $errors->first('name') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{ old('desc') }}" id="floatingPriceInput" name="desc" placeholder="@lang('Coupon Desc')" />
                        <label for="floatingPriceInput">@lang('Coupon Desc')</label>
                        @error('desc')
                            <span style="color:red;">
                                {{ $errors->first('desc') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingnameInput" name="code" placeholder="@lang('Coupon Code')" value="{{ old('code') }}">
                        <label for="floatingnameInput">@lang('Coupon Code')</label>
                        @error('code')
                            <span style="color:red;">
                                {{ $errors->first('code') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="floatingexpireInput" name="expire" placeholder="@lang('Coupon Expire')" value="{{ old('expire') }}">
                        <label for="floatingexpireInput">@lang('Coupon Expire')</label>
                        @error('expire')
                            <span style="color:red;">
                                {{ $errors->first('expire') }}
                            </span>
                        @enderror
                    </div>

                    <div class="row" style=" margin-top: 20px; ">
                        <div style="text-align: right">
                            @csrf
                            <button type="submit" class="btn btn-primary w-md">@lang('Submit')</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div>


@endsection

@push('styles')
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="assets/libs/select2/js/select2.min.js"></script>
    <script src="assets/js/pages/form-advanced.init.js"></script>
@endpush