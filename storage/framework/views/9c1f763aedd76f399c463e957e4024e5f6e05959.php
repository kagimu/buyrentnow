<?php $__env->startSection('content'); ?>

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title"><?php echo e(session('title')); ?></h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <a class="btn btn-success" href="<?php echo e(route('create.reports')); ?>"> Create Report</a>

    </div>
</div>
<!--End Page header-->

<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">All Posts</div>
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
                                <th class="wd-15p border-bottom-0">USER</th>
                                <th class="wd-15p border-bottom-0">NAME</th>
                                <th class="wd-15p border-bottom-0">CATEGORY</th>
                                <th class="wd-15p border-bottom-0">BEDROOMS</th>
                                <th class="wd-15p border-bottom-0">BATHROOMS</th>
                                <th class="wd-15p border-bottom-0">LOCATION</th>
                                <th class="wd-15p border-bottom-0">PRICE</th>
                                <th class="wd-15p border-bottom-0">PROPERTY STATUS</th>
                                <th class="wd-20p border-bottom-0">IMAGES</th>
                                <th class="wd-15p border-bottom-0">DATE</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($report->id); ?></td>
                                <td><?php echo e($report->user->first_name); ?> <?php echo e($report->user->last_name); ?></td>
                                <td><?php echo e($report->name); ?></td>
                                <td><?php echo e($report->category->category_name); ?></td>
                                <td><?php echo e($report->bedroom); ?> bedrooms</td>
                                <td><?php echo e($report->bathroom); ?> bathrooms</td>
                                <td><?php echo e($report->location); ?></td>
                                <td><?php echo e($report->price); ?></td>
                                <td><?php echo e($report->status); ?></td>
                                <td>
                                    <?php $__currentLoopData = $report->images ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(is_string($image)): ?>
                                    <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="Image" width="10" height='10'>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </td>
                                <td><?php echo e($report->created_at); ?></td>
                                <td><?php echo e($report->comments_count); ?></td>
                                <td>
                                    <a href="<?php echo e(route('edit.reports', $report->id)); ?>" class="btn btn-light mr-2">Edit</a>
                                    <a href="<?php echo e(route('confirm_delete.reports', $report->id)); ?>"
                                        class="btn btn-light">Delete</a>
                                </td>
                                <td><a href="<?php echo e(route('show.reports', $report->id)); ?>" class="btn btn-light">View
                                        Property</a>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/user/Documents/react/Reachahand_backend/resources/views/reports/index.blade.php ENDPATH**/ ?>