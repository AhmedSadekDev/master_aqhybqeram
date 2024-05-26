@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')



<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('dashboard.sliders.update',$slider->id) }}" method="post" enctype="multipart/form-data">

                    <div class="row">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" value="{{ old('name',$slider->name) }}" id="floatingnameInput" name="name" placeholder="@lang('Name')" />
                            <label for="floatingnameInput">@lang('Name')</label>
                            @error('name')
                                <span style="color:red;">
                                    {{ $errors->first('name') }}
                                </span>
                            @enderror
                        </div>
    
                        <div class="mb-3 row">
                            <label for="user_avatar" class="col-form-label col-lg-2">@lang('Image')</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="file" name="image" id="user_avatar">
                                @error('image')
                                    <span style="color:red;">
                                        {{ $errors->first('image') }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-1">
                                <img src="{{ display_image_by_model($slider,'image') }}" alt="" class="rounded-circle header-profile-user">
                            </div>
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
