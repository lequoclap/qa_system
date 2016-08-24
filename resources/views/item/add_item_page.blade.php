@extends('layouts.master')

@section('title')
    Dashboard
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2> 商品アップロード</h2>
                    <div class="clearfix"></div>
                </div>
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
                        <form class="form-horizontal form-label-left" action="{{URL::route('add_item')}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">商品ファイル <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-left">
                                    <input type="file" name="csv_file">
                                    <p class="help-block">Zip形式.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">アップロード形式</label>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-left">
                                    <div id="gender" class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" name="data_type" value="replace"> &nbsp; 商品データを全て入れ替える &nbsp;
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="data_type" value="add" checked> &nbsp; 商品データを追加する &nbsp;
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                 </div>
            <div>
        </div>
@stop


@section('script')
    <script>
        $(document).ready(function() {
            $('input[type="radio"]').change(function() {
                $('input[type="radio"]').each(function() {
                    if ($(this).is(':checked')) {
                        $(this).closest('label').removeClass('btn-default');
                        $(this).closest('label').addClass('btn-primary');
                    } else {
                        $(this).closest('label').removeClass('btn-primary');
                        $(this).closest('label').addClass('btn-default');
                    }
                });
            });
        });
    </script>
@stop