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

<!-- <div class="modal fade text-left mdl_main" id="mdl_main" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Setup Department</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="frm_main" class="form form-horizontal frm_main" method="post" action="../actions/s_maintenance_department_act.php" autocomplete="off">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="text_1"><label class="text-danger">*</label> Department Code</label>
                                <div class="col-md-9 mx-auto">
                                    <input type="text" id="text_1" name="text_1" class="form-control capitalizefletter" placeholder="Department Code">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="text_2"><label class="text-danger">*</label> Department Name</label>
                                <div class="col-md-9 mx-auto">
                                    <input type="text" id="text_2" name="text_2" class="form-control capitalizefletter" placeholder="Department Name">
                                </div>
                            </div>
                        </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-outline-primary" value="Save">
            </div>
            </form>
        </div>
    </div>
</div> -->
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
                                        <div class="row">
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
                                        </div>
                                        <!-- <button class="btn btn-primary btn-actions" id="btn_create" name="btn_create" data-action="ADD"> <i class="las la-plus"></i> Add Department</button>  -->
                                    </h4>
                                </div>
                                <!-- <div class="card-content ">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="tbl_main" class="table table-hover table-bordered table-striped tbl_main" style="width:100%">
                                                <thead class="cdtheadcolor">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Department Code</th>
                                                        <th>Department</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div> -->
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

                pageLocation("", "li_gen_barcode", "Generate Barcode");
            
                getDataSelect2("cls-employees","Select Person","select_employee");

                getDataSelect2("cls-type-of-person","Select Type","select_type_of_person");

                closePageLoader();



                $(document).on('click', '.btn-actions', function(e){
                    e.preventDefault();
                    var actions = $(this).data('action');

                    if(actions =="generate_barcode"){

                        var generate_barcode = "";
                        var userc_id = $("#txt1_1").val();
                        var typeofperson = $("#txt1_2").val(); 

                        $.ajax({

                            url         : "../actions/s_generate_barcode_act.php",
                            method      : "post",
                            dataType    : "json",
                            data  : {
                                generate_barcode,  userc_id, typeofperson
                                
                            },
                            beforeSend : function(){
                                openPageLoader();
                            },
                            success : function(response) {
                                closePageLoader();
                            
                                if(response[0] == "error") {
                                    responseTosubmit2(response[0], response[1] , response[2]);
                                }else{

                                    var update_print_bc = "";
                                    var win = window.open(`s_print_generate_barcode.php?ids=${response[2]}`, "thePopUp", "width=500,height=500");
                                        win.document.title = 'Generating ... Please Dont Close';
                                        var pollTimer = window.setInterval(function() {
                                            if (win.closed !== false) { // !== is required for compatibility with Opera
                                                window.clearInterval(pollTimer);
                                            $.ajax({
                                                url     : "../actions/s_generate_barcode_act.php",
                                                method  : "post",
                                                dataType : "json",
                                                data : {
                                                    update_print_bc
                                                },
                                                success : function (response) {
                                                    console.log(response);
                                                    if(response[0] =="success") {
                                                        location.reload();
                                                    }else{
                                                        responseTosubmit2(response[0], response[1] , response[2]);
                                                    }
                                                }

                                            });

                                            }
                                     }, 200);
                                     
                               


                                }
                            }

                        });

                    }else{
                        responseTosubmit2("error", "Error Found", "Please Reload Page First.");
                    }
                });
            



                // var s_table_main    = "";
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

                // var table = $('#tbl_main').DataTable( {
        
                //     'ajax': {
                //         'method' : 'POST',
                //         'url'    :'../actions/s_maintenance_department_act.php',
                //         'data'   : {
                //                         s_table_main
                //         },
                //     },
                //     'columnDefs': [
                //         { "targets": 3,  "data": null, "defaultContent": "<button class='btn btn-primary edit_btn'> <i class='lar la-edit'></i>Edit</button>" },
                //     ],

                //     'columns': [
              
                //         { data: 'row1' , visible : false },
                //         { data: 'row2' },
                //         { data: 'row3' },
          
                //     ],

                //     'order'  :   [[ 0, 'DESC']],
                //     "initComplete":function( settings, json){
                //         closePageLoader();
                //     },
                // });
                // $('#tbl_main tbody').on( 'click', '.edit_btn', function () {
                //     var data = table.row( $(this).parents('tr') ).data();

                //     s_id = data['row1'];
                //     s_action = "UPDATE";
                //     $("#text_1").val(data['row2']);
                //     $("#text_2").val(data['row3']);
              

                //     $("#mdl_main").modal("show");
                    
                // } );
            });
        </script>
</body>
</html>
