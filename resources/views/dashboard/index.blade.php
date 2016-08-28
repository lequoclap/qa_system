@extends('layouts.master')

@section('title')
    Dashboard
@stop

@section('content')
    <div class="">
        <div class="row">
            <h1>Check your timeline!!</h1>
        </div>
    </div>

    <div class="container">
        <p><a class="btn btn-primary glyphicon-plus" href="{{URL::route('create_topic_form')}}">Create new topic</a></p>
        <div class="list-group">
            @foreach($topics_data as $topic_data)
                <?php $topic = $topic_data['topic']; ?>
                <a href="/topic/view/{{$topic->id}}" class="list-group-item">
                    <span class="badge fa fa-thumbs-o-down bg-red ">{{$topic_data['down_vote']}}</span>
                    <span class="badge fa fa-thumbs-o-up bg-green">{{$topic_data['up_vote']}}</span>
                    <h4 class="text-primary">{{$topic->title}}</h4>
                    <p class="list-group-item-text">{{substr($topic->content,0,500)."..."}}</p>
                    <br>
                    <p class="list-group-item-text text-success">Owner: {{$topic->user_name}}</p>
                    <p class="list-group-item-text text-success">Category: {{$topic->category_name}}</p>
                    <p class="list-group-item-text text-left">Tags:
                        @foreach(explode( ',',$topic->tags) as $tag)
                        <span class="badge">{{$tag}}</span>
                        @endforeach
                    </p>
                </a>
            @endforeach
        </div>
    </div>
@stop
@section('script')
@stop