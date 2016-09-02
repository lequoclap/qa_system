@extends('layouts.master')

@section('title')
    Edit Topic
@stop

@section('style')
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput-typeahead.css')}}">
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="row text-center">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" action="{{URL::route('edit_topic',['id'=> $topic->id])}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <fieldset>

                                <!-- Form Name -->
                                <legend>Create New Topic</legend>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="textinput">Title</label>
                                    <div class="col-md-4">
                                        <input id="textinput" name="title" type="text" value="{{$topic->title}}" placeholder="Title of your topic" class="form-control input-md" required="">

                                    </div>
                                </div>

                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="selectbasic">Category</label>
                                    <div class="col-md-2">
                                        <select name="category_id" class="form-control">
                                            @foreach($categories as $category)
                                                @if($topic->category_id == $category->id)
                                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                                @else
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="selectbasic">Status</label>
                                    <div class="col-md-2">
                                        <select name="status" class="form-control">
                                            @foreach($statuses as $key => $value)
                                                @if($topic->status == $key)
                                                    <option value="{{$key}}" selected>{{$value}}</option>
                                                @else
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="textarea">Content</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" id="content-editor" name="content" rows="8">{{$topic->content}}</textarea>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="textinput">Tags</label>
                                    <div class="col-md-8 text-left">
                                        <input id="textinput" name="tags" type="text" placeholder="Add tag"  data-role="tagsinput" value="{{$topic->tags}}">
                                    </div>
                                </div>

                            </fieldset>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                 </div>
            </div>
        </div>
    </div>
@stop


@section('script')
    <script src="{{asset('bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{asset('bower_components/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace( 'content-editor' );
    </script>

@stop