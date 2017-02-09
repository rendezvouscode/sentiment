<?php $__env->startSection('content'); ?>

<h1 class="text-center">Belajar LARAVEL 5.1</h1>
<br>
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			Form Tambah Data
		</div>
		<div class="panel-body">
			<?php echo Form::open(['url' => '/prosestambah']); ?>

				<label>Nama :</label> 
				<?php echo Form::text('nama','',['placeholder' => 'Namamu', 'class' => 'form-control']); ?>

				<label>Alamat :</label>
				<?php echo Form::text('alamat','',['placeholder' => 'Alamatmu', 'class' => 'form-control']); ?>

				<label>Kelas :</label>
				<?php echo Form::text('kelas','',['placeholder' => 'Kelas Berapa', 'class' => 'form-control']); ?>

				<br>
				<?php echo Form::submit('Tambah Data', ['class' => 'btn btn-success']); ?>

			<?php echo Form::close(); ?>

		</div>
	</div>
</div>
<?php echo $__env->make('template/t_index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>