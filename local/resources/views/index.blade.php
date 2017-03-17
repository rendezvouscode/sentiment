@extends('homepage.template')
@section('main')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12" align="center">
		<div class="row x_panel tile">
			<div class="x_title">
				<h2>
					<i class="fa fa-files-o" aria-hidden="true"></i> Data Training
				</h2>
				<div class="clearfix"></div>	
			</div>
			<div class="x_content text-justify">
				<div class="row">
					<div class="container">
						@if(!empty($data_training))
						<table class="table table-striped">
							<thead>
								<tr>
									<th>NO</th>
									<th>Tweet</th>
									<th>Label</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$n = 0;
									foreach ($data_training as $data) {
									$n++;
								?>
								<tr>
									<td>{{$n}}</td>
									<td style="width: 800px;">{{$data->tweet}}</td>
									<td>
										<?php 
											if($data->class == 'positif'){?>
												<span class="label label-success">{{$data->class}}</span>		
											<?php }else{ ?>
												<span class="label label-danger">{{$data->class}}</span>		
											<?php }
										?>
									</td>
									<td>
										<a class="btn btn-primary" href="">Edit</a>
										<a class="btn btn-danger" href="">Delete</a>
									</td>
								</tr>
								<?php
									}
									?>
							</tbody>
						</table>
						@else
						<p>Tidak Terdapat Data Training :)</p>
						@endif
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-6" align="center">
		<div class="row x_panel tile">
			<div class="x_title">
				<h2>Selamat Datang</h2>
				<div class="clearfix"></div>	
			</div>
			<div class="x_content text-justify">
				<p>Selamat Datang Di template Slicing Laravel</p>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-6" align="center">
		<div class="row x_panel tile">
			<div class="x_title">
				<h2>Selamat Datang</h2>
				<div class="clearfix"></div>	
			</div>
			<div class="x_content text-justify">
				<p>Selamat Datang Di template Slicing Laravel</p>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
@stop

<!-- <div class="container">
		
	</div> -->