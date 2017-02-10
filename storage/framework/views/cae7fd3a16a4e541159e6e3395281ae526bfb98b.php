<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3>CRUD Laravel 5.3</h3>
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="<?php echo e(route('crud.update', $cruds->id)); ?>" method="post">
					<input name="_method" type="hidden" value="PATCH">
					<?php echo e(csrf_field()); ?>

						<div class="form-group<?php echo e($errors->has('nama') ? ' has-error' : ''); ?>">
							<input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php echo e($cruds->nama); ?>">
							<?php echo $errors->first('nama', '<p class="help-block">:message</p>'); ?>

						</div>
						<div class="form-group<?php echo e($errors->has('phone') ? ' has-error' : ''); ?>">
							<input type="text" name="phone" class="form-control" placeholder="Nomor Handphone" value="<?php echo e($cruds->phone); ?>">
							<?php echo $errors->first('phone', '<p class="help-block">:message</p>'); ?>

						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-success" value="Simpan">
							<a href="<?php echo e(route('crud.index')); ?>" class="btn btn-primary">Kembali</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>