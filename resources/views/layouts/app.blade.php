<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
            <meta content="IE=edge" http-equiv="X-UA-Compatible">
                <meta content="width=device-width, initial-scale=1" name="viewport">
                    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
                        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
                            <link href="{{ asset('css/custom-table.css') }}" rel="stylesheet">
                                <!-- CSRF Token -->
                                <meta content="{{ csrf_token() }}" name="csrf-token">
                                    <title>
                                        {{ config('app.name', 'Laravel') }}
                                    </title>
                                    @include('layouts.import_css')
                                    <style type="text/css">
                                        body{
		font-family: 'Kanit', sans-serif !important; }
                                    </style>
                                </meta>
                            </link>
                        </link>
                    </link>
                </meta>
            </meta>
        </meta>
    </head>
    <body class="nav-md">
        @yield('php')
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    @yield('search-ctn')
                    <div class="left_col scroll-view" id="sidebar-ctn">
                        <div class="navbar nav_title" style="border: 0;">
                            <a class="site_title" href="/">
                                <i class="fa fa-paw">
                                </i>
                                <span>
                                    Admin Rolls
                                </span>
                            </a>
                        </div>
                        <div class="clearfix">
                        </div>
                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img alt="..." class="img-circle profile_img" src="{{ asset('images/admin-pic4.png') }}" style="pointer-events: none !important;">
                                </img>
                            </div>
                            <div class="profile_info">
                                <span>
                                    Welcome,
                                </span>
                                <h2>
                                    {{ Auth::user()->name }}
                                </h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->
                        <br/>
                        <!-- sidebar menu -->
                        <div class="main_menu_side hidden-print main_menu" id="sidebar-menu">
                            <div class="menu_section">
                                <h3>
                                    General
                                </h3>
                                <ul class="nav side-menu">
                                    @if (canAccess())
                                    <li>
                                        <a href="{{ route('index') }}">
                                            <i class="fa fa-dashboard">
                                            </i>
                                            @lang('dashboard')
                                        </a>
                                    </li>
                                    @endif
                                    @if (canAccess('rsb','ext_minor','ext_major'))
                                    <li>
                                        <a href="{{ route('orders.index') }}">
                                            <i class="fa fa-exchange">
                                            </i>
                                            @lang('order')
                                        </a>
                                    </li>
                                    @endif
                                    @if (canAccess('acm'))
                                    <li>
                                        <a href="{{ route('exports.index') }}">
                                            <i class="fa fa-level-up">
                                            </i>
                                            @lang('export')
                                        </a>
                                    </li>
                                    @endif
                                    @if (canAccess('rsb'))
                                    <li>
                                        <a href="{{ route('returns.index') }}">
                                            <i class="fa fa-reply">
                                            </i>
                                            @lang('product return')
                                        </a>
                                    </li>
                                    @endif
                                    @if (canAccess('rsb'))
                                    <li>
                                        <a href="{{ route('stocks.index') }}">
                                            <i class="fa fa-cube">
                                            </i>
                                            @lang('stock')
                                        </a>
                                    </li>
                                    @endif
                                    @if (canAccess('acm','ext_major'))
                                    <li>
                                        <a href="{{ route('invoices.index') }}">
                                            <i class="fa fa-usd">
                                            </i>
                                            @lang('debt')
                                        </a>
                                    </li>
                                    @endif
                                    @if (canAccess())
                                    <li>
                                        <a>
                                            <i class="fa fa-file-pdf-o">
                                            </i>
                                            @lang('report')
                                            <span class="fa fa-chevron-down">
                                            </span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <li>
                                                <a href="{{ route('reports.index','buy') }}">
                                                    @lang('buy')
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('reports.index','sell') }}">
                                                    @lang('sell')
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    @endif
                                    @if (canAccess('rsb'))
                                    <li>
                                        <a>
                                            <i class="fa fa-table">
                                            </i>
                                            @lang('predefined')
                                            <span class="fa fa-chevron-down">
                                            </span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <li>
                                                <a href="{{ route('customers.index') }}">
                                                    @lang('customer')
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('products.index') }}">
                                                    @lang('product')
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('units.index') }}">
                                                    @lang('unit')
                                                </a>
                                            </li>
                                            @if (canAccess())
                                            <li>
                                                <a href="{{ route('users.index') }}">
                                                    @lang('member')
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->
                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-placement="top" data-toggle="tooltip" id="setting-btn" title="Settings">
                                <span aria-hidden="true" class="glyphicon glyphicon-cog">
                                </span>
                            </a>
                            <a data-placement="top" data-toggle="tooltip" id="stock-search-trigger" title="Advanced Search">
                                <span aria-hidden="true" class="glyphicon glyphicon-search">
                                </span>
                            </a>
                            <a data-placement="top" data-toggle="tooltip" id="account-setting" title="Account">
                                <span aria-hidden="true" class="glyphicon glyphicon-user">
                                </span>
                            </a>
                            <a data-placement="top" data-toggle="tooltip" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" title="Logout">
                                <span aria-hidden="true" class="glyphicon glyphicon-off">
                                </span>
                            </a>
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>
                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav style="display: flex !important; align-items: center !important;justify-content: space-between;padding: 4px 6px">
                            <div>
                                <a id="menu_toggle" style="cursor: pointer;">
                                    <i class="fa fa-bars" style="font-size: 32px">
                                    </i>
                                </a>
                            </div>
                            <div class="btn-group" role="group" style="padding-right: 16px;align-self: flex-end;">
                                @if (\App::isLocale('th'))
                                <button class="btn btn-success" onclick="window.location.href='{{ route('setlocale','th') }}'" type="button">
                                    TH
                                </button>
                                <button class="btn btn-secondary" onclick="window.location.href='{{ route('setlocale','en') }}'" style="border-color: #169F85 !important" type="button">
                                    EN
                                </button>
                                @else
                                <button class="btn btn-secondary" onclick="window.location.href='{{ route('setlocale','th') }}'" style="border-color: #169F85 !important" type="button">
                                    TH
                                </button>
                                <button class="btn btn-success" onclick="window.location.href='{{ route('setlocale','en') }}'" type="button">
                                    EN
                                </button>
                                @endif
                            </div>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->
                @yield('content')
                <!-- Modal -->
                <div class="modal fade" id="setting-modal" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">
                                    ×
                                </button>
                                <h4 class="modal-title">
                                    @lang('ตั้งค่า')
                                </h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('config.update') }}" id="setting-form" method="POST">
                                    {{ csrf_field() }}
								{{ method_field('put') }}

								@foreach ($appconfigs as $c)
                                    <div style="width: 49%;display: inline-block;">
                                        <div class="form-group" style="padding: 4px 2px;">
                                            <label>
                                                {{ $c->description }}
                                            </label>
                                            <input class="form-control" name="config[{{$c->key}}]" type="text" value="{{ $c->value }}">
                                            </input>
                                        </div>
                                    </div>
                                    @endforeach
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" form="setting-form" type="submit">
                                    <i class="fa fa-save">
                                    </i>
                                    @lang('save')
                                </button>
                                <button class="btn btn-danger" data-dismiss="modal" type="button">
                                    <i class="fa fa-close">
                                    </i>
                                    @lang('close')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="account-modal" role="dialog" tabindex="-1">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">
                                    ×
                                </button>
                                <h4 class="modal-title">
                                    @lang('ตั้งค่าบัญชี')
                                </h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('users.update.name',Auth::id()) }}" id="account-form" method="POST">
                                    {{ csrf_field() }}
									{{ method_field('put') }}
                                    <div class="form-group">
                                        <label class="control-label" for="name">
                                            ชื่อ
                                        </label>
                                        <input class="form-control" type="text" value="{{ Auth::user()->name }}" id="name" name="name" required>
                                        </input>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="role">
                                            บทบาท
                                        </label>
                                        @php
                                        	$role = '';
                                        	switch(Auth::user()->role){
                                        	    case 'rsb' : 
                                        	        $role = "ฝ่ายจัดซื้อ";
                                        	        break;
                                        	    case 'acm' : 
                                        	        $role = "ฝ่ายบัญชี";
                                        	        break;
                                        	    case 'ext_minor' :
                                        	        $role = "ฝ่ายส่งของโกดัง";
                                        	        break;
                                        	    case 'ext_major' :
                                        	        $role = "ฝ่ายส่งของหน้าร้าน";
                                        	        break;
                                        	    default :
                                        	        $role = "ฝ่ายบริหาร";
                                        	        break;
                                        	}
                                        @endphp
                                        <input class="form-control" type="text" value="{{ $role }}" id="role" disabled>
                                        </input>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="username">
                                            รหัสผู้ใช้
                                        </label>
                                        <input class="form-control" disabled="" type="text" value="{{ Auth::user()->username }}" id="username">
                                        </input>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="password">
                                            รหัสผ่าน
                                        </label>
                                        <input class="form-control" disabled="" type="password" value="********" id="password">
                                        </input>
                                        <a href="#" id="change-password">เปลี่ยนรหัสผ่าน</a>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" form="account-form" type="submit">
                                    <i class="fa fa-save">
                                    </i>
                                    @lang('save')
                                </button>
                                <button class="btn btn-danger" data-dismiss="modal" type="button">
                                    <i class="fa fa-close">
                                    </i>
                                    @lang('close')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="change-password-modal" role="dialog" tabindex="-1">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">
                                    ×
                                </button>
                                <h4 class="modal-title">
                                    @lang('เปลี่ยนรหัสผ่าน')
                                </h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('users.update.password',Auth::id()) }}" id="password-form" method="POST">
                                    {{ csrf_field() }}
									{{ method_field('put') }}
                                    <div class="form-group">
                                        <label class="control-label" for="old-password">
                                            รหัสผ่านเก่า
                                        </label>
                                        <input class="form-control" type="password" id="old-password" name="old_password" required>
                                        </input>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="new-password">
                                            รหัสผ่านใหม่
                                        </label>
                                        <input class="form-control" type="password" id="new-password" name="new_password" required>
                                        </input>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="confirm-new-password">
                                            ยืนยันรหัสผ่านใหม่
                                        </label>
                                        <input class="form-control" type="password" id="confirm-new-password" name="new_password_confirmation" required>
                                        </input>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" form="password-form" type="submit">
                                    <i class="fa fa-save">
                                    </i>
                                    @lang('save')
                                </button>
                                <button class="btn btn-danger" data-dismiss="modal" type="button">
                                    <i class="fa fa-close">
                                    </i>
                                    @lang('close')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <footer>
                    <div class="pull-right">
                        Gentelella - Bootstrap Admin Template by
                        <a href="https://colorlib.com">
                            Colorlib
                        </a>
                    </div>
                    <div class="clearfix">
                    </div>
                </footer>
                <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
        @include('layouts.import_js')
        <script type="text/javascript">
            $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
        </script>
        <script type="text/javascript">
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
			event.preventDefault();
			$(this).ekkoLightbox({
				
			});
		});
        </script>
        @if (session()->has('notification'))
        <script type="text/javascript">
            $(document).ready(()=>{
			$.toast({ 
				heading : "{{ session('notification')['heading'] }}",
				text : "{{ session('notification')['msg'] }}", 
				icon : "{{ session('notification')['status'] }}",
				allowToastClose : false,      
				hideAfter : 5000,            
				stack : 5,                    
				textAlign : 'left',          
				position : 'bottom-right',
				loader : false
			})
		});
        </script>
        @endif

	@if ($errors->any())
        <script type="text/javascript">
            $(document).ready(()=>{
			let errors = <?php echo json_encode($errors->all()); ?>;
			$.toast({ 
				heading : "<strong>Something went wrong!</strong>",
				text : errors, 
				icon : "error",
				allowToastClose : true,            
				stack : 5,
				hideAfter : false,                    
				textAlign : 'left',          
				position : 'bottom-right',
				loader : false
			})
		});
        </script>
        @endif
        <script type="text/javascript">
            var toggle_state = false;
		var search_state = false;
		$(document).ready(function(){
			$(function () {
				$("body").tooltip({
					selector: '[data-toggle="tooltip"]',
					container: 'body',
					html: true
				});
			})

			$('#setting-btn').click(() => {
				$('#setting-modal').modal('show');
			});


			$('#account-setting').click(() => {
				$('#account-modal').modal('show');
			});

			$('#change-password').click(() => {
				$('#account-modal').modal('hide');
				$('#change-password-modal').modal('show');
			});

			$('#stock-search-trigger').click(() => {
				if($('.search-ctn').length){
					$('.search-ctn').show();
					$('#sidebar-ctn').hide();
					search_state = true;
				}
			});


			$('#menu_toggle').click(() => {
				toggle_state = (toggle_state) ? false : true;
				if(search_state){
					(toggle_state) ? $('.search-ctn').hide() : $('.search-ctn').show();
				}
			});

			$('.close-search').click(() => {
				$('.search-ctn').hide();
				$('#sidebar-ctn').show();
				search_state = false;
			});
		});
        </script>
        @yield('sc');
    </body>
</html>
