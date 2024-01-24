<?php $__env->startSection('content'); ?>

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title"><?php echo e(session('title')); ?></h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <a class="btn btn-success" href="<?php echo e(route('create.programs')); ?>"> Create Program</a>

    </div>
</div>
<!--End Page header-->

<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">All Programs</div>
            </div>
            <div class="card-body">
                <?php if(Session::has('message')): ?>
                <div class="alert alert-info" role="alert"><button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true"></button>
                    <?php echo e(Session::get('message')); ?>

                </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="wd-15p border-bottom-0">TITLE</th>
                                <th class="wd-15p border-bottom-0">DESC</th>
                                <th class="wd-15p border-bottom-0">LOGO</th>
                                <th class="wd-15p border-bottom-0">PROFILE_IMAGE</th>
                                <th class="wd-20p border-bottom-0">IMAGES</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($program->id); ?></td>
                                <td><?php echo e($program->title); ?></td>
                                <td><?php echo e($program->desc); ?></td>
                                <td><img src="<?php echo e($program->logo_url); ?>" height="70"></td>
                                <td><img src="<?php echo e($program->cover_pic_url); ?>" height="70"></td>
                                <td>
                                    <?php $__currentLoopData = $program->gallery_images ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(is_string($image)): ?>
                                    <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="Image" width="10" height='10'>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </td>
                                <td><?php echo e($program->created_at); ?></td>
                                <td>
                                    <a href="<?php echo e(route('edit.programs', $program->id)); ?>"
                                        class="btn btn-light mr-2">Edit</a>
                                    <a href="<?php echo e(route('confirm_delete.programs', $program->id)); ?>"
                                        class="btn btn-light">Delete</a>
                                </td>
                                <td><a href="<?php echo e(route('show.programs', $program->id)); ?>" class="btn btn-light">View
                                        Program</a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>

                    </table>
                </div>
                <!-- table-responsive -->
            </div>
        </div>
    </div>
    <!-- End Row -->
    <!--End Page header-->

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/user/Documents/react/Reachahand_backend/resources/views/programs/index.blade.php ENDPATH**/ ?>