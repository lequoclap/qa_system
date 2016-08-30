@extends('layouts.master')

@section('title')
    Create new topic
@stop

@section('style')
@stop

@section('content')
    <?php $topic = $data['topic']; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h3>
                        {{$topic->user_name}}
                        <small class="badge bg-white"><a href="/?category={{$data['topic']->category_name}}" class="text-danger">{{$data['topic']->category_name}}</a></small>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-primary fa fa-edit" href="{{URL::route('edit_topic', ['id' => $topic->id])}}"> Edit topic</a>
    <div class="container">

        {{--Topic content--}}

        <div class="panel panel-default col-md-10">
            <h1>
                {{$topic->title}}
            </h1>
            <i class="text-muted">
                {{$topic->created_at}}
            </i>
            <p>
                {{$topic->content}}
            </p>
            <hr>
            <p class="col-md-6 text-left">Tags:
                @foreach(explode( ',',$topic->tags) as $tag)
                    <span class="badge"><a href="/?tags={{$tag}}" style="color: white">{{$tag}}</a></span>
                @endforeach
            </p>
            <div class="col-md-6 text-right">
                @if($data['is_up_voted'] == true)
                    <button class="btn btn-success vote-up-topic active focus" id="topic_up_{{$topic->id}}" value="voted">
                        <span class="glyphicon glyphicon-thumbs-up"></span>
                        <span class="number">{{$data['up_vote']}}</span>
                    </button>
                @else
                    <button class="btn btn-success vote-up-topic" id="topic_up_{{$topic->id}}" value="not-voted">
                        <span class="glyphicon glyphicon-thumbs-up"></span>
                        <span class="number">{{$data['up_vote']}}</span>
                    </button>
                @endif

                @if($data['is_down_voted'] == true)
                    <button class="btn btn-danger vote-down-topic active focus" id="topic_down_{{$topic->id}}" value="voted" >
                        <span class="glyphicon glyphicon-thumbs-down"></span>
                        <span class="number">{{$data['down_vote']}}</span>
                    </button>
                @else
                    <button class="btn btn-danger vote-down-topic" id="topic_down_{{$topic->id}}" value="not-voted" >
                        <span class="glyphicon glyphicon-thumbs-down"></span>
                        <span class="number">{{$data['down_vote']}}</span>
                    </button>
                @endif
            </div>
        </div>

        {{--Comment List--}}

        <div class="list-group col-md-10">
            @foreach($data['comments_data'] as $comment_data)
                <?php $comment = $comment_data['comment'] ?>
                <div class="list-group-item">
                    <h4 class="text-success">{{$comment->user_name}}</h4>
                    <i class="text-muted">
                        {{$comment->created_at}}
                    </i>
                    <p>{{$comment->content}}</p>

                    <div class="text-right">
                        @if($comment_data['is_up_voted'] == true)
                            <button class="btn btn-success vote-up-comment active focus" id="comment_up_{{$comment->id}}" value="voted">
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                <span class="number">{{$comment_data['up_vote']}}</span>
                            </button>
                        @else
                            <button class="btn btn-success vote-up-comment" id="comment_up_{{$comment->id}}" value="not-voted">
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                <span class="number">{{$comment_data['up_vote']}}</span>
                            </button>
                        @endif

                        @if($comment_data['is_down_voted'] == true)
                            <button class="btn btn-danger vote-down-comment active focus" id="comment_down_{{$comment->id}}" value="voted">
                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                <span class="number">{{$comment_data['down_vote']}}</span>
                            </button>
                        @else
                            <button class="btn btn-danger vote-down-comment" id="comment_down_{{$comment->id}}" value="not-voted">
                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                <span class="number">{{$comment_data['down_vote']}}</span>
                            </button>
                         @endif

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
                    <textarea class="form-control" id="m_comment" name="m_comment" required =""></textarea>
                </div>
                <input type="hidden" name="topic_id" value="{{$topic->id}}"/>
                <div class="col-md-10 text-right">
                    <input type="submit" value="Comment" class="btn btn-primary"/>
                </div>
            </div>
        </form>

    </div>

@stop


@section('script')
    <script>
        const TYPE_VOTE_UP = 1;
        const TYPE_VOTE_DOWN = 2;

        const TARGET_COMMENT = 'target_comment';
        const TARGET_TOPIC = 'target_topic';

        $(function() {
            $('.vote-up-topic').click(function(){
                var btn = $(this);
                vote(btn, TARGET_TOPIC, TYPE_VOTE_UP);
            });
        });

        $(function() {
            $('.vote-down-topic').click(function(){
                var btn = $(this);
                vote(btn, TARGET_TOPIC, TYPE_VOTE_DOWN);
            });
        });


        $(function() {
            $('.vote-up-comment').click(function(){
                var btn = $(this);
                vote(btn, TARGET_COMMENT, TYPE_VOTE_UP);
            });
        });


        $(function() {
            $('.vote-down-comment').click(function(){
                var btn = $(this);
                vote(btn, TARGET_COMMENT, TYPE_VOTE_DOWN);
            });
        });


        function vote(btn, target, vote_type){

            var number = btn.find(".number");
            var vote_num = parseInt(number.html());
            var id = btn.attr('id');

            var state = btn.val();

            if(state == 'voted'){
                number.html(vote_num - 1);
                btn.val('not-voted');
                btn.removeClass('focus active');
                deleteVoteServer(target, id);
            }else{
                number.html(vote_num + 1);
                btn.val('voted');
                btn.addClass('focus active');

                checkOppositeVote(id);
                createVoteServer(target, vote_type, id);
            }
        }

        function checkOppositeVote(id){

            var opposite_id;

            if(id.indexOf("up") >= 0){
                opposite_id = id.replace("up", "down");
            }else if(id.indexOf("down") >= 0){
                opposite_id = id.replace("down", "up");
            }

            var btn = $("#" + opposite_id);
            var number = btn.find(".number");
            var vote_num = parseInt(number.html());
            var state = btn.val();

            if(state == 'voted'){
                number.html(vote_num - 1);
                btn.val('not-voted');
                btn.removeClass('focus active');
            }
        }

        function createVoteServer(target, vote_type, id ){
            var id = id.match(/\d+/);

            $.ajax({
                type: 'POST',
                url:'/vote/create',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id[0],
                    vote_type: vote_type,
                    target: target
                },
                success: function(data, textStatus, request){
                },
                error: function (request) {
                    //TODO rollback
                }
            });

        }

        function deleteVoteServer(target, id ){
            var id = id.match(/\d+/);

            $.ajax({
                type: 'DELETE',
                url:'/vote/delete',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id[0],
                    target: target
                },
                success: function(data, textStatus, request){
                },
                error: function (request) {
                    //TODO rollback
                }
            });

        }


    </script>

@stop