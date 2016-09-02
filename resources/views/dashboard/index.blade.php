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
        <form class="navbar-form" id="input-form">
                <div class="col-md-5 text-right">
                    <input id="textinput" name="tags" type="text" placeholder="Add tag"  data-role="tagsinput">
                </div>
                <div class="input-group col-md-4">
                    <input type="text" class="form-control" placeholder="Text search" name="search-term">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
    {{--Sort Area--}}
        <div class="text-right">
            <label>Sort by:</label>
            <select id="sort-by" class="btn btn-dark" name="sort-by">
                @foreach($setting['sort_by_list'] as $key => $value )
                    @if($key == $setting['sort_by'])
                        <option value="{{$key}}" selected >{{$value}}</option>
                    @else
                        <option value="{{$key}}">{{$value}}</option>
                    @endif
                @endforeach
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
                <h2 class="text-muted">There are no results that match your search!</h2>
            @endif

            @foreach($topics_data as $topic_data)
                <?php $topic = $topic_data['topic']; ?>
                <div class="list-group-item">
                    <span class="badge fa fa-comment bg-orange">{{$topic_data['comment_count']}}</span>
                    <span class="badge fa fa-thumbs-o-down bg-red ">{{$topic_data['down_vote']}}</span>
                    <span class="badge fa fa-thumbs-o-up bg-green">{{   $topic_data['up_vote']}}</span>

                    <a href="/topic/view/{{$topic->id}}" >
                        <h4 class="text-primary">{{$topic->title}}
                            <b class="text-danger">[{{\App\Models\Topic::getStatusLabel($topic->status) }}]</b>
                        </h4>
                    </a>
                    <i class="list-group-item-text text-muted">{{$topic->created_at}}</i>
                    <p class="list-group-item-text">
                        @if(strlen($topic->content) < 500)
                            {{strip_tags($topic->content)}}
                        @else
                            {{strip_tags(substr($topic->content,0,500)."...")}}
                        @endif
                    </p>
                    <br>
                    <p class="list-group-item-text">Owner:  <small class="text-danger">{{$topic->user_name}}</small></p>
                    <p class="list-group-item-text">Category:<a href="/category/{{$topic->category_id}}">  <small class="text-danger">{{$topic->category_name}}</small></a></p>
                    <p class="list-group-item-text text-left">Tags:
                        @foreach(explode( ',',$topic->tags) as $tag)
                        <span class="badge"><a href="/?tags={{$tag}}" style="color: white">{{$tag}}</a></span>
                        @endforeach
                    </p>
                </div>
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