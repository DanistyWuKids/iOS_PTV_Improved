<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org).
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * @see          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 *
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
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
use Cake\ORM\TableRegistry;

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <title>
        <?= $this->fetch('title'); ?>
        <?= ' - Oh-My-IoT Survilliance System'; ?>
    </title>
</head>

<body id="page-top">
<div id="wrapper">  <!-- Page Wrapper -->

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $this->Url->build(["controller" => "Pages", "action" => "home"]) ?>">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Oh_My_IoT<sup>Alpha</sup></div>
        </a>

        <hr class="sidebar-divider my-0">   <!-- Divider -->

        <li class="nav-item active">    <!-- Nav Item - Dashboard -->
            <a class="nav-link" href="<?= $this->Url->build(["controller" => "Pages", "action" => "home"])?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <hr class="sidebar-divider">    <!-- Divider -->
        <div class="sidebar-heading">Surveillance</div>    <!-- Heading -->
        <li class="nav-item">    <!-- Nav Item - Pages Collapse Menu -->
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
               aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Recordings</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="404.html">Photos</a>
                    <a class="collapse-item" href="blank.html">Videos</a>
                </div>
            </div>
        </li>


        <li class="nav-item"> <!-- Nav Item - Charts -->
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Statics</span></a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">     <!-- Divider -->
        <div class="sidebar-heading">Interface</div>    <!-- Heading -->

        <li class="nav-item">   <!-- Nav Item - Pages Collapse Menu -->
            <a class="nav-link collapsed"
               href="<?= $this->Url->build(["controller" => "Users", "action" => "index"]) ?>" data-toggle="collapse"
               data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-users-cog"></i>
                <span>Account Settings</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Components:</h6>
                    <a class="collapse-item" href="<?= $this->Url->build(['controller'=>'Users','action'=>'index'])?>">View</a>
                    <a class="collapse-item" href="<?= $this->Url->build(['controller'=>'Users','action'=>'passwd'])?>">Change password</a>
                </div>
            </div>
        </li>

        <li class="nav-item">   <!-- Nav Item - Utilities Collapse Menu -->
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
               aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Utilities</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="utilities-color.html">Setting working time</a>
                    <a class="collapse-item" href="utilities-border.html">Borders</a>
                    <a class="collapse-item" href="utilities-animation.html">Animations</a>
                    <a class="collapse-item" href="utilities-other.html">Other</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">    <!-- Divider -->

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul><!-- End of Sidebar -->


    <div id="content-wrapper" class="d-flex flex-column">   <!-- Content Wrapper -->
        <div id="content">  <!-- Main Content -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">  <!-- Topbar -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">   <!-- Sidebar Toggle (Topbar) -->
                    <i class="fa fa-bars"></i>
                </button>
                <ul class="navbar-nav ml-auto"> <!-- Topbar Navbar -->

                    <li class="nav-item dropdown no-arrow mx-1">    <!-- Nav Item - Alerts -->
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <span class="badge badge-danger badge-counter">3+</span>    <!-- Counter - Alerts -->
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <?php for ($i = 0; $i < 3; $i++) { ?>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">12 December,2019 12:12pm</div>
                                        <span class="font-weight-bold">Motion Detected!</span>
                                    </div>
                                </a>
                            <?php } ?>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown no-arrow mx-1">    <!-- Nav Item - temporary disable detection -->
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button">
                            <i class="fas fa-pause fa-fw"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown no-arrow mx-1">    <!-- Nav Item - shutdown -->
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button">
                            <i class="fas fa-power-off fa-fw"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown no-arrow mx-1">    <!-- Nav Item - restart -->
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button">
                            <i class="fas fa-undo fa-fw"></i>
                        </a>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <?php echo TableRegistry::getTableLocator()->get('users')->get(
                                    $this->request->getSession()->read('Auth.User')['id'])['username'];?>
                            </span>
                            <?php echo $this->Html->image('https://picsum.photos/60/60/?random',['class'=>'img-profile rounded-circle']); ?>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>  <!-- End of Topbar -->
            <div><?php echo $this->Flash->render() ?></div> <!--Flash Contents -->

            <div class="container-fluid">   <!-- Begin Page Content -->
                <?= $this->fetch('content'); ?>
            </div>  <!-- /.container-fluid -->
        </div>  <!-- End of Main Content -->

        <footer class="sticky-footer bg-white"> <!-- Footer -->
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Oh-My-IoT Team @ UNSW 2019-2020</span><br><br>
                    <span>This website is build by team Oh-My-IoT for academic purposes for Unit COMP6733 @ University of New South Wales CSE. </span><br>
                    <span>This website portal was build under MIT License, original template produced by <?= $this->Html->link('BlackrockDigital', 'https://github.com/BlackrockDigital/startbootstrap-sb-admin-2') ?></span>
                </div>
            </div>
        </footer>   <!-- End of Footer -->
    </div>  <!-- End of Content Wrapper -->
</div>  <!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= $this->Url->build(['controller'=>'Users','action'=>'logout'])?>">Logout</a>
            </div>
        </div>
    </div>
</div>
</body>
<?php
// Page level plugins
echo $this->Html->script('/vendor/sbadmin2/chart.js/Chart.min.js');
// Page level custom scripts
echo $this->Html->script('sbadmin2/demo/chart-area-demo.js');
echo $this->Html->script('sbadmin2/demo/chart-pie-demo.js');
?>
</html>

<script type="text/javascript">
    var url = "ajax/pi.php";
    $(function () {
        $(".btn-trigger").click(function () {
            var text = $(this).text().replace(/ /g, "").replace(/\n/g, "").replace(/\r/g, "").replace(/\t/g, "");
            var cmd = "";
            switch (text) {
                case "shutdown":
                    cmd = "sudo shutdown -h now";
                    break;
                case "restart":
                    cmd = "sudo reboot";
                    break;
            }
            if (confirm("Are you sure to do this?")) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        action: "set-linux-cmd",
                        cmd: cmd
                    },
                    success: function (result) {
                        $(".tip").html(result);
                    }
                });
            }
        });
    });
</script>
