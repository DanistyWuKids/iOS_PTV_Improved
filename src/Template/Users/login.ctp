<?php

$this->layout = false;

echo $this->Html->css('sbadmin2/sb-admin-2.min.css');
echo $this->Html->css('/vendor/sbadmin2/fontawesome-free/css/all.min.css');
echo $this->Html->css('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i');
echo $this->Html->css('sbadmin2/sb-admin-2.min.css');
// Bootstrap core JavaScript
echo $this->Html->script('/vendor/sbadmin2/jquery/jquery.min.js');
echo $this->Html->script('/vendor/sbadmin2/bootstrap/js/bootstrap.bundle.min.js');
// Core plugin JavaScript
echo $this->Html->script('/vendor/sbadmin2/jquery-easing/jquery.easing.min.js');
// Custom scripts for all pages
echo $this->Html->script('sbadmin2/sb-admin-2.min.js');

?>

<!DOCTYPE html>
<html lang="en">
<head></head>
<body class="bg-gradient-primary">
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-header" style="width: 100%"><?php echo $this->Flash->render()?></div>
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <br><br>
                                <?= $this->Form->create(); ?>
                                <form class="user">
                                    <div class="form-group">
                                        <?= $this->Form->input('username',['label'=>'','class'=>'form-control form-control-user','id'=>'exampleInputEmail','placeholder'=>'Your username...','type'=>'text']);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $this->Form->input('password',['label'=>'','class'=>'form-control form-control-user','id'=>'exampleInputPassword','placeholder'=>'Your password...','type'=>'password']);?>
                                    </div>
<!--                                    <div class="form-group">-->
<!--                                        <div class="custom-control custom-checkbox small">-->
<!--                                            <input type="checkbox" class="custom-control-input" id="customCheck">-->
<!--                                            <label class="custom-control-label" for="customCheck">Remember Me</label>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                    <?= $this->Form->submit('Login',['class'=>'btn btn-primary btn-user btn-block'])?>
                                </form>
                                <?= $this->Form->end();?>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= $this->Url->build(['controller'=>'Users','actions'=>'forgot'])?>">Forgot Password?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>

</html>
