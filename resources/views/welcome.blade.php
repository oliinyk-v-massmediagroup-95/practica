@extends('user.app')

@section('content')

        {{--        <div class="flex-center position-ref full-height">--}}
        {{--            @if (Route::has('login'))--}}
        {{--                <div class="top-right links">--}}
        {{--                    @auth--}}
        {{--                        <a href="{{ route('user.file.index') }}">Home</a>--}}
        {{--                    @else--}}
        {{--                        <a href="{{ route('login') }}">Login</a>--}}

        {{--                        @if (Route::has('register'))--}}
        {{--                            <a href="{{ route('register') }}">Register</a>--}}
        {{--                        @endif--}}
        {{--                    @endauth--}}
        {{--                </div>--}}
        {{--            @endif--}}
        {{--            <div class="content">--}}

        {{--                <example-component></example-component>--}}

        {{--            </div>--}}
        {{--        </div>--}}


            <v-container
                class="fill-height"
                fluid
            >
                <v-row
                    align="center"
                    justify="center"
                >
                    <v-col class="text-center">
                        <v-tooltip left>
                            <template v-slot:activator="{ on }">
                                <v-btn
                                    :href="source"
                                    icon
                                    large
                                    target="_blank"
                                    v-on="on"
                                >
                                    <v-icon large>mdi-code-tags</v-icon>
                                </v-btn>
                            </template>
                            <span>Source</span>
                        </v-tooltip>
                    </v-col>
                </v-row>
            </v-container>
@endsection
