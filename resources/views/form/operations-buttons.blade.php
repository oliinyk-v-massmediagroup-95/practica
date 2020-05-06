
<form action="{{ route('admin.'.$folder.'.destroy', [$folder => $model ]) }}" method="POST">
    <a href="{{ route('admin.'.$folder.'.edit', [$folder => $model ]) }}" class="btn bg-purple margin">Edit</a>
    {{method_field('DELETE')}}
    @csrf
    <button value="{{$model->id}}" name="id" class="btn bg-maroon margin">Delete</button>
</form>
