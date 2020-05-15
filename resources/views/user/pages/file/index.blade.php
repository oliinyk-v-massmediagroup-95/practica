@extends('user.app')

@section('content')
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <file-table
                    files="{{json_encode($files['data'])}}"
                    create-file-route="{{$createFileRoute}}"
                />

            </div>


        </div>
    </section>
@endsection
