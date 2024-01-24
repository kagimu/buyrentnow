<?php $__env->startSection('content'); ?>

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title"><?php echo e(session('title')); ?></h4>
    </div>
</div>
<!--End Page header-->

<div class="main-proifle">
    <div class="row pb-4">
        <div class="col-lg-7">
            <div class="box-widget widget-user">
                <div class="widget-user-image d-sm-flex">
                    <img alt="avatar" class="rounded-circle border p-0" src="<?php echo e($user->profile_pic_url); ?>" height="70"
                        width="70">
                    <div class="ml-sm-4 mt-4">
                        <h4 class="pro-user-username mb-3 font-weight-bold"><?php echo e($user->name); ?> <?php if($user->role
                            == 'admin'): ?> <span class="badge badge-warning">Admin</span> <?php endif; ?></h4>
                        <div class="d-flex mb-1">
                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                                width="24">
                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                <path d="M20 8l-8 5-8-5v10h16zm0-2H4l8 4.99z" opacity=".3"></path>
                                <path
                                    d="M4 20h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM20 6l-8 4.99L4 6h16zM4 8l8 5 8-5v10H4V8z">
                                </path>
                            </svg>
                            <div class="h6 mb-0 ml-3 mt-1"><?php echo e($user->email); ?></div>
                        </div>
                        <div class="d-flex">
                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                                width="24">
                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                <path
                                    d="M15.2 18.21c1.21.41 2.48.67 3.8.76v-1.5c-.88-.07-1.75-.22-2.6-.45l-1.2 1.19zM6.54 5h-1.5c.09 1.32.35 2.59.75 3.79l1.2-1.21c-.24-.83-.39-1.7-.45-2.58zM14 8h5V5h-5z"
                                    opacity=".3"></path>
                                <path
                                    d="M20 15.5c-1.25 0-2.45-.2-3.57-.57-.1-.03-.21-.05-.31-.05-.26 0-.51.1-.71.29l-2.2 2.2c-2.83-1.44-5.15-3.75-6.59-6.58l2.2-2.21c.28-.27.36-.66.25-1.01C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1zM5.03 5h1.5c.07.88.22 1.75.46 2.59L5.79 8.8c-.41-1.21-.67-2.48-.76-3.8zM19 18.97c-1.32-.09-2.6-.35-3.8-.76l1.2-1.2c.85.24 1.72.39 2.6.45v1.51zM12 3v10l3-3h6V3h-9zm7 5h-5V5h5v3z">
                                </path>
                            </svg>
                            <div class="h6 mb-0 ml-3 mt-1">Username: <?php echo e($user->username); ?></div>
                        </div>
                    </div>
                </div>
                <h5 class="font-weight-bold mt-4">Position</h5>
                <div class="main-profile-bio mb-4">
                    <?php echo e($user->position); ?>

                </div>


            </div>
        </div>
        <div class="col-lg-5">
            <!-- Images -->
            <h5 class="font-weight-bold">Images</h5>
            <div class="row">


                <div class="col-6 p-6">
                    <img src="<?php echo e(asset('storage/' . $user->profile_pic_url)); ?>" alt="Image" width="300" height="250"
                        padding='20'>
                </div>


            </div>

            <!-- Videos -->
            <h5 class="font-weight-bold mt-4">Videos</h5>
            <div class="row">

                <?php if(is_string($user->video)): ?>
                <div class="col-6">
                    <div class="embed-responsive embed-responsive-16by9 mb-3">
                        <video class="embed-responsive-item" controls>
                            <source class="embed-responsive-item" src="<?php echo e(asset('storage/' . $user->video)); ?>"
                                allowfullscreen autoplay="0">
                        </video>

                    </div>
                </div>
                <?php endif; ?>

            </div>

            <a class="carousel-control-prev" href="#carousel-captions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-captions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/user/Documents/react/Reachahand_backend/resources/views/users/show.blade.php ENDPATH**/ ?>