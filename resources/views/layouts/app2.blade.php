<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	<link href="{{ asset('css/custom-table.css') }}" rel="stylesheet">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>
	
	@include('layouts.import_css')
	
	<style type="text/css">
	body{
		font-family: 'Kanit', sans-serif !important; }
	</style>
</head>
<body class="nav-md">
	@yield('php')
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				@yield('search-ctn')
				<div class="left_col scroll-view" id="sidebar-ctn">
					<div class="navbar nav_title" style="border: 0;">
						<a href="/" class="site_title"><i class="fa fa-paw"></i> <span>Admin Rolls</span></a>
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<div class="profile clearfix">
						<div class="profile_pic">
							<img src="{{ asset('images/admin-pic4.png') }}" alt="..." class="img-circle profile_img">
						</div>
						<div class="profile_info">
							<span>Welcome,</span>
							<h2>Admin</h2>
						</div>
					</div>
					<!-- /menu profile quick info -->

					<br />
					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<div class="menu_section">
							<h3>General</h3>
							<ul class="nav side-menu">
								@if (Auth::user()->role === 'admin')
								<li>
									<a href="{{ route('index') }}">
										<i class="fa fa-dashboard"></i>
										@lang('messages.mn:m:dashboard')
									</a>
								</li>
								@endif
								@if (Auth::user()->role === 'admin' || Auth::user()->role === 'ext_minor' || Auth::user()->role === 'ext_major')
								<li>
									<a href="{{ route('orders.index') }}">
										<i class="fa fa-exchange"></i>
										@lang('messages.mn:m:order')
									</a>
								</li>
								@endif
								@if (Auth::user()->role === 'admin' || Auth::user()->role === 'acm')
								<li>
									<a href="{{ route('exports.index') }}">
										<i class="fa fa-level-up"></i>
										รายการส่งออก
									</a>
								</li>
								@endif
								<li>
									<a href="{{ route('returns.index') }}">
										<i class="fa fa-reply"></i>
										สินค้าตีกลับ
									</a>
								</li>
								@if (Auth::user()->role === 'rsb')
								<li>
									<a href="{{ route('stocks.index') }}">
										<i class="fa fa-cube"></i>
										@lang('messages.mn:m:stock')
									</a>
								</li>
								@endif
								@if (Auth::user()->role === 'acm')
								<li>
									<a href="{{ route('invoices.index') }}">
										<i class="fa fa-usd"></i>
										@lang('messages.mn:m:debt')
									</a>
								</li>
								@endif
								<li>
									<a>
										<i class="fa fa-table"></i>
										@lang('messages.mn:m:predefined')
										<span class="fa fa-chevron-down"></span>
									</a>
									<ul class="nav child_menu">
										<li>
											<a href="{{ route('customers.index') }}">
												@lang('messages.mn:m:predefined:customer')
											</a>
										</li>
										<li>
											<a href="{{ route('products.index') }}">
												@lang('messages.mn:m:predefined:product')
											</a>
										</li>
										<li>
											<a href="{{ route('units.index') }}">
												@lang('messages.mn:m:predefined:unit')
											</a>
										</li>
										@if (Auth::user()->role === 'admin')
										<li>
											<a href="{{ route('users.index') }}">
												สมาชิก
											</a>
										</li>
										@endif
									</ul>
								</li>
							</ul>
						</div>
					</div>
					<!-- /sidebar menu -->

					<!-- /menu footer buttons -->
					<div class="sidebar-footer hidden-small">
						<a data-toggle="tooltip" data-placement="top" title="Settings" id="setting-btn">
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Advanced Search" id="stock-search-trigger">
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Lock">
							<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
							<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
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
								<i class="fa fa-bars" style="font-size: 32px"></i>
							</a>
						</div>
						<div class="btn-group" role="group" style="padding-right: 16px;align-self: flex-end;">
							@if (\App::isLocale('th'))
							<button type="button" class="btn btn-success" onclick="window.location.href='{{ route('setlocale','th') }}'">
								TH
							</button>
							<button type="button" class="btn btn-secondary" style="border-color: #169F85 !important" onclick="window.location.href='{{ route('setlocale','en') }}'">
								EN
							</button>
							@else
							<button type="button" class="btn btn-secondary" style="border-color: #169F85 !important" onclick="window.location.href='{{ route('setlocale','th') }}'">
								TH
							</button>
							<button type="button" class="btn btn-success" onclick="window.location.href='{{ route('setlocale','en') }}'">
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
			<div class="modal fade" id="setting-modal" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">
								@lang('messages.mn:setting')
							</h4>
						</div>
						<div class="modal-body">
							<form action="{{ route('config.update') }}" method="POST" id="setting-form">
								{{ csrf_field() }}
								{{ method_field('put') }}
								<div class="form-group">
									<label for="usr">
										@lang('Enter Point Number For Showing Critical Products')
									</label>
									<input type="text" name="config[cripoint]" class="form-control" value="{{ appconfig('cripoint')}}">
								</div>
								<div class="form-group">
									<label for="pwd">
										@lang('Enter Number of Day For Showing Outstanding Products')
									</label>
									<input type="text" name="config[outdatedr]" class="form-control" value="{{ appconfig('outdatedr')}}">
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-success" form="setting-form">
								<i class="fa fa-save"></i>
								@lang('messages.mn:save')
							</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">
								<i class="fa fa-close"></i>
								@lang('messages.mn:close')
							</button>
						</div>
					</div>

				</div>
			</div>

			<footer>
				<div class="pull-right">
					Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
				</div>
				<div class="clearfix"></div>
			</footer>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
