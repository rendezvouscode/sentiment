@extends('homepage.template')
@section('main')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12" align="center">
		 <div class="row x_panel tile">
			<div class="x_title">
				<h2>
					<b><i class="fa fa-files-o" aria-hidden="true"></i> Data Testing</b>
				</h2>
				<div class="clearfix"></div>	
			</div>
			<div class="x_content text-justify">
				<div class="row">
					<div class="container">
						<!-- Trigger the modal with a button -->
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-search" aria-hidden="true"></i> Klasifikasi</button>
						<!-- <a href="{{url('home/klasifikasi')}}" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Klasifikasi</a> -->
					</div>
				</div>
				<div class="row">
					<div class="container">
						@if(!empty($data_testing))
						<table class="table table-striped">
							<thead>
								<tr>
									<th>NO</th>
									<th>Tweet</th>
									<th>Probabilitas Positif</th>
									<th>Probabilitas Negatif</th>
									<th>Kelas</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$n = 0;
									foreach ($data_testing as $data_t) {
									$n++;
								?>
								<tr>
									<td>{{$n}}</td>
									<td style="width: 800px;">{{$data_t->tweet}}</td>
									<td>{{$data_t->p_positif}}</td>
									<td>{{$data_t->p_negatif}}</td>
									<td>
										<?php 
											if($data_t->class_prediksi == 'Positif'){?>
												<span class="label label-success">{{$data_t->class_prediksi}}</span>		
											<?php }else{ ?>
												<span class="label label-danger">{{$data_t->class_prediksi}}</span>		
											<?php }
										?>
									</td>
									<td>
										{!!Form::open(['method' => 'DELETE', 'action' => ['DataTrainingController@destroy_testing', $data_t->id]])!!}
											{!!Form::button('<i class="fa fa-trash-o"></i> Delete', ['class' => 'btn btn-danger', 'type'=>'submit', 'id' => 'hapus'])!!}
										{!!Form::close()!!}
									</td>
								</tr>
								<?php
									}
									?>
							</tbody>
						</table>
						@else
						<p>Tidak Terdapat Data Testing :)</p>
						@endif
						<div class="container">
							<div class="row col-md-6 jumlah_data">
								<h4>Jumlah Data : {{$jumlah_data}} </h4>		
							</div>
							<div class="row col-md-6 paging">
								{{$data_testing->links()}}		
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<!-- modal containter -->
	<div class="container">
		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content col-md-12">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h2 class="modal-title"><b><i class="fa fa-files-o" aria-hidden="true"></i> Klasifikasi Tweet</b></h2>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="container">
								{!!Form::open(['url'=>'home/testing'])!!}
								<!-- <form action="{{url('home/testing')}}" method="POST"> -->
								{!!Form::textarea('tweet', null, ['class' => 'form-control','placeholder' => 'Masukan Tweet', 'rows' => '5'])!!}
								<!-- <textarea class="form-control" rows="3" placeholder="Masukan Tweet "></textarea> -->
								<br>
								<div class="row">
									<div class="form-group col-md-offset-3 col-md-6">
										{!!Form::submit('Klasifikasi' , ['class' => 'btn btn-primary form-control'])!!}
										<!-- <input type="submit" value="Klasifikasi" class="btn btn-primary form-control"> -->
									</div>
								</div>
							</form>
							{!!Form::close()!!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end of modal container -->
@stop

<!-- <div class="container">
		
	</div> -->