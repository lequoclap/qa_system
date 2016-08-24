@extends('layouts.main')

@section('body')
    <body style="background:#F7F7F7;">

    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
                    @if(Session::has(\Classes\Constants::MSG_TYPE_INFO))
                        <div class="alert alert-info">
                            {{Session::get(\Classes\Constants::MSG_TYPE_INFO)}}
                        </div>
                    @elseif (Session::has(\Classes\Constants::MSG_TYPE_WARNING))
                        <div class="alert alert-warning">
                            {{Session::get(\Classes\Constants::MSG_TYPE_WARNING)}}
                        </div>
                    @elseif (Session::has(\Classes\Constants::MSG_TYPE_ERROR))
                        <div class="alert alert-danger">
                            {{Session::get(\Classes\Constants::MSG_TYPE_ERROR)}}
                        </div>
                    @endif
                    <form method="POST" action="/login">
                        <h1>LOGIN</h1>
                        {{csrf_field()}}
                        <div>
                            <input type="text" class="form-control" name="email" placeholder="Your mail address" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" name="password" placeholder="Password" required="" />
                        </div>
                        <div>
                            <button class="btn btn-default submit" type="submit">ログイン</button>
                        </div>
                        <div>
                            <a href="/register">Create new account</a>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        </div>
    </div>

    </body>
@stop