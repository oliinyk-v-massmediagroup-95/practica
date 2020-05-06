<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-gray">
        <div class="card-header">
            <h3 class="card-title">{{$text ?? 'Form'}}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="{{$action}}" method="{{$method}}"  {!! isset($enctype) && $enctype ? 'enctype="multipart/form-data"' : '' !!}>
            <div class="card-body">
                @csrf
                {{ method_field($method_field) }}

