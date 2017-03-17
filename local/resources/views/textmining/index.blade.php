@extends('homepage.template')
@section('main')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12" align="center">
		 @include('_partial.flash_message')
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
						<!-- Trigger the modal with a button -->
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data</button>
						<!-- <a href="{{url('home/klasifikasi')}}" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Klasifikasi</a> -->
					</div>
				</div>
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
									<td>{{$data->tweet}}</td>
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
										{!!Form::open(['method' => 'DELETE', 'action' => ['DataTrainingController@destroy_training', $data->id]])!!}
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
						<p>Tidak Terdapat Data Training :)</p>
						@endif
						<div class="container">
							<div class="row col-md-6 jumlah_data">
								<h4>Jumlah Data : {{$jumlah_data}} </h4>		
							</div>
							<div class="row col-md-6 paging">
								{{$data_training->links()}}		
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
						<h2 class="modal-title"><b><i class="fa fa-files-o" aria-hidden="true"></i> Tambah Data Training</b></h2>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="container">
								{!!Form::open(['url'=>'home'])!!}
								<!-- <form action="{{url('home/testing')}}" method="POST"> -->
								{!!Form::textarea('tweet', null, ['class' => 'form-control','placeholder' => 'Masukan Tweet', 'rows' => '5', 'maxlength' => '255'])!!}
								<!-- <textarea class="form-control" rows="3" placeholder="Masukan Tweet "></textarea> -->
								<br>
								<div class="form-group">
									<label>Kelas Tweet :</label><br>
									{!!Form::radio('class','positif')!!} <span class="label label-success" style="font-size:15px;">Positif</span><br><br>
									{!!Form::radio('class','negatif')!!} <span class="label label-danger" style="font-size:15px;">Negatif</span>
								</div>	
								<br>
								<div class="row">
									<div class="form-group col-md-offset-3 col-md-6">
										{!!Form::submit('Tambah Data Training' , ['class' => 'btn btn-primary form-control'])!!}
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