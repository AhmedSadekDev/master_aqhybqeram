@extends('dashboard.layouts.master')
@section('PageTile',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')


<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.profile.store') }}" method="post" enctype="multipart/form-data">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingfirst_nameInput" value="{{ old('first_name',$user->first_name) }}" name="first_name" placeholder="@lang('Frist Name')" />
                        <label for="floatingfirst_nameInput">@lang('First Name')</label>
                        @error('first_name')
                            <span style="color:red;">
                                {{ $errors->first('first_name') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatinglast_nameInput" value="{{ old('last_name',$user->last_name) }}" name="last_name" placeholder="@lang('Last Name')" />
                        <label for="floatinglast_nameInput">@lang('Last Name')</label>
                        @error('last_name')
                            <span style="color:red;">
                                {{ $errors->first('last_name') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingEmailInput" name="email" placeholder="@lang('Email Address')" value="{{ old('email',$user->email) }}">
                        <label for="floatingEmailInput">@lang('Email Address')</label>
                        @error('email')
                            <span style="color:red;">
                                {{ $errors->first('email') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPasswordInput" name="password" placeholder="@lang('Password')" />
                        <label for="floatingPasswordInput">@lang('Password')</label>
                        @error('password')
                            <span style="color:red;">
                                {{ $errors->first('password') }}
                            </span>
                        @enderror
                    </div>


                    <div class="row" style=" margin-top: 20px; ">
                        @csrf
                        <div style="text-align: right">
                            <button type="submit" class="btn btn-primary w-md">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div>



@endsection
@push('scripts')

@endpush
