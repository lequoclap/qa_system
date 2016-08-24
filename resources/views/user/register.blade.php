@extends('layouts.main')

@section('body')
    <body style="background:#F7F7F7;">

    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
                    <form method="POST" action="/register">
                        <h1>REGISTER</h1>
                        {{csrf_field()}}
                        <div>
                            <input type="text" class="form-control" name="email" placeholder="Your mail address" required="" />
                        </div>
                        <div>
                            <input type="text" class="form-control" name="name" placeholder="Your name" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" name="password" placeholder="Password" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" name="re-password" placeholder="Repeat password" required="" />
                        </div>
                        <div>
                            <button class="btn btn-default submit" type="submit">Create</button>
                        </div>
                        <div>
                            <a href="/login">Login</a>
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