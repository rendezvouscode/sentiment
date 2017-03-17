@extends('homepage.template')
@section('main')
<div class="row">
	<div class=" col-md-offset-2 col-md-8 col-sm-8 col-xs-8" align="center">
		<div class="row x_panel tile">
			<div class="x_title">
				<h2>
					<i class="fa fa-files-o" aria-hidden="true"></i> Klasifikasi Tweet
				</h2>
				<div class="clearfix"></div>	
			</div>
			<div class="x_content text-justify">
				<div class="row">
					<div class="contain	er">
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
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
@stop

<!-- <div class="container">
		
	</div> -->