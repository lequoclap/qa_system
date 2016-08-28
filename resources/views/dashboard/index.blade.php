@extends('layouts.master')

@section('title')
    Dashboard
@stop

@section('style')
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput-typeahead.css')}}">
@stop


@section('content')

    <div class="container">
        <p><a class="btn btn-primary glyphicon-plus" href="{{URL::route('create_topic_form')}}">Create new topic</a></p>

        <form class="navbar-form">
                <div class="col-md-4 text-right">
                    <input id="textinput" name="tags" type="text" placeholder="Add tag"  data-role="tagsinput">
                </div>

                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="srch-term">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        <div class="text-right">
            <label>Sort by:</label>
            <select id="select-sort" class="btn btn-dark">
                <option value="/">--</option>
                <option value="/select=created_time">Created time</option>
                <option value="/select=up_vote">Up vote</option>
                <option value="/select=down_vote">DownVote</option>
            </select>
            <a href="" class="btn btn-dark glyphicon glyphicon-sort-by-attributes"></a>
        </div>
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
    <script src="{{asset('bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script>
        $('#select-sort').change(function() {
            // set the window's location property to the value of the option the user has selected
            window.location = $(this).val();
        });
    </script>
@stop