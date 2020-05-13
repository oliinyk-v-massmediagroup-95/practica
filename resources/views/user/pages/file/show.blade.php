@extends('user.app')

@section('content')
    <section class="content-header">
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Custom Tabs -->
                    <div class="card">

                        <div class="card-header d-flex p-0">
                            <h4 class="p-3">{{$file->original_name}}</h4>

                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <p><img class="img-fluid" style="  display: block;margin-left: auto; margin-right: auto;
                                        width: 50%; max-height: 450px; object-fit: cover"
                                        src="{{ $file->getUrlPath() }}"
                                        alt="Photo"></p>
                                @if($file->delete_date)
                                    <p>Delete Date: {{$file->delete_date->format('m/d/Y')}}</p>
                                @endif
                                @if($file->comments->count())
                                    <div class="active">
                                        <div class="row mt-4">
                                            <nav class="w-100">
                                                <div class="nav nav-tabs">
                                                    <a class="nav-item nav-link active">Comments</a>
                                                    <form action="{{ route('user.file.destroy', ['file' => $file]) }}"
                                                          method="POST">
                                                        {{method_field('DELETE')}}
                                                        @csrf
                                                        <button value="{{$file->id}}" name="id"
                                                                class="btn-danger nav-item nav-link item-delete__btn">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </nav>
                                            <div class="tab-content p-3 w-100">
                                                <div class="card-body">
                                                    <div class="tab-content comment-block">
                                                        @foreach($file->comments as $key => $comment)
                                                            <div class="active sub-comments__content">
                                                                <div class="post">
                                                                    <div class="user-block">
                                                                        <img class="img-circle img-bordered-sm"
                                                                             src="/assets/dist/img/avatar-comment.png"
                                                                             style="object-fit: cover;"
                                                                             alt="user image">
                                                                        <span class="username">
                                                                            <a href="#">
                                                                                {{$comment->user_id == $file->user_id ? 'Author' : ' Anon #'.$key}}
                                                                            </a>
                                                                        </span>
                                                                    </div>
                                                                    <p>
                                                                        {{ $comment->text }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                            @endif
                            <!-- /.tab-pane -->
                            </div>

                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->

                    <div class='card link-block'>
                        <div class="card-header d-flex p-0">
                            <h4 class="p-3">Multi Time Links</h4>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <ul class="generated-links">
                                    @foreach($multiTimeLinks['data'] as $link)
                                        <li>
                                            <a href="{{$link['accessLink']}}">{{$link['accessLink']}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                {{--                                    @foreach(range(1, 1) as $link)--}}
                                {{--                                        <h6>test</h6>--}}
                                {{--                                    @endforeach--}}
                            </div>

                            <div class="row">
                                <div class="col col-2">
                                    <form class="create-link" method="POST" action="{{route('api.user.link.create')}}">
                                        {{csrf_field()}}
                                        <input type="hidden" name="only_once" value="{{ $MULTI_TIME_LINK }}">
                                        <input type="hidden" name="api_token" value="{{$user->api_token}}">
                                        <input type="hidden" name="file_id" value="{{$file->id}}">
                                        <button class="btn btn-success">Create Multi-Time Link</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='card link-block'>
                        <div class="card-header d-flex p-0">
                            <h4 class="p-3">One Time Links</h4>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <ul class="generated-links">
                                    @foreach($oneTimeLinks['data'] as $link)
                                        <li>
                                            <a href="{{$link['accessLink']}}">{{$link['accessLink']}}</a>
                                            @if($link['isVisited'])<span> (Used)</span>@endif
                                        </li>
                                    @endforeach
                                </ul>
                                {{--                                    @foreach(range(1, 1) as $link)--}}
                                {{--                                        <h6>test</h6>--}}
                                {{--                                    @endforeach--}}
                            </div>

                            <div class="row">
                                <div class="col col-2">
                                    <form class="create-link" method="POST" action="{{route('api.user.link.create')}}">
                                        {{csrf_field()}}
                                        <input type="hidden" name="only_once" value="{{ $ONE_TIME_LINK }}">
                                        <input type="hidden" name="api_token" value="{{$user->api_token}}">
                                        <input type="hidden" name="file_id" value="{{$file->id}}">
                                        <button class="btn btn-success">Create One-Time Link</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
