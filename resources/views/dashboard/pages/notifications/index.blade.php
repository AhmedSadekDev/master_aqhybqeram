@extends('dashboard.layouts.master')
@section('PageTitle',$breadcrumb['title'])
@section('PageContent')
@includeIf('dashboard.layouts.inc.breadcrumb')



<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('dashboard.notifications.store') }}" method="post" enctype="multipart/form-data">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingfirst_nameInput" name="title" placeholder="@lang('عنوان الرسالة')" />
                        <label for="floatingfirst_nameInput">@lang('عنوان الرسالة')</label>
                        @error('title')
                            <span style="color:red;">
                                {{ $errors->first('title') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <textarea name="message" placeholder="@lang('نص الرساله')" class="form-control" id="floatinglast_nameInput" cols="30" rows="10"></textarea>
                        <label for="floatinglast_nameInput">@lang('نص الرساله')</label>
                        @error('message')
                            <span style="color:red;">
                                {{ $errors->first('message') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <select name="customer" class="form-select">
                            <option value="0">جميع العملاء</option>
                            @foreach ($lists as $list)
                                <option value="{{ $list->id }}">{{ $list->first_name }} {{ $list->last_name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('العملاء')</label>
                        @error('customer')
                            <span style="color:red;">
                                {{ $errors->first('customer') }}
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
            height: 20px !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="assets/libs/select2/js/select2.min.js"></script>
    <script src="assets/js/pages/form-advanced.init.js"></script>
    <script>
        $('select').select2();
    </script>
@endpush