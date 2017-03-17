@extends('homepage.template')
@section('main')
<div class="row">
	<div class="col-md-offset-1 col-md-10 col-sm-10 col-xs-10" align="center">
		<div class="row x_panel tile">
			<div class="x_title">
				<h2>
					<i class="fa fa-pie-chart" aria-hidden="true"></i> <b>Persentasi Data Testing</b>
				</h2>
				<div class="clearfix"></div>	
			</div>
			<div class="x_content text-justify">
				<div class="row">
					<div class="container">
						<div class="x_content">
		                  <div class="col-md-5 col-sm-5 col-xs-5 vcenter">
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>Jumlah Data Positif : {{$data_testing_p}}</b> </h4>
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>Jumlah Data Negatif : {{$data_testing_n}}</b> </h4>
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>Total Data Testing : {{$data_testing_total}}</b> </h4>
		                  		<br><br>
		                  		<div class="row">
		                  			<div class="col-md-2">
			                  			<div class="label-p vcenter"></div> 
			                  		</div>
			                  		<h4 class="vcenter"><b>Kelas Positif</b></h4>
		                  		</div>
		                  		<div class="row">
		                  			<div class="col-md-2">
			                  			<div class="label-n vcenter"></div> 
			                  		</div>
			                  		<h4 class="vcenter"><b>Kelas Negatif</b></h4>
		                  		</div>
		                  </div>
		                  <div class="col-md-6 col-sm-6 col-xs-6 vcenter">
		                  	<div id="grafik_tweet"></div>
		                  </div>
		                </div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<center>
<div class="row">
	<div class="col-md-offset-1 col-md-10 col-sm-10 col-xs-10" align="center">
		<div class="row x_panel tile">
			<div class="x_title">
				<h2>
					<i class="fa fa-pie-chart" aria-hidden="true"></i> <b>Persentasi Data Training</b>
				</h2>
				<div class="clearfix"></div>	
			</div>
			<div class="x_content text-justify">
				<div class="row">
					<div class="container">
						<div class="x_content">
		                  <div class="col-md-5 col-sm-5 col-xs-5 vcenter">
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>Jumlah Data Positif : {{$jumlah_negatif}}</b> </h4>
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>Jumlah Data Negatif : {{$jumlah_positif}}</b> </h4>
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>Total Data Training : {{$jumlah_training}}</b> </h4>
		                  		<br><br>
		                  		<div class="row">
		                  			<div class="col-md-2">
			                  			<div class="label-p vcenter"></div> 
			                  		</div>
			                  		<h4 class="vcenter"><b>Kelas Positif</b></h4>
		                  		</div>
		                  		<div class="row">
		                  			<div class="col-md-2">
			                  			<div class="label-n vcenter"></div> 
			                  		</div>
			                  		<h4 class="vcenter"><b>Kelas Negatif</b></h4>
		                  		</div>
		                  </div>
		                  <div class="col-md-6 col-sm-6 col-xs-6 vcenter">
		                  	<div id="grafik_tweet_training"></div>
		                  </div>
		                </div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
</center>
<script>
	Morris.Donut({
				  element: 'grafik_tweet',
				  data: [
					{label: 'Positif', value: {{$persen_p}}},
					{label: 'Negatif', value: {{$persen_n}}},
				  ],
				  colors: ['#26B99A', '#34495E'],
				  formatter: function (y) {
					return y + "%";
				  },
				  resize: true
				});
</script>
<script>
	Morris.Donut({
				  element: 'grafik_tweet_training',
				  data: [
					{label: 'Positif', value: {{$persen_p_training}}},
					{label: 'Negatif', value: {{$persen_n_training}}},
				  ],
				  colors: ['#26B99A', '#34495E'],
				  formatter: function (y) {
					return y + "%";
				  },
				  resize: true
				});
</script>
@stop
<!-- <div class="container">
		
	</div> -->