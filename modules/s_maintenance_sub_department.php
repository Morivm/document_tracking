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

<div class="modal fade text-left mdl_main" id="mdl_main" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Setup Sub Department</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="frm_main" class="form form-horizontal frm_main" method="post" action="../actions/s_maintenance_sub_department_act.php" autocomplete="off">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="text_1"><label class="text-danger">*</label> Department</label>
                                <div class="col-md-9 mx-auto">
                                    <select class="form-control sel_cls_dep" name="text_1_1" id="text_1_1">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="text_1" data-toggle="tooltip" title="Sub Department Code"><span class="text-danger">*</span> Sub-Dept Code</label>
                                <div class="col-md-9 mx-auto">
                                    <input type="text" id="text_1" name="text_1" class="form-control capitalizefletter" placeholder="Department Code">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="text_2"  data-toggle="tooltip" title="Sub Department Name"><span class="text-danger">*</span> Sub-Dept Name</label>
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
                                <li class="breadcrumb-item active">Maintenance
                                </li>
                                <li class="breadcrumb-item active">Department
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
                                    <h4 class="card-title"><button class="btn btn-primary btn-actions" id="btn_create" name="btn_create" data-action="ADD"> <i class="las la-plus"></i> Add Sub Department</button> </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content ">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="tbl_main" class="table table-hover table-bordered table-striped tbl_main" style="width:100%">
                                                <thead class="cdtheadcolor">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Department</th>
                                                        <th>Sub-Department Code</th>
                                                        <th>Sub-Department</th>
                                                        <th>Action</th>
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

                pageLocation("li_mainte", "li_mainte_department_sub", "Sub-Departments");
                getDataSelect2("sel_cls_dep","SELECT DEPARTMENT","select_department")

                var s_table_main    = "";
                var s_action        = "";
                var s_id            = "";

                $(document).on('click', '.btn-actions', function(e){
                    e.preventDefault();
                    var actions = $(this).data('action');
                        if(actions =="ADD")
                        {
                            s_action = actions;
                            $("#mdl_main").modal("show");
                        }
                });


                $("form#frm_main").validate({
                    rules: {
                        text_1: {
                            required : true
                        },
                        text_2: {
                            required : true
                        },
                        text_1_1: {
                            required : true
                        }
                    },
                    messages: {
                        text_1: {
                            required    : "Sub-Department Code Is Required"
                        },
                        text_2: {
                            required    : "Sub-Department Name Is Required"
                        },
                        text_1_1: {
                            required    : "Department Is Required"
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.col-md-9').append(error);
                    },
                        highlight: function (element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                        unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    submitHandler: function(form) {

                        var formData    = new FormData(form);
                        formData.append('transaction', "");
                        formData.append('action', s_action);
                        formData.append('id', s_id);
                        $.ajax({
                            url         :   form.action,
                            type        :   form.method,
                            data        :   formData,
                            cache       :   false,
                            contentType :   false,
                            processData :   false,
                            dataType    :   "json",
                            beforeSend: function(){ 
                                openPageLoader();
                            },
                            success: function(response) {
                      
                                responseTosubmit(response[0], response[1], response[2], "frm_main", "tbl_main", "mdl_main");
                            }            
                        });
                    }
                });

                var table = $('#tbl_main').DataTable( {
        
                    'ajax': {
                        'method' : 'POST',
                        'url'    :'../actions/s_maintenance_sub_department_act.php',
                        'data'   : {
                                        s_table_main
                        },
                    },
                    'columnDefs': [
                        { "targets": 4,  "data": null, "defaultContent": "<button class='btn btn-primary edit_btn'> <i class='lar la-edit'></i>Edit</button>" },
                    ],

                    'columns': [
              
                        { data: 'row1' , visible : false},
                        { data: 'row2' },
                        { data: 'row3' },
                        { data: 'row4' },
          
                    ],

                    'order'  :   [[ 0, 'DESC']],
                    "initComplete":function( settings, json){
                        closePageLoader();
                    },
                });
                $('#tbl_main tbody').on( 'click', '.edit_btn', function () {
                    var data = table.row( $(this).parents('tr') ).data();

                    s_id = data['row1'];
                    s_action = "UPDATE";
                    $("#text_1").val(data['row2']);
                    $("#text_2").val(data['row3']);
              

                    $("#mdl_main").modal("show");
                    
                } );
            });
        </script>
</body>
</html>
