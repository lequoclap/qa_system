@extends('layouts.main')

@section('body')
<body class="nav-md">

<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="/" class="site_title"><i class="fa fa-paw"></i> <span>Auto Free Market!</span></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="{{Auth::user()->photo_url}}" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>{{Auth::user()->name}}</h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            <li><a><i class="fa fa-home"></i> ホーム <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="/">ダッシュボード</a>
                                    </li>
                                    <li><a href="/news/list">ニュース</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="{{URL::route('add_item')}}"><i class="fa fa-upload"></i> 商品アップロード </a></li>
                            <li><a href="/item/list"><i class="fa fa-database"></i> 商材管理 </a></li>
                            <li><a><i class="fa fa-cog"></i> ユーザー設定 </a></li>
                            <li><a><i class="fa fa-tasks"></i> 出品状況 </a></li>
                            <li><a href="/mitem/list"><i class="fa fa-gavel"></i> 出品中商品 </a></li>
                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="{{Auth::user()->photo_url}}" alt="">{{Auth::user()->name}}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <?php $relations = Auth::user()->userRelations; ?>
                                @foreach($relations as $relation)
                                    <?php $user = $relation->user; ?>
                                <li>
                                    <a href="/relation/{{$user->id}}">
                                        <span class="user-profile"> {{$user->name}}<img class="pull-right" src="{{$user->photo_url}}" alt=""></span>
                                    </a>
                                </li>
                                @endforeach
                                <li><a href="/user/add">  アカウント追加</a>
                                </li>
                                <li><a href="/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                        <?php
                            $lastCrawlNotification = Session::get('lastNotificationTime');
                            $now = (new DateTime())->getTimestamp();
                            if (!$lastCrawlNotification || $lastCrawlNotification < $now) {
                                $client = \App\Http\Controllers\BaseController::getMercariInstant();
                                $countNotificationData = $client->getNotificationCount(Auth::user()->min_notification_id);
                                $notifications = $client->getNotifications();
                                Session::put('notifications', $notifications);
                                Session::put('notificationsCount', $countNotificationData);
                                Session::put('lastNotificationTime', (new DateTime('+10 minutes'))->getTimestamp());
                            } else {
                                $notifications = Session::get('notifications');
                                $countNotificationData = Session::get('notificationsCount');
                            }
                            ?>
                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                @if (isset($countNotificationData['data']['count']) && $countNotificationData['data']['count'] > 0)
                                    <span class="badge bg-green">{{$countNotificationData['data']['count']}}</span>
                                @endif
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu" style="max-height: 500px; overflow: scroll;">
                                @foreach($notifications['data'] as $notification)
                                <li>
                                    <a>
                                        @if(isset($notification['photo_url']))
                                        <span class="image">
                                            <img src="{{$notification['photo_url']}}" alt="Profile Image" />
                                        </span>
                                        @endif
                                        <span>
                                            <span>【{{$notification['kind']}}】</span>
                                            <span class="time">　{{(new DateTime())->setTimestamp($notification['created'])->format('Y/m/d H:i')}}</span>
                                        </span>
                                        <span class="message">
                                            {{$notification['message']}}
                                        </span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->


        <!-- page content -->
        <div class="right_col" role="main">
            @include('flash::message')
            @yield('content')
        </div>
        <!-- /page content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>

<script src="{{asset('/js/bootstrap.min.js')}}"></script>

@yield('script')


<script src="{{asset('/js/custom.js')}}"></script>

<!-- /footer content -->
</body>

@stop
