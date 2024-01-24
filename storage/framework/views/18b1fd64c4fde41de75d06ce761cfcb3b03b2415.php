<?php $__env->startSection('content'); ?>

<!-- Page header -->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title"><?php echo e(session('title')); ?></h4>
    </div>
    <div class="page-header">

        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <a class="btn btn-success" href="<?php echo e(route('create.users')); ?>"> Add New Staff Personel</a>
        </div>
    </div>
    <!-- End Page header -->
</div>
<!-- End Page header -->

<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">List of Registered <?php echo e(session('title')); ?></div>
            </div>
            <div class="card-body">
                <?php if(Session::has('message')): ?>
                <div class="alert alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo e(Session::get('message')); ?>

                </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="wd-15p border-bottom-0">Full name</th>
                                <th class="wd-15p border-bottom-0">Login time</th>
                                <th class="wd-20p border-bottom-0">Last seen</th>
                                <th class="wd-25p border-bottom-0">Status</th>
                                <th class="wd-25p border-bottom-0">Accurate Location</th>
                                <th class="wd-10p border-bottom-0">Registered Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->id); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->last_login); ?></td>
                                <td><?php echo e($user->last_activity); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo e($user->online == 1 ? 'success' : 'danger'); ?> mt-2">
                                        <?php echo e($user->online == 1 ? 'online' : 'offline'); ?>

                                    </span>
                                </td>
                                <td>

                                    City: <?php echo e($user->cityName); ?><br>
                                    Region: <?php echo e($user->regionName); ?><br>
                                    Country: <?php echo e($user->countryName); ?>

                                </td>
                                <td><?php echo e($user->created_at); ?></td>
                                <td>
                                <td>
                                    <a href="<?php echo e(route('edit.users', $user->id)); ?>" class="btn btn-light mr-2">Edit</a>
                                    <a href="<?php echo e(route('confirm_delete.users', $user->id)); ?>"
                                        class="btn btn-light">Delete</a>
                                </td>
                                <td><a href="<?php echo e(route('show.users', $user->id)); ?>" class="btn btn-light">View Property</a>
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
</div>
<!-- End Page header -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/user/Documents/react/Reachahand_backend/resources/views/users/index.blade.php ENDPATH**/ ?>