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
    {{--Search Area--}}
        <form class="navbar-form">
                <div class="col-md-5 text-right">
                    <input id="textinput" name="tags" type="text" placeholder="Add tag"  data-role="tagsinput">
                </div>

                <div class="input-group col-md-6">
                    <input type="text" class="form-control" placeholder="Text se    arch" name="search-term">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
    {{--Sort Area--}}
        <div class="text-right">
            <?php $current_url = Request::getPathInfo() . (Request::getQueryString() ? ('?' . Request::getQueryString()) : '');
                if(strpos($current_url,'?')){
                    $current_url .= '&';
                }else{
                    $current_url .= '?';
                }
            ?>

            <label>Sort by:</label>
            <select id="sort-by" class="btn btn-dark" name="sort-by">
                <option value="/">--</option>
                <option value="created_time">Created time</option>
                <option value="up_vote">Up vote</option>
                <option value="down_vote">DownVote</option>
            </select>

            @if( isset($setting['order_type']) && $setting['order_type'] == 'desc')
                <button value="asc" type="button" id="order-type"  class="btn btn-dark glyphicon glyphicon-sort-by-attributes"></button>
            @else
                <button value="desc" type="button" id="order-type" class="btn btn-dark glyphicon glyphicon-sort-by-attributes-alt"></button>
            @endif
        </div>
    {{--List Area--}}
        <hr>
        <div class="list-group">
            @if(!$topics_data)
                <h2 class="text-muted">There are no results that match your search</h2>
            @endif

            @foreach($topics_data as $topic_data)
                <?php $topic = $topic_data['topic']; ?>
                <a href="/topic/view/{{$topic->id}}" class="list-group-item">
                    <span class="badge fa fa-comment bg-orange">{{$topic_data['comment_count']}}</span>
                    <span class="badge fa fa-thumbs-o-down bg-red ">{{$topic_data['down_vote']}}</span>
                    <span class="badge fa fa-thumbs-o-up bg-green">{{   $topic_data['up_vote']}}</span>

                    <h4 class="text-primary">{{$topic->title}}<b class="text-danger">[SOLVED]</b></h4>
                    <p class="list-group-item-text">
                        @if(strlen($topic->content) < 500)
                            {{$topic->content}}
                        @else
                            {{substr($topic->content,0,500)."..."}}
                        @endif
                    </p>
                    <br>
                    <p class="list-group-item-text">Owner:  <small class="text-danger">{{$topic->user_name}}</small></p>
                    <p class="list-group-item-text">Category: <small class="text-danger">{{$topic->category_name}}</small></p>
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
        $('#sort-by').change(function() {
            var value = $(this).val();
            var newUrl = addParam("sort-by", value);
            window.location = newUrl;
        });

        $('#order-type').click(function() {
            var value = $(this).val();
            var newUrl = addParam("order-type", value);
            window.location = newUrl;
        });

        function addParam(key, value){
            var url      = window.location.href;
            var params = window.location.search;

            var items = params.replace("?", "").split("&");

            var newUrl = url.replace(params, "") + "?";
            for (var index = 0; index < items.length; index++) {
                if(items[index]) {
                    var tmp = items[index].split("=");
                    if (tmp[0] != key) newUrl += tmp[0] + "=" + tmp[1] + "&";
                }
            }
            newUrl += key + "=" + value;
            return newUrl;
        }

    </script>
@stop