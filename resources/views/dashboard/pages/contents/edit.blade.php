@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')



<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('dashboard.contents.update',$content->id) }}" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingnameInput" name="title" placeholder="@lang('title')" value="{{ old('title',$content->title) }}">
                            <label for="floatingnameInput">@lang('title')</label>
                            @error('title')
                                <span style="color:red;">
                                    {{ $errors->first('title') }}
                                </span>
                            @enderror
                        </div>
    
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="floatingnameInput" name="value" placeholder="@lang('value')" cols="30" rows="10">{{ old('value',$content->value) }}</textarea>
                            <label for="floatingnameInput">@lang('value')</label>
                            @error('value')
                                <span style="color:red;">
                                    {{ $errors->first('value') }}
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
