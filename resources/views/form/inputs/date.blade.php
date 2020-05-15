<div class="form-group">
    <label>{{$text}}:</label>

    <div class="input-group date">
        <input type="text" value="{{ old($name) ?? $value}}" name="{{$name}}" placeholder="00/00/0000" class="form-control pull-right" id="datepicker">
    </div>
    <!-- /.input group -->


</div>

@error($name)
<v-alert type="error">
    {{$message}}
</v-alert>
@enderror
