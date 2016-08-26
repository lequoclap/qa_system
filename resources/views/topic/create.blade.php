@extends('layouts.master')

@section('title')
    Create new topic
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
                        <form class="form-horizontal" action="{{URL::route('create_topic')}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <fieldset>

                                <!-- Form Name -->
                                <legend>Create New Topic</legend>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="textinput">Title</label>
                                    <div class="col-md-4">
                                        <input id="textinput" name="title" type="text" placeholder="Title of your topic" class="form-control input-md" required="">

                                    </div>
                                </div>

                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="selectbasic">Category</label>
                                    <div class="col-md-2">
                                        <select name="category_id" class="form-control">
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="textarea">Content</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" id="textarea" name="content" rows="8"></textarea>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="textinput">Tags</label>
                                    <div class="col-md-8 text-left">
                                        <input id="textinput" name="tags" type="text" placeholder="Add tag"  data-role="tagsinput">
                                    </div>
                                </div>

                            </fieldset>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                 </div>
            </div>
        </div>
    </div>
@stop


@section('script')
    <script src="{{asset('bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
@stop