@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')



<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('dashboard.admins.store') }}" method="post" enctype="multipart/form-data">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingfirst_nameInput" name="first_name" placeholder="@lang('Frist Name')" />
                        <label for="floatingfirst_nameInput">@lang('First Name')</label>
                        @error('first_name')
                            <span style="color:red;">
                                {{ $errors->first('first_name') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatinglast_nameInput" name="last_name" placeholder="@lang('Last Name')" />
                        <label for="floatinglast_nameInput">@lang('Last Name')</label>
                        @error('last_name')
                            <span style="color:red;">
                                {{ $errors->first('last_name') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingemailInput" name="email" placeholder="@lang('Email Address')" />
                        <label for="floatingemailInput">@lang('Email Address')</label> 
                        @error('email')
                            <span style="color:red;">
                                {{ $errors->first('email') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingPhoneInput" name="phone" placeholder="@lang('Phone Number')" />
                        <label for="floatingPhoneInput">@lang('Phone Number')</label> 
                        @error('number')
                            <span style="color:red;">
                                {{ $errors->first('number') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingpasswordInput" name="password" placeholder="@lang('Password')" />
                        <label for="floatingpasswordInput">@lang('Password')</label>
                        @error('password')
                            <span style="color:red;">
                                {{ $errors->first('password') }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <label for="user_avatar" class="col-form-label col-lg-2">@lang('Avatar')</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="file" name="avatar" id="user_avatar">
                            @error('avatar')
                                <span style="color:red;">
                                    {{ $errors->first('avatar') }}
                                </span>
                            @enderror
                        </div>
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

