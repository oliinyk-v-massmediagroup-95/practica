<div class="form-group">
    <label>{{$text}}</label>
    <textarea class="form-control" name="{{$name}}" rows="3" placeholder="Enter ...">{{old($name) ?? $value}}</textarea>

</div>
@error($name)
<v-alert type="error">
    {{$message}}
</v-alert>
@enderror
