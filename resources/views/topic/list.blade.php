@extends('layouts.master')

@section('title')
    一覧
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>商材管理</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <table class="table table-striped responsive-utilities jambo_table bulk_action">
                        <thead>
                        <tr class="headings">
                            <th>
                                <input type="checkbox" id="check-all" class="flat">
                            </th>
                            <th class="text-center column-title"  style="width: 10%">画像</th>
                            <th class="text-center column-title" style="width: 10%">商品名</th>
                            <th class="text-center column-title" style="width: 30%">説明</th>
                            <th class="text-center column-title">価格</th>
                            <th class="text-left column-title">自動再出品</th>
                            <th class="text-left column-title">自動削除</th>
                            <th class="text-center column-title no-link last"><span class="nobr">操作</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                            class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($items as $item)
                            <tr class="even pointer">
                                <td class="a-center ">
                                    <input type="checkbox" class="flat" name="table_records">
                                </td>
                                <td class="text-center"><img style="max-width: 100%; max-height: 100%" src="{{url('/images/product_image/'.Auth::user()->id.'/'.$item->image_1)}}"></td>
                                <td class="text-center">{{$item->name}}</td>
                                <td class="text-center">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea class="form-control" rows="3">{{$item->description}}</textarea>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" value="{{$item->price}}">
                                        <span class="fa fa-yen form-control-feedback left" aria-hidden="true"></span>
                                    </div>
                                </td>
                                <td class="text-left">
                                    @foreach($item->sale_settings as $key => $value)
                                        <div class="radio">
                                            <label><input type="radio"
                                                          name="sale_setting_{{$item->id}}"
                                                @if($key == $item->sale_setting){{ 'checked="checked"' }} @endif>
                                                {{$value}}
                                            </label>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="text-left">
                                    @foreach($item->del_settings as $key => $value)
                                        <div class="radio">
                                            <label><input type="radio"
                                                          name="del_setting_{{$item->id}}"
                                                @if($key == $item->del_setting){{ "checked" }} @endif>{{$value}}
                                            </label>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="text-center last">
                                    <button type="button" class="btn btn-danger btn-xs">削除</button>
                                    <a href="{{URL::route('post_item',['id' => $item->id])}}" type="button"
                                       class="btn btn-success btn-xs">出品</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop


@section('script')
@stop