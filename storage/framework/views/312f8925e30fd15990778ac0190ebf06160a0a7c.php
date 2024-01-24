<?php $__env->startSection('content'); ?>
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title"><?php echo e(session('title')); ?></h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <a class="btn btn-success" href="<?php echo e(route('create.categories')); ?>"> Create Category</a>

        </div>
    </div>
    <!--End Page header-->

    <!-- Row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">List of <?php echo e(session('title')); ?></div>
                </div>
                <div class="card-body">
                    <?php if(Session::has('message')): ?>
                        <div class="alert alert-info" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo e(Session::get('message')); ?>

                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap" id="example1">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th class="wd-15p border-bottom-0">NAME</th>
                                <th class="wd-15p border-bottom-0">IMAGE</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($category->id); ?></td>
                                    <td><?php echo e($category->category_name); ?></td>
                                    <td><img src="<?php echo e($category->image); ?>" height="70", border-radius='10'></td>

                                    <td>
                                        <a href="<?php echo e(route('edit.categories', $category->id)); ?>" class="btn btn-light mr-2">Edit</a>   
                                        <a href="<?php echo e(route('confirm_delete.categories', $category->id)); ?>" class="btn btn-light">Delete</a>

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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/user/Documents/react/Reachahand_backend/resources/views/categories/index.blade.php ENDPATH**/ ?>