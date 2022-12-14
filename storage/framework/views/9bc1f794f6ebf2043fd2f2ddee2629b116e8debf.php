

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <!-- Page Heading -->
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Content Row -->
        <div class="card shadow">
            <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800"><?php echo e(__('create arena')); ?></h1>
                    <a href="/admin/arena" class="btn btn-primary btn-sm shadow-sm"> Go Back </a>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('arena.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama"> Nama </label>
                        <input type="text" name="nama" class="form-control" id="nama" value="<?php echo e(old('nama')); ?>"
                            aria- describedby="nama">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1"> Jenis Arena </label>
                        <select class="form-control" id="jenis_id" name="jenis_id">
                            <?php $__currentLoopData = $jenisLap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($jenis->id); ?>"><?php echo e($jenis->nama); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price"> Harga </label>
                        <input type="text" name="price" class="form-control" id="price" aria-describedby="price">
                    </div>
                    <div class="form-group">
                        <label for="image"> Gambar </label>
                        <input type="file" class="form-control" required="required" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"> Submit </button>
                </form>
            </div>
        </div>


        <!-- Content Row -->

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\laravel\PWL_PROJECT\resources\views/admin/arenas/create.blade.php ENDPATH**/ ?>