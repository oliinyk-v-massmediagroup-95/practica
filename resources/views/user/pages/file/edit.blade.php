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

                {!! Form::open(['action' => route('user.file.update', ['file' => $file]), 'method' => 'PATCH', 'enctype' => true]); !!}

                <p><img src="{{ $file->getUrlPath() }}"></p>
                <p>{{ $file->original_name }}</p>

                {!! Form::file(['name' => 'file', 'text'=>'File', 'value' => $file->name]) !!}

                {!! Form::date([
                        'name' => 'delete_date',
                        'text' => 'Delete date',
                        'value' => isset($file->delete_date) ? $file->delete_date->format('m/d/Y') : $file->delete_date
                ]) !!}

                @if(isset($comment))
                {!! Form::textarea(['name' => 'comment', 'text'=> 'Comment', 'value' => $comment->text]) !!}
                @endif

                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection
