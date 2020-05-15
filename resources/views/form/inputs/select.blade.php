<div class="form-group">
    <label>{{$text}}</label>
    <select class="form-control select2" name="{{$name}}" style="width: 100%;">
        <option selected disabled value="">Select Value</option>
        @foreach($options as $key=>$value)
            <option {{$selectedKey === $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
        @endforeach
    </select>

</div>
@error($name)
<v-alert type="error">
    {{$message}}
</v-alert>
@enderror
