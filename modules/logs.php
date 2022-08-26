<?php
    include 'session.php';
    // if(getUsrtpe($userid,$conn) == 3) {
    //     header("Location: error404.php");
    // }else if(getUsrmdodl($userid,"seusallset",$conn) =="have" ) {
    //     header("Location: error404.php");
    // }else if(getUsrmdodl($userid,"semaintemod",$conn) =="have") {
    //     header("Location: error404.php");
    // }else if(getUsrmdodl($userid,"semainteanmod",$conn) =="have") {
    //     header("Location: error404.php");
    // }

    include '../includes/header.php';
?>
<style>
    .card{
    margin-bottom: 10px;
    }
</style>
<body class="vertical-layout vertical-menu 2-columns  fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">


<?php
    include '../includes/topbar.php';
    include '../includes/sidebar.php'
?>

    <!-- BEGIN: Main Menu-->

    <!-- END: Main Menu-->
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"></h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Logs
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <!-- <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                        <button class="btn btn-info round box-shadow-2 px-2 mb-1" id="link_log" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="las la-history"></i> Logs
                        </button>
                    </div> -->
                </div>
            </div>
            <div class="content-body">
            <section id="ordering">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                   
                                    <!-- <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div> -->
                                </div>
                                <div class="card-content">
                                <form class="form-horizontal">
                                        <div class="form-body col-md-12">
                                            <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-2 label-control mt-1" for="text_1">Type</label>
                                                <div class="col-md-4">
                                                    <select class="form-horizontal sel_1" id="text_1" name="text_1">
                                                        <option val="">
                                                        </option>
                                                    </select>
                                                </div>
                                                <label class="col-md-2 label-control mt-1" for="text_4">Action By</label>
                                                <div class="col-md-4">
                                                    <select class="form-horizontal sel_4" id="text_4" name="text_4">
                                                        <option val="">
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 label-control mt-1" for="text_2">Action</label>
                                                <div class="col-md-4">
                                                    <select class="form-horizontal sel_2" id="text_2" name="text_2">
                                                        <option val="">
                                                        </option>
                                                    </select>
                                                </div>
                                                <label class="col-md-2 label-control mt-1" for="text_5">Date</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="text_5" name="text_5" class="form-control" placeholder="Choose Date" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 label-control mt-1" for="text_3">ID</label>
                                                <div class="col-md-4 ">
                                                    <select class="form-horizontal sel_3" id="text_3" name="text_3">
                                                        <option val="">
                                                        </option>
                                                    </select>
                                                </div>
                                                <!-- <label class="col-md-2 label-control mt-1 d-none" for="text_6">ID</label>
                                                <div class="col-md-4 mx-auto d-none">
                                                    <select class="form-horizontal sel_6" id="text_6" name="text_6">
                                                        <option val="">
                                                        </option>
                                                    </select>
                                                </div> -->
                                            </div>

                                            
                                        </div>
                                        
                                    </form>
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="tbl_attendancedetails" class="table" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th class="th_id">ID</th>
                                                        <th class="th_action">Action</th>
                                                        <th class="th_type">Type</th>
                                                        <th>Detailed Action</th>
                                                        <th class="th_actionby">Action By</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tfoot class="d-none">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>#</th>
                                                        <th>Action</th>
                                                        <th>Type</th>
                                                        <th>Detailed Action</th>
                                                        <th>Action By</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

<!--     
    <div class="modal fade text-left mdl_add" id="mdl_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <form id="frm_mainte_addevent" class="form form-horizontal frm_mainte_addevent" method="post" action="action_maintenance.php" autocomplete="off">
                            <input type="hidden" name="input_mainteevents" id="input_mainteevents">
                            <div class="form-body">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="text_1">Event Name</label>
                                    <div class="col-md-9 mx-auto">
                                        <input type="text" id="text_1" name="text_1" class="form-control capitalizefletter" placeholder="Event Name" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="text_2">Start Time</label>
                                    <div class="col-md-9 mx-auto">
                                        <input type="time" class="form-control" id="text_2" name="text_2">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="text_3">End Time</label>
                                    <div class="col-md-9 mx-auto">
                                        <input type="time" class="form-control" id="text_3" name="text_3">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="text_4">Description</label>
                                    <div class="col-md-9 mx-auto">
                                        <textarea class="form-control" name="text_4" id="text_4" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-outline-primary" value="Save Event">
                </div>
                </form>
            </div>
        </div>
    </div> -->
<!-- 
    <div class="modal fade text-left" id="mdl_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Asset Name</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                    <div class="modal-body">
                    
                        <form id="frm_mainte_asset_name_edit" class="form form-horizontal" method="post" action="action_maintenance.php" autocomplete="off">
                            <input type="hidden" name="input_mainteassetname_edit" id="input_mainteassetname_edit">
                            <input type="hidden" name="input_mainteassetname_id" id="input_mainteassetname_id">
                            <div class="form-body">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="text_1_edit">Asset Name Name</label>
                                    <div class="col-md-9 mx-auto">
                                        <input type="text" id="text_1_edit" name="text_1_edit" class="form-control capitalizefletter" placeholder="Asset Name" >
                                    </div>
                                </div>
                            </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-outline-primary btn_status" value="Update Asset Name">
                </div>
                </form>
            </div>
        </div>
    </div> -->

    <!-- <div class="modal fade text-left" id="mdl_log" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Logs</h4>
                </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="tbl_logs" class="table table-hover table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Action</th>
                                        <th>Action By</th>
                                        <th>Date</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div> -->
    
            </div>
        </div>
    </div>
    <!-- END: Content-->

        <?php include '../includes/footer.php' ?>

        <script src="../js/logs.js"></script>
<!-- END: Body-->

</body>
</html>
