
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>

    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <!-- Title -->
    <title><?php echo e(config('app.name')); ?> | Login</title>

    <!--Favicon -->
    <link rel="icon" href="/images/favicon.png" type="image/x-icon"/>

    <!-- Bootstrap css -->
    <link href="../../assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />

    <!-- Style css -->
    <link href="../../assets/css/style.css" rel="stylesheet" />

    <!-- Dark css -->
    <link href="../../assets/css/dark.css" rel="stylesheet" />

    <!-- Skins css -->
    <link href="../../assets/css/skins.css" rel="stylesheet" />

    <!-- Animate css -->
    <link href="../../assets/css/animated.css" rel="stylesheet" />

    <!---Icons css-->
    <link href="../../assets/plugins/web-fonts/icons.css" rel="stylesheet" />
    <link href="../../assets/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
    <link href="../../assets/plugins/web-fonts/plugin.css" rel="stylesheet" />

</head>

<body class="h-100vh page-style1 light-mode default-sidebar">
<div class="page">
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col mx-auto">
                    <div class="row justify-content-center">
                        <div class="col-md-7 col-lg-5">
                            <div class="card card-group mb-0">
                                <div class="card p-4">
                                    <div class="card-body">
                                        <div class="text-center title-style mb-6">
                                            <h1 class="mb-2 text-success"><?php echo e(config('app.name')); ?></h1>
                                            <hr>
                                            <h3>Login</h3>
                                            <?php if($errors->any()): ?>
                                                <div class="alert alert-danger" role="alert"><span><?php echo e($errors->first()); ?></span></div>
                                            <?php endif; ?>
                                        </div>
                                        <form action="<?php echo e(route('login')); ?>" method="post">
                                            <?php echo csrf_field(); ?>
                                        <div class="input-group mb-3">
                                            <span class="input-group-addon"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 16c-2.69 0-5.77 1.28-6 2h12c-.2-.71-3.3-2-6-2z" opacity=".3"/><circle cx="12" cy="8" opacity=".3" r="2"/><path d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/></svg></span>
                                            <input type="text" class="form-control" placeholder="Email" name="email" required>

                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-addon"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><g fill="none"><path d="M0 0h24v24H0V0z"/><path d="M0 0h24v24H0V0z" opacity=".87"/></g><path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity=".3"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/></svg></span>
                                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-lg btn-primary btn-block"><i class="fe fe-arrow-right"></i> Login</button>
                                            </div>
                                        </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jquery js-->
<script src="../../assets/js/vendors/jquery-3.5.1.min.js"></script>

<!-- Bootstrap4 js-->
<script src="../../assets/plugins/bootstrap/popper.min.js"></script>
<script src="../../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!--Othercharts js-->
<script src="../../assets/plugins/othercharts/jquery.sparkline.min.js"></script>

<!-- Circle-progress js-->
<script src="../../assets/js/vendors/circle-progress.min.js"></script>

<!-- Jquery-rating js-->
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>

</body>
</html>
<?php /**PATH /home/user/Documents/react/Reachahand_backend/resources/views/auth/login.blade.php ENDPATH**/ ?>