<div class="form-group">
    <label for="{{$name}}">{{$text}}</label>
    <input type="text" class="form-control" id="{{$name}}" name="{{$name}}" value="{{ old($name) ?? $value}}" placeholder="{{$text}}">

</div>
@error($name)
<v-alert type="error">
    {{$message}}
</v-alert>
@enderror
