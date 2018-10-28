<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>HAI </title>
	<!-- Bootstrap -->
	<link href="{{url('asset/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="{{url('asset/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
	<!-- NProgress -->
	<link href="{{url('asset/nprogress/nprogress.css')}}" rel="stylesheet">
	<!-- morris css -->
	<link href="{{url('asset/morrisjs/morris.css')}}" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="{{url('asset/build/css/custom.css')}}" rel="stylesheet">
	<link href="{{url('asset/build/css/style.css')}}" rel="stylesheet">
	<!-- jQuery -->
	<script src="{{url('asset/jquery/dist/jquery.min.js')}}"></script>
	<!-- morris js -->
	<script src="{{url('asset/raphael/raphael.min.js')}}"></script>
	<script src="{{url('asset/morrisjs/morris.js')}}"></script>
	<!-- sweet alert -->
	<link rel="stylesheet" type="text/css" href="{{url('asset/sweetalert/sweetalert2.min.css')}}">
	<script src="{{url('asset/sweetalert/sweetalert2.min.js')}}"></script>
</head>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col menu_fixed">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="{{url('home')}}" class="site_title"><i class="fa fa-university" aria-hidden="true"></i> <span>Pos Indonesia </span></a>
					</div>
					<div class="clearfix"></div>
					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<div class="menu_section">
							<ul class="nav side-menu">
								<li><a href="{{url('home')}}"><i class="fa fa-database" aria-hidden="true"></i> Data Training </a></li>                  
								<li><a href="{{url('home/testing')}}"><i class="fa fa-check-square-o" aria-hidden="true"></i> Data Testing </a></li>     
								<li><a href="{{url('home/persentasi')}}"><i class="fa fa-area-chart" aria-hidden="true"></i> Persentasi Tweet </a></li>
								<li><a href="{{url('home/pengujian')}}"><i class="fa fa-check-circle" aria-hidden="true"></i> Pengujian Metode </a></li>     
							</ul>
						</div>
					</div>
					<!-- /sidebar menu -->
				</div>
			</div>

			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i></a>
							<p>
						</div>
						<!-- diisi data ning kene -->
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				@yield('main')
			</div>          
			<!-- /page content -->

			<!-- footer content -->
			<footer>
				<div class="pull-right">
					Klasifikasi Opini Masyarakat template by <a href="https://colorlib.com">Colorlib</a>
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
		</div>
	</div>
	<script>
	  function ConfirmDelete(){
	  var x = confirm("Anda yakin ingin menghapus data ini?");
	  if (x)
	    return true;
	  else
	    return false;
	  }
	</script>
	<!-- Bootstrap -->
	<script src="{{url('asset/bootstrap/js/bootstrap.min.js')}}"></script>
	<!-- FastClick -->
	<script src="{{url('asset/fastclick/lib/fastclick.js')}}"></script>
	<!-- NProgress -->
	<script src="{{url('asset/nprogress/nprogress.js')}}"></script>
	<!-- Custom Theme Scripts -->
	<script src="{{url('asset/build/js/custom.js')}}"></script>
	<script src="{{url('asset/build/js/laravelapp.js')}}"></script>
</body>
</html>
