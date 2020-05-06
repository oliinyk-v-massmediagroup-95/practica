<div class="form-group">
    <label>{{$text}}</label>
    <textarea class="form-control" name="{{$name}}" rows="3" placeholder="Enter ...">{{old($name) ?? $value}}</textarea>
    @error($name)
        <span id="{{$name.'-error'}}" style="display: block" class="error invalid-feedback">{{$message}}</span>
    @enderror
</div>
