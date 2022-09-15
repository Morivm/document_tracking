<?php
    include 'session.php';

    // if($userrole != "SUPERADMIN") {
    //     header("Location: error404"); 
    // }
    include '../includes/header.php';
?>

<body class="vertical-layout vertical-menu 2-columns  fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">


<?php
    include '../includes/topbar.php';
    include '../includes/sidebar.php'
?>

<div class="modal fade text-left mdl_main" id="mdl_main" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Documents</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tbl_main2" class="table table-hover table-bordered table-striped tbl_main2" style="width:100%">
                            <thead class="cdtheadcolor">
                                <tr>
                                    <th>Document Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
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
                                <li class="breadcrumb-item active">Generate Barcode
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                </div>
            </div>
            <div class="content-body">
            <section id="ordering">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <!-- <div class="row">
                                            <div class="col-md-3">
                                                <select class="form-control cls-employees" id="txt1_1" name="txt1_1">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control cls-type-of-person" id="txt1_2" name="txt1_2">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-success btn-actions" data-action="generate_barcode">Generate Cover Page</button>
                                            </div>
                                        </div> -->
                       
                                    </h4>
                                </div>
                                <div class="card-content ">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="tbl_main" class="table table-hover table-bordered table-striped tbl_main" style="width:100%">
                                                <thead class="cdtheadcolor">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Details</th>
                                                        <th>Creator</th>
                                                        <th>Created Date</th>
                                                        <th>Availability</th>
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
        <script>
            $(function(){

                pageLocation("", "li_add_document", "Add/Update Documents");

                var s_table_main    = "";

                
            
                // getDataSelect2("cls-employees","Select Person","select_employee");

                // getDataSelect2("cls-type-of-person","Select Type","select_type_of_person");


                // $(document).on('click', '.btn-actions', function(e){
                //     e.preventDefault();
                //     var actions = $(this).data('action');

                //     if(actions =="generate_barcode"){

                //         var generate_barcode = "";
                //         var userc_id = $("#txt1_1").val();
                //         var typeofperson = $("#txt1_2").val(); 

                //         $.ajax({

                //             url         : "../actions/s_generate_barcode_act.php",
                //             method      : "post",
                //             dataType    : "json",
                //             data  : {
                //                 generate_barcode,  userc_id, typeofperson
                                
                //             },
                //             beforeSend : function(){
                //                 openPageLoader();
                //             },
                //             success : function(response) {
                //                 closePageLoader();
                            
                //                 if(response[0] == "error") {
                //                     responseTosubmit2(response[0], response[1] , response[2]);
                //                 }else{

                //                     var update_print_bc = "";
                //                     var win = window.open(`s_print_generate_barcode.php?ids=${response[2]}`, "thePopUp", "width=500,height=500");
                //                         win.document.title = 'Generating ... Please Dont Close';
                //                         var pollTimer = window.setInterval(function() {
                //                             if (win.closed !== false) { // !== is required for compatibility with Opera
                //                                 window.clearInterval(pollTimer);
                //                             $.ajax({
                //                                 url     : "../actions/s_generate_barcode_act.php",
                //                                 method  : "post",
                //                                 dataType : "json",
                //                                 data : {
                //                                     update_print_bc
                //                                 },
                //                                 success : function (response) {
                //                                     console.log(response);
                //                                     if(response[0] =="success") {
                //                                         location.reload();
                //                                     }else{
                //                                         responseTosubmit2(response[0], response[1] , response[2]);
                //                                     }
                //                                 }

                //                             });

                //                             }
                //                      }, 200);
                                     
                               


                //                 }
                //             }

                //         });

                //     }else{
                //         responseTosubmit2("error", "Error Found", "Please Reload Page First.");
                //     }
                // });
            




                // var s_action        = "";
                // var s_id            = "";
  

                // $(document).on('click', '.btn-actions', function(e){
                //     e.preventDefault();
                //     var actions = $(this).data('action');
                //         if(actions =="ADD")
                //         {
                //             s_action = actions;
                //             $("#mdl_main").modal("show");
                //         }
                // });


                // $("form#frm_main").validate({
                //     rules: {
                //         text_1: {
                //             required : true
                //         },
                //         text_2: {
                //             required : true
                //         },
                //     },
                //     messages: {
                //         text_1: {
                //             required    : "Department Code Is Required"
                //         },
                //         text_2: {
                //             required    : "Department Name Is Required"
                //         },
                //     },
                //     errorElement: 'span',
                //     errorPlacement: function (error, element) {
                //     error.addClass('invalid-feedback');
                //     element.closest('.col-md-9').append(error);
                //     },
                //         highlight: function (element, errorClass, validClass) {
                //         $(element).addClass('is-invalid');
                //     },
                //         unhighlight: function (element, errorClass, validClass) {
                //         $(element).removeClass('is-invalid');
                //     },
                //     submitHandler: function(form) {

                //         var formData    = new FormData(form);
                //         formData.append('transaction', "");
                //         formData.append('action', s_action);
                //         formData.append('id', s_id);
                //         $.ajax({
                //             url         :   form.action,
                //             type        :   form.method,
                //             data        :   formData,
                //             cache       :   false,
                //             contentType :   false,
                //             processData :   false,
                //             dataType    :   "json",
                //             beforeSend: function(){ 
                //                 openPageLoader();
                //             },
                //             success: function(response) {
                      
                //                 responseTosubmit(response[0], response[1], response[2], "frm_main", "tbl_main", "mdl_main");
                //             }            
                //         });
                //     }
                // });

                var table = $('#tbl_main').DataTable( {
                    'ajax': {
                        'method' : 'POST',
                        'url'    :'../actions/s_addupdate_doc_act.php',
                        'data'   : {
                                        s_table_main
                        },
                    },
                    // 'columnDefs': [
                    //     { "targets": 5,  "data": null, "defaultContent": "<button class='btn btn-primary btn-dl-files'>Download Files</button>" },
                    // ],

                    'columns': [
              
                        { data: 'row1' },
                        { data: 'row2', visible : false },
                        { data: 'row3' },
                        { data: 'row4' },
                        {
                            "className":      'options',
                            "render": function(data, type, full, meta){
                                if(full.row5 == 1) {
                                    return "Session On Going <image src='../img/web/circle_green.png' width='10px'>";
                                }else if(full.row5 == 0) {
                                    return "Session Done <image src='../img/web/circle_red.png' width='10px'>";
                                }else{
                                    return "";
                                }
                            }
                        }, 
                        {
                            "className":      'options',
                            "render": function(data, type, full, meta){
                                var barc = full.row1;
                                var baraction = `activity.php?activity=${barc}`;

                                if(full.row5 == 1) {
                                    return "<button class='btn btn-primary btn-dl-files'>View File</button> <button class='btn btn-success btn-gotosession'>Go to Session</button> ";
                                }else if(full.row5 == 0) {
                                    return "<button class='btn btn-primary btn-dl-files'>View File</button>";
                                }else{
                                    return "";
                                }
                            }
                        },
                        
                    ],

                    'order'  :   [[ 0, 'DESC']],
                    "initComplete":function( settings, json){
                        // SyncDocument();
                        closePageLoader();
                    },
                });
                $('#tbl_main tbody').on( 'click', '.btn-dl-files', function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    var getFileondb = "";
                    var barcode = data['row1'];
              
                    window.open(`s_print_blob_db.php?barcode=${barcode}`);
                } );
                $('#tbl_main tbody').on( 'click', '.btn-gotosession', function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    var barcode = data['row1'];
                    window.location.replace(`activity.php?red=${makerandom(400)}&&activity=${barcode}&&det=${makerandom(400)}`);
                } );
            });


            let SyncDocument=() =>{
                var view_documents = "";
                $.ajax({
                        url : "../actions/s_addupdate_doc_act.php",
                        method : "post",
                        dataType : "json", 
                        data : {
                            view_documents
                        },
                        beforeSend : function() {
                            openPageLoader();
                        },
                        success : function (response) {
                            
                            closePageLoader();

                            // if(response[0] != "success") {
                            //     responseTosubmit2(response[0], response[1], response[2]);

                            // }
                        }

                    });
                
            }

        </script>
</body>
</html>
