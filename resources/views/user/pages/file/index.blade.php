@extends('user.app')

@section('content')
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-size: 1.9rem">Files List</h3>


                            <div class="card-tools">
                                <a href="{{route('user.file.create')}}" class="btn btn-success margin">Create</a>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Operations</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($files as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->original_name}}</td>
                                        <td><img class="table-user__image" src="{{$item->getUrlPath()}}"></td>
                                        <td>
                                            <form action="{{ route('user.file.destroy', ['file' => $item]) }}"
                                                  method="POST">
                                                <a href="{{ route('user.file.edit', ['file' => $item]) }}"
                                                   class="btn bg-purple margin">Edit</a>
                                                {{method_field('DELETE')}}
                                                @csrf
                                                <button value="{{$item->id}}" name="id"
                                                        class="btn bg-maroon margin item-delete__btn">Delete
                                                </button>
                                                <a href="{{route('user.file.show', ['file' => $item])}}"
                                                   class="btn-default btn">Show</a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>


        </div>
    </section>
@endsection
