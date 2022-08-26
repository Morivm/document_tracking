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
<body class="vertical-layout vertical-menu 2-columns  fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">


<?php
    include '../includes/topbar.php';
    include '../includes/sidebar.php'
?>


<div class="modal fade text-left mdldocmov" id="mdldocmov" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Advance Search</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="frm1" class="form form-horizontal frm1" method="post" action="../actions/act_recieve_transfer.php" autocomplete="off">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-md-3 label-control">Barcode</label>
                            <div class="col-md-9">
                                <input type="text" id="hd_text_1_1" name="hd_text_1_1" class="form-control" placeholder="Enter Barcode">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="hd_text_1_2">Title</label>
                            <div class="col-md-9">
                                <input type="text" id="hd_text_1_2" name="hd_text_1_2" class="form-control" placeholder="Enter Title">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div id="div-results"></div>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn grey btn-success btn-actions" data-actions="search">Advanced Search</button>
       
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
                    <h3 class="content-header-title">Document Movement</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">History
                                </li>
                                <li class="breadcrumb-item active">Document Movement
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">

                </div>
            </div>
            <div class="content-body">
            <section id="sec_create_document">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                <button type="button" class="btn btn-success btn-actions" data-actions="advance_search">Advanced Search</button>
                                </div>
                                <div class="card-content ">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="tbl_1" class="table table-hover table-bordered table-striped tbl_1" style="width:100%">
                                                <thead class="cdtheadcolor">
                                                    <tr>
                                                        <th>Barcode</th>
                                                        <th>Document Type</th>
                                                        <th>Document Title</th>
                                                        <th>From</th>
                                                        <th>Transaction</th>
                                                        <th>DateTime</th>
                                                        <th>Received By</th>
                                                        <th>Received Date</th>
                                                        <th>Remarks</th>
                                                        <th>Attachment</th>
                                                        <th>Processing Time(hrs)</th>
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
        <script>
            pageLocation("li_histories", "li_histories_docmov", "Document Movement");
        
            var tbl_1 = "";

            $(document).on( 'click', '.btn-actions', function (e) {
                e.preventDefault();

                var actions = $(this).data('actions');

                if(actions == "advance_search") {

                    $("#mdldocmov").modal("show");
                }else if(actions == "search") {
                    var advance_search = "";
                    var barcode = $("#hd_text_1_1").val();
                    var title   = $("#hd_text_1_2").val();

                    $.ajax({
                        url         : "../actions/act_history.php",
                        method      : "POST",
                        dataType    : "JSON",
                        data        : {
                            advance_search , barcode , title
                        },
                        beforeSend : function() {
                            $("#div-results").html("");
                            webBlock2("Fetching Please Wait ...");
                        },
                        success : function(response) {
                            // alert(response);
                            $.unblockUI();
                            $("#div-results").html(response);
                        }
                    });
                }else{
                    responseTosubmit2("error", "Error Found", "Please Reload your page First.");

                }

            } );


            var table = $('#tbl_1').DataTable( {
                "oLanguage": {
                    "sSearch": "Search on Table"
                },
                'ajax': {
                    'method' : 'POST',
                    'url'    :'../actions/act_history.php',
                    'data'   : {
                        tbl_1
                    },
                },
                // 'columnDefs': [
                //     { "targets": 3,  "data": null, "defaultContent": "<button class='btn btn-primary edit_btn'>Edit</button> <button class='btn btn-warning addtousers_btn'>Add / Edit as User</button> "},
                // ],
                'columns': [
                    { data: 'row1' },
                    { data: 'row2' },
                    { data: 'row3' },
                    { data: 'row4' },
                    { data: 'row5' },
                    { data: 'row6' },
                    { data: 'row7' },
                    { data: 'row8' },
                    { data: 'row9' },
                    { data: 'row10' },
                    { data: 'row11' },
                ],
                // 'order'  :   [  [ 0, 'desc']],
                "initComplete":function( settings, json){
                    closePageLoader();
                },
            });
        </script>
</body>
</html>
