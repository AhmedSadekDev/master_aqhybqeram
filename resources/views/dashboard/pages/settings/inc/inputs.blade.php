@isset($form['inputs'])
    @foreach ($form['inputs'] as $item)
        @if ($item['type'] == 'select')
            
        @elseif ($item['type'] == 'image')
        <div class="mb-3 row">
            <label for="user_avatar" class="col-form-label col-lg-2">@lang($item['label'])</label>
            <div class="col-lg-9">
                <input class="form-control" type="file" name="{{ $item['name'] }}" id="user_avatar">
                @error($item['name'])
                    <span style="color:red;">
                        {{ $errors->first($item['name']) }}
                    </span>
                @enderror
            </div>
            <div class="col-lg-1">
                <img src="{{ getSettings($item['name']) }}" alt="" class="rounded-circle header-profile-user">
            </div>
        </div>
        @else

            <div class="form-floating mb-3">
                <input type="{{$item['type']}}" class="form-control" id="floatingnameInput" value="{{ getSettings($item['name']) }}" name="{{ $item['name'] }}" placeholder={{ __($item['placeholder']) }}" />
                <label for="floatingnameInput">{{ $item['label'] }}</label>
                @error($item['name'])
                    <span style="color:red;">
                        {{ $errors->first($item['name']) }}
                    </span>
                @enderror
            </div>
        @endif
    @endforeach
@endisset