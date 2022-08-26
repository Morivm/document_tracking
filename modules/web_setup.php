<?php
    include 'session.php';
    if($userrole != "SUPERADMIN") {
        header("Location: error404"); 
    }
    include '../includes/header.php';
?>
<body class="vertical-layout vertical-menu 2-columns  fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">


<?php
    include '../includes/topbar.php';
    include '../includes/sidebar.php'
?>

<div class="modal fade text-left mdl_test_mail" id="mdl_test_mail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Test Mailer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                <form id="frm_testmailer" class="form form-horizontal frm_testmailer" method="post" action="../actions/act_web_setup.php" autocomplete="off">
                    <div class="form-body">
                        <div class="form-group row"> <!-- KAPAG WLA SO DOCTYPE -->
                            <label class="col-md-3 label-control mt-1" for="txt_2_0">Enter Email Address</label>
                            <div class="col-md-9 mx-auto">
                                <input type="text" class="form-control" name="txt_2_0" id="txt_2_0" placeholder="You can send bulk by separating email address with comma.">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-outline-primary" value="Test">
                </div>
                </form>
        </div>
    </div>
</div>
    <!-- BEGIN: Main Menu-->

    <!-- END: Main Menu-->
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Web Setup</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Settings
                                </li>
                                <li class="breadcrumb-item active">Web Setup
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                        <button class="btn btn-info round dropdown-toggle dropdown-menu-right box-shadow-2 px-2 mb-1" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons</a></div>
                    </div>
                </div> -->
            </div>
            <div class="content-body">
                <!-- card actions section start -->
                <section id="card-actions">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Choose Your Desired Setup</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                 
                                    <div class="nav-vertical">
                                        <ul class="nav nav-tabs nav-left flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="baseVerticalLeft-tab1" data-toggle="tab"
                                                    aria-controls="tabVerticalLeft1" href="#tabVerticalLeft1" aria-expanded="true">Site Image</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="baseVerticalLeft-tab2" data-toggle="tab" aria-controls="tabVerticalLeft2"
                                                    href="#tabVerticalLeft2" aria-expanded="false">Mailer</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="baseVerticalLeft-tab3" data-toggle="tab" aria-controls="tabVerticalLeft3"
                                                    href="#tabVerticalLeft3" aria-expanded="false">Messaging</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content px-1">
                                            <!-- tab 1 -->
                                            <div role="tabpanel" class="tab-pane active" id="tabVerticalLeft1" aria-expanded="true" aria-labelledby="baseVerticalLeft-tab1">
                                                <div class="container">    
                                                    <div class="row mt-5">
                                                        <div class="col-xl-5 col-lg-12 mb-2 text-center">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th>WEBSITE ICON<br />
                                                                            </th>
                                                                            <td>     
                                                                                <img src="../img/web/no_image.png" alt="web_image_mobile" class="prev_image" width="100" height="100" id="prev_image">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-12">
                                    
                                                            <form id="frm_websetup" class="form form-horizontal frm_websetup"  method="POST" action="../actions/act_web_setup.php" enctype="multipart/form-data" autocomplete="off">
                                                            
                                                            <input type="text" class="hidden" name="chg_web_pht" id="chg_web_pht">
                                                            <div class="form-body">
                                                            <div class="form-group row">
                                                                    <label class="col-md-3 label-control mt-1">Desktop Web Icon</label>
                                                                    <div class="col-md-9 mx-auto">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="web_icon" name="web_icon">
                                                                            <label class="custom-file-label custom-file-w" aria-describedby="web_icon">Choose file</label>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                            
                                                                <div class="form-group row">
                                                                    <label class="col-md-3 label-control mt-1" for="web_name">Web Name</label>
                                                                    <div class="col-md-9 mx-auto">
                                                                        <input type="text" id="web_name" name="web_name" class="form-control" placeholder="Web Name">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                <input type="submit" class="btn  btn-primary pull-right hidefromuser sewebadd" value="Save Setup">
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- tab 2 -->
                                            <div class="tab-pane" id="tabVerticalLeft2" aria-labelledby="baseVerticalLeft-tab2">
                                                <div class="container">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" >
                                                            <label class="custom-control-label" for="customSwitch1">Enable Mailing System</label>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <form id="frm_mailer" class="form-horizontal" action="../actions/act_web_setup.php" method="post">

                                                        <div class="form-group">
                                                            <label for="mailer_add">Mailer Address</label>
                                                            <input class="form-control" type="email" placeholder="xxxxxx@gmail.com" name="mailer_add" id="mailer_add" value="<?php echo $u_mailer_usern ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="mailer_pass">Mailer Password</label>
                                                            <input class="form-control" type="password" name="mailer_pass" id="mailer_pass" value="<?php echo $u_mailer_passw ?>">
                                                        </div>

                                                        <input type="submit" class="btn btn-success" name="btn-mailer" id="btn-mailer" value="Save">
                                                        <input type="button" class="btn btn-danger" name="btn-mailer-test" id="btn-mailer-test" value="Click to Test">
                                                    </form>
                                                 
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tabVerticalLeft3" aria-labelledby="baseVerticalLeft-tab3">
                                            <p>Biscuit ice cream halvah candy canes bear claw ice cream cake chocolate bar donut. Toffee cotton
                                                candy liquorice. Oat cake lemon drops gingerbread dessert caramels. Sweet dessert jujubes powder
                                                sweet sesame snaps.</p>
                                            </div>
                                        </div>
                                    </div>
                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
                <!-- // card-actions section end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

        <?php include '../includes/footer.php' ?>
        <script src="../js/web_setup.js"></script>
<!-- END: Body-->

</body>
</html>
