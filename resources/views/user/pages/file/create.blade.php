@extends('user.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>File Create</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                {!! Form::open(['action' => route('user.file.store'), 'method' => 'POST', 'enctype' => true]); !!}

                {!! Form::file(['name' => 'file', 'text'=>'File']) !!}

                {!! Form::date(['name' => 'delete_date', 'text' => 'Delete date']) !!}

                {!! Form::textarea(['name' => 'comment', 'text'=> 'Comment']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection
