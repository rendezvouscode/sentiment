@extends('homepage.template')
@section('main')
<div class="row">
	<div class="col-md-offset-1 col-md-10 col-sm-10 col-xs-10" align="center">
		<div class="row x_panel tile">
			<div class="x_title">
				<h2>
					<i class="fa fa-pie-chart" aria-hidden="true"></i> <b>Persentasi Matriks</b>
				</h2>
				<div class="clearfix"></div>	
			</div>
			<div class="x_content text-justify">
				<div class="row">
					<div class="container">
						<div class="x_content">
		                  <div class="col-md-5 col-sm-5 col-xs-5 vcenter">
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>TP (True Positive)  : {{$tp}}</b> </h4>
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>TN (True Negative)  : {{$tn}}</b> </h4>
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>FP (False Positive) : {{$fp}}</b> </h4>
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>FN (False Negative) : {{$fn}}</b> </h4>
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>TOTAL : {{$jumlah_data_training}}</b> </h4>
		                  		<br><br>
		                  		<div class="row">
		                  			<div class="col-md-2">
			                  			<div class="label-p vcenter"></div> 
			                  		</div>
			                  		<h4 class="vcenter"><b>True Positif</b></h4>
		                  		</div>
		                  		<div class="row">
		                  			<div class="col-md-2">
			                  			<div class="label-n vcenter"></div> 
			                  		</div>
			                  		<h4 class="vcenter"><b>True Negatif</b></h4>
		                  		</div>
		                  		<div class="row">
		                  			<div class="col-md-2">
			                  			<div class="label-fp vcenter"></div> 
			                  		</div>
			                  		<h4 class="vcenter"><b>False Positif</b></h4>
		                  		</div>
		                  		<div class="row">
		                  			<div class="col-md-2">
			                  			<div class="label-fn vcenter"></div> 
			                  		</div>
			                  		<h4 class="vcenter"><b>False Negatif</b></h4>
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
	<div class="col-md-offset-1 col-md-10 col-sm-10 col-xs-10" align="center">
		<div class="row x_panel tile">
			<div class="x_title">
				<h2>
					<i class="fa fa-pie-chart" aria-hidden="true"></i> <b>Akurasi Dan Error Rate</b>
				</h2>
				<div class="clearfix"></div>	
			</div>
			<div class="x_content text-justify">
				<div class="row">
					<div class="container">
						<div class="x_content">
		                  <div class="col-md-5 col-sm-5 col-xs-5 vcenter">
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>Data yang benar diklasifikasikan : {{$tn+$tp}}</b> </h4>
		                  		<h4><i class="fa fa-circle" aria-hidden="true"></i> <b>Jumlah keseluruhan Data  : {{$jumlah_data_training}}</b> </h4>
		                  		<br><br>
		                  		<div class="row">
		                  			<div class="col-md-2">
			                  			<div class="label-p vcenter"></div> 
			                  		</div>
			                  		<h4 class="vcenter"><b>Akurasi</b></h4>
		                  		</div>
		                  		<div class="row">
		                  			<div class="col-md-2">
			                  			<div class="label-n vcenter"></div> 
			                  		</div>
			                  		<h4 class="vcenter"><b>Error Rate</b></h4>
		                  		</div>
		                  </div>
		                  <div class="col-md-6 col-sm-6 col-xs-6 vcenter">
		                  	<div id="grafik_matrik"></div>
		                  </div>
		                </div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<script>
	Morris.Donut({
				  element: 'grafik_tweet',
				  data: [
					{label: 'TP', value: {{$persen_tp}}},
					{label: 'TN', value: {{$persen_tn}}},
					{label: 'FP', value: {{$persen_fp}}},
					{label: 'FN', value: {{$persen_fn}}},
				  ],
				  colors: ['#26B99A', '#34495E', '#ACADAC', '#00838f '],
				  formatter: function (y) {
					return y + "%";
				  },
				  resize: true
				});
</script>
<script>
	Morris.Donut({
				  element: 'grafik_matrik',
				  data: [
					{label: 'Akurasi', value: {{$akurasi}}},
					{label: 'Error Rate', value: {{$errorrate}}},
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