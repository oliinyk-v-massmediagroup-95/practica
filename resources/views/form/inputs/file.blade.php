<div class="form-group">
{{--    <label for="{{$name}}">{{$text}}</label>--}}
    <input type="file" name="{{$name}}" id="{{$name}}" {{isset($multiple) && $multiple ? 'multiple' : ''}}>
    @error($name)
        <span id="{{$name.'-error'}}" style="display: block" class="error invalid-feedback">{{$message}}</span>
    @enderror
</div>
