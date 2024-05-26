@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')



<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.stores.update',$store->id) }}" method="post" enctype="multipart/form-data">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingnameInput" value="{{ old('name',$store->name) }}" name="name" placeholder="@lang('Store Name')" />
                        <label for="floatingnameInput">@lang('Store Name')</label>
                        @error('name')
                            <span style="color:red;">
                                {{ $errors->first('name') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingStore_DescInput" value="{{ old('desc',$store->desc) }}" name="desc" placeholder="@lang('Store Desc')" />
                        <label for="floatingStore_DescInput">@lang('Store Desc')</label>
                        @error('desc')
                            <span style="color:red;">
                                {{ $errors->first('desc') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        @php
                            $attrs = $store->categories->toArray() ?? [];
                            $values[] = [];
                            foreach($attrs as $attr) {
                                $values[] = $attr['id'];
                            }
                        @endphp

                        <select name="categories[]" class="form-control select2" multiple>
                            @foreach ($categories as $categry)
                                <option @if(in_array($categry->id,$values)) selected @endif value="{{ $categry->id }}">{{ $categry->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('Categories')</label>
                        @error('categories')
                            <span style="color:red;">
                                {{ $errors->first('categories') }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <label for="user_logo" class="col-form-label col-lg-2">@lang('Logo')</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="file" name="logo" id="user_logo">
                            @error('logo')
                                <span style="color:red;">
                                    {{ $errors->first('logo') }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-1">
                            <img src="{{ display_image_by_model($store,'logo') }}" alt="" class="rounded-circle header-profile-user">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="user_cover" class="col-form-label col-lg-2">@lang('Cover')</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="file" name="cover" id="user_cover">
                            @error('cover')
                                <span style="color:red;">
                                    {{ $errors->first('cover') }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-1">
                            <img src="{{ display_image_by_model($store,'cover') }}" alt="" class="rounded-circle header-profile-user">
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