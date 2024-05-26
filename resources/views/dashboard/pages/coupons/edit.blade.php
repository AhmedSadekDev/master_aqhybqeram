@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')



<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.coupons.update',$coupon->id) }}" method="post" enctype="multipart/form-data">


                    
                    <div class="form-floating mb-3">
                        <select name="store_id" class="form-select">
                            <option value="0">{{ __('Choose Store') }}</option>
                            @foreach ($stores as $store)
                                <option @if($store->id == $coupon->store_id) selected @endif value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('stores')</label>
                        @error('store_id')
                            <span style="color:red;">
                                {{ $errors->first('store_id') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{ old('name',$coupon->name) }}" id="floatingPriceInput" name="name" placeholder="@lang('Coupon Name')" />
                        <label for="floatingPriceInput">@lang('Name')</label>
                        @error('name')
                            <span style="color:red;">
                                {{ $errors->first('name') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{ old('desc',$coupon->desc) }}" id="floatingPriceInput" name="desc" placeholder="@lang('Coupon Desc')" />
                        <label for="floatingPriceInput">@lang('Coupon Desc')</label>
                        @error('desc')
                            <span style="color:red;">
                                {{ $errors->first('desc') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingnameInput" name="code" placeholder="@lang('Coupon Code')" value="{{ old('code',$coupon->code) }}">
                        <label for="floatingnameInput">@lang('Coupon Code')</label>
                        @error('code')
                            <span style="color:red;">
                                {{ $errors->first('code') }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4 row">
                        <div class="col-md-12">
                            <div class="input-group" id="datepicker1">
                                <input type="text" name="expire" class="form-control" placeholder="dd M, yyyy" value="{{ old('expire',$coupon->expire) }}"
                                    data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-provide="datepicker">

                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                            @error('expire')
                                <span style="color:red;">
                                    {{ $errors->first('expire') }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    

                    <div class="row" style=" margin-top: 20px; ">
                        <div style="text-align: right">
                            @csrf
                            @method('PUT')
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
    <link href="assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/libs/@chenfengyuan/datepicker/datepicker.min.css">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="assets/libs/select2/js/select2.min.js"></script>
    <script src="assets/js/pages/form-advanced.init.js"></script>
    <script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/libs/@chenfengyuan/datepicker/datepicker.min.js"></script>
@endpush