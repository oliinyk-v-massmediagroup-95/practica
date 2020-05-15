<div class="form-group">
{{--    <label for="{{$name}}">{{$text}}</label>--}}
    <input type="file" name="{{$name}}" id="{{$name}}" {{isset($multiple) && $multiple ? 'multiple' : ''}}>

</div>
@error($name)
<v-alert type="error">
    {{$message}}
</v-alert>
@enderror
