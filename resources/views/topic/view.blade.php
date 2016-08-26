@extends('layouts.master')

@section('title')
    Create new topic
@stop

@section('style')
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h3>
                        {{$data['topic']->user_name}}
                        <small class="badge bg-white"><a href="/#" class="text-danger">{{$data['topic']->category_name}}</a></small>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        {{--Topic content--}}

        <div class="panel panel-default col-md-10">
            <h1>
                {{$data['topic']->title}}
            </h1>
            <p>
                {{$data['topic']->content}}
            </p>

            <p class="col-md-6 text-left">Tags:
                @foreach(explode( ',',$data['topic']->tags) as $tag)
                    <span class="badge">{{$tag}}</span>
                @endforeach
            </p>
            <div class="col-md-6 text-right">
                <button class="btn btn-success" onclick="voteUp()">
                    <span class="glyphicon glyphicon-thumbs-up"></span>{{$data['up_vote']}}
                </button>
                <button class="btn btn-danger" onclick="voteDown()">
                    <span class="glyphicon glyphicon-thumbs-down"></span>{{$data['down_vote']}}
                </button>
            </div>
        </div>

        {{--Comment List--}}

        <div class="list-group col-md-10">
            @foreach($data['comments'] as $comment)
                <div class="list-group-item">
                    <h4 class="text-success">{{$comment->user_name}}</h4>
                    <p>{{$comment->content}}</p>
                    <div class="text-right">
                        <button class="btn btn-success" onclick="voteUp()">
                            <span class="glyphicon glyphicon-thumbs-up"></span>1
                        </button>
                        <button class="btn btn-danger" onclick="voteDown()">
                            <span class="glyphicon glyphicon-thumbs-down"></span>2
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{--My Comment--}}

        <p class="col-md-3"> My comment: </p>
        <form class="form-horizontal" action="{{URL::route('comment_topic')}}" method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <div class="col-md-10">
                    <textarea class="form-control" id="m_comment" name="m_comment"></textarea>
                </div>
                <input type="hidden" name="topic_id" value="{{$data['topic']->id}}"/>
                <div class="col-md-10 text-right">
                    <input type="submit" value="Comment" class="btn btn-primary"/>
                </div>
            </div>
        </form>

    </div>

@stop


@section('script')
    <script>
        function voteUp(){

        }

        function voteDown(){

        }
    </script>

@stop