@extends('layouts.master')

@section('title')
    Dashboard
@stop

@section('content')
    <div class="">
        <div class="row">
            <h1>Im here!!</h1>
        </div>
    </div>

    <a class="btn btn-primary col-sm-2 glyphicon-plus" href="{{URL::route('create_topic_form')}}">Create new topic</a>

        <div class="container">
            <h2>List Group With Custom Content</h2>
            <div class="list-group">
                <a href="#" class="list-group-item active">
                    <h4 class="list-group-item-heading">First List Group Item Heading</h4>
                    <p class="list-group-item-text">List Group Item Text</p>
                </a>
                <a href="#" class="list-group-item">
                    <h4 class="list-group-item-heading">Second List Group Item Heading</h4>
                    <p class="list-group-item-text">List Group Item Text</p>
                </a>
                <a href="#" class="list-group-item">
                    <h4 class="list-group-item-heading">Third List Group Item Heading</h4>
                    <p class="list-group-item-text">List Group Item Text</p>
                </a>
            </div>
        </div>
@stop


@section('script')
@stop