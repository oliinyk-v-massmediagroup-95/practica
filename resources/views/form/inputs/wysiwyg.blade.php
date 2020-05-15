<div class="form-group">
    <label for="{{$name}}">{{$text}}</label>
    <textarea class="summernote-field" id="{{$name}}" name="{{$name}}" placeholder="{{$text}}" class="wysiwyg-field">{{old($name)?? $value}}</textarea>

</div>

@error($name)
<v-alert type="error">
    {{$message}}
</v-alert>
@enderror
