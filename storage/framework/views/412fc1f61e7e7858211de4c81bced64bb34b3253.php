<?php $__env->startSection('content'); ?>

    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title"><?php echo e(session('title')); ?></h4>
        </div>
    </div>
    <!--End Page header-->
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo e(session('title')); ?></h4>
                </div>

                <div class="card-body">
                    <form action="<?php echo e(route('store.categories')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" value="<?php echo e($category->id); ?>" name="category_id">
                        <div class="">
                            <div class="form-group">
                                <label for="category_name" class="form-label">Category Name:</label>
                                <input type="text" name="category_name" class="form-control"
                                       placeholder="Category Name" value="<?php echo e($category->category_name); ?>">
                                <?php $__errorArgs = ['category_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description:</label>
                                <textarea name="description" rows="5" cols="40" class="form-control tinymce-editor"
                                          placeholder="Description"><?php echo e($category->description); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label for="file" class="form-label">Thumbnail:</label>

                                <input type="file" name="image" class="form-control" <?php echo e($category->id == null ? 'required' : ''); ?>>
                                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                <img class="mt-2" src="<?php echo e($category->image); ?>" height="150">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-1 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- End Row -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/user/Documents/react/Reachahand_backend/resources/views/categories/create.blade.php ENDPATH**/ ?>