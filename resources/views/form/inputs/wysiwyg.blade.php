<div class="form-group">
    <label for="{{$name}}">{{$text}}</label>
    <textarea class="summernote-field" id="{{$name}}" name="{{$name}}" placeholder="{{$text}}" class="wysiwyg-field">{{old($name)?? $value}}</textarea>
    @error($name)
    <span id="{{$name.'-error'}}" style="display: block" class="error invalid-feedback">{{$message}}</span>
    @enderror
</div>

