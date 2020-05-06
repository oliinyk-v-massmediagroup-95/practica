<div class="form-group">
    <label for="{{$name}}">{{$text}}</label>
    <input type="text" class="form-control" id="{{$name}}" name="{{$name}}" value="{{ old($name) ?? $value}}" placeholder="{{$text}}">
    @error($name)
    <span id="{{$name.'-error'}}" style="display: block" class="error invalid-feedback">{{$message}}</span>
    @enderror
</div>
