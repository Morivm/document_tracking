<?php
    include 'session.php';
    if(getUsrtpe($userid,$conn) == 3) {
        header("Location: error404.php");
    }else if(getUsrmdodl($userid,"seusallset",$conn) =="have" ) {
        header("Location: error404.php");
    }else if(getUsrmdodl($userid,"semaintemod",$conn) =="have") {
        header("Location: error404.php");
    }else if(getUsrmdodl($userid,"semainteanmod",$conn) =="have") {
        header("Location: error404.php");
    }

    include '../includes/header.php';
?>

<body class="vertical-layout vertical-menu 2-columns  fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">


<?php
    include '../includes/topbar.php';
    include '../includes/sidebar.php'
?>

    <div class="modal fade text-left" id="mdl_create" tabindex="-1" role="dialog" aria-labelledby="myModalmdl_create" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Asset Name</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <form id="frm_mainte_asset_name" class="form form-horizontal" method="post" action="action_maintenance.php" autocomplete="off">
                            <input type="hidden" name="input_mainteasset_name" id="input_mainteasset_name">
                            <div class="form-body">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="text_1">Asset Name</label>
                                    <div class="col-md-9 mx-auto">
                                        <input type="text" id="text_1" name="text_1" class="form-control capitalizefletter" placeholder="Asset Name" >
                                    </div>
                                </div>
                            </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-outline-primary" value="Save Asset Name">
                </div>
                </form>
            </div>
        </div>
    </div>





    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Create Document</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Transactions
                                </li>
                                <li class="breadcrumb-item active">Create Document
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                </div>
            </div>
            <div class="content-body">
            <section id="sec_create document">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><button class="btn btn-primary" id="btn_create" name="btn_create"> Create Document</button> </h4>
                                </div>
                                <div class="card-content ">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="tbl_asset" class="table table-hover table-bordered table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>#</th>
                                                        <th>Asset Name</th>
                                                        <th>Added By</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
        <?php include '../includes/footer.php' ?>
        <script src="../js/create_document.js"></script>
</body>
</html>
