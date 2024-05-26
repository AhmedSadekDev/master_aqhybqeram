@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')



<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.subscriptions.update',$subscription->id) }}" method="post" enctype="multipart/form-data">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingnameInput" value="{{ old('name',$subscription->name) }}" name="name" placeholder="@lang('Subscription Name')" />
                        <label for="floatingnameInput">@lang('Subscription Name')</label>
                        @error('name')
                            <span style="color:red;">
                                {{ $errors->first('name') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingStore_DescInput" value="{{ old('price',$subscription->price) }}" name="price" placeholder="@lang('Subscription Price')" />
                        <label for="floatingStore_DescInput">@lang('Subscription Price')</label>
                        @error('price')
                            <span style="color:red;">
                                {{ $errors->first('price') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingMonthInput" value="{{ old('month',$subscription->month) }}" name="month" placeholder="@lang('Subscription Month')" />
                        <label for="floatingMonthInput">@lang('Subscription Month')</label>
                        @error('month')
                            <span style="color:red;">
                                {{ $errors->first('month') }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <label for="user_image" class="col-form-label col-lg-2">@lang('Image')</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="file" name="image" id="user_image">
                            @error('image')
                                <span style="color:red;">
                                    {{ $errors->first('image') }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-1">
                            <img src="{{ display_image_by_model($subscription,'image') }}" alt="" class="rounded-circle header-profile-user">
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
