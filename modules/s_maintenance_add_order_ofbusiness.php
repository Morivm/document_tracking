<?php
    include 'session.php';
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
                <h4 class="modal-title" id="mdl_main_title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="frm_main" class="form form-horizontal frm_main" method="post" action="../actions/s_maintenance_add_order_ofbusiness_act.php" autocomplete="off">
                        <div class="form-body">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control mt-1" for="text_1"><label class="text-danger">*</label> Order of Business</label>
                                    <div class="col-md-9 mx-auto">
                                        <input type="text" id="text_1" name="text_1" class="form-control textCapitalall" placeholder="Order of Business">
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
                                <li class="breadcrumb-item active">Add Order of Business
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
                                    <h4 class="card-title"><button class="btn btn-primary btn-actions" id="btn_create" name="btn_create" data-action="ADD"> Add Order of Business</button> </h4>
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
                                                        <th>Id</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Added By</th>
                                                        <th>Added Date</th>
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
        <?php 
            include '../includes/footer.php' ?>
        <script>

$(function(){

    pageLocation("li_mainte", "li_mainte_orderofbus", "Order of Busines");

    var s_action        = "";
    var s_id            = "";
    var s_table_main    = "";

    $(document).on('click', '.btn-actions', function(e){
        e.preventDefault();
        var actions = $(this).data('action');
            if(actions =="ADD") {
                s_action = actions;
                s_id     = "";
                $("#mdl_main_title").text("Add Order of Business");
                $("#frm_main").trigger("reset");
                $("#mdl_main").modal("show");
            }
    });



    var table = $('#tbl_main').DataTable( {

        'ajax': {
            'method' : 'POST',
            'url'    :'../actions/s_maintenance_add_order_ofbusiness_act.php',
            'data'   : {
                            s_table_main
            },
        },
        'columnDefs': [
                        { "targets": 5,  "data": null, "defaultContent": "<button class='btn btn-primary edit_btn'> Edit</button> <button class='btn btn-danger btn_delete'>Delete</button>" },
                    ],

        'columns': [
            { data: 'row1' , visible : false},
            { data: 'row2' },
            { data: 'row3' },
            { data: 'row4' },
            { data: 'row5' },

        ],
        'order'  :   [[ 0, 'DESC']],
        "initComplete":function( settings, json){
            closePageLoader();
        },
    });
    $('#tbl_main tbody').on( 'click', '.edit_btn', function () {
        var data = table.row( $(this).parents('tr') ).data();
        var id = data['row1'];
        s_id = id;
        s_action = "UPDATE";
        $("#text_1").val(data['row2']);

        $("#mdl_main_title").text("Update Order of Business");
        $("#mdl_main").modal("show");
        
    });
    $('#tbl_main tbody').on( 'click', '.btn_delete', function () {
        var data = table.row( $(this).parents('tr') ).data();
        var id = data['row1'];
        s_id = id;
        s_action = "DELETE";
        var orderofbusinessname = data['row2'];

        Swal.fire({
            title: `Are you sure you want to Delete ${orderofbusinessname} `,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, Delete it `
        }).then((result) => {
            if (result.value) {
                var transaction = "";
                var action = "DELETE";
                var text_1 = "";
                $.ajax({
                    url : "../actions/s_maintenance_add_order_ofbusiness_act.php",
                    method : "post",
                    dataType : "json",
                    data : {
                        transaction , action,  text_1,  id, 
                    },
                    beforeSend : function(){
                        openPageLoader();
                    },
                    success : function(response) {

                        responseTosubmit(response[0], response[1], response[2], "frm_main", "tbl_main", "mdl_main");
                    }
                });



            }
        })

        
        // $("#text_1").val(data['row6']);
        // $("#text_2").val(data['row7']);
        // $("#text_3").val(data['row8']);

    });


    $("form#frm_main").validate({
        rules: {
            text_1: {
                required : true
            },
 
        },
        messages: {
            text_1: {
                required    : "Order of Business is Required"
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



}); 
            // $(function(){
            //    
            //     getDataSelect2("cls_dep_new","Choose Department","sel_depwithcode");
            //     getDataSelect2("cls_roles_new","Choose Roles","sel_roles");
                

            //     var s_table_main    = "";
            //     var s_action        = "";
            //     var s_id            = "";
            //     var s_id1           = "";
            //     var s_userid        = "";
            //     var s_getUsername   = "";
            //     var s_getEmail      = "";
            //     var s_getMobile     = "";

            //   


           

            //     $("form#frm_main2").validate({
            //         rules: {
            //             text1_1: {
            //                 required : true
            //             },

            //             text1_4: {
            //                 equalTo : "#text1_2"
            //             },
            //             text1_3: {
            //                 required : true
            //             },
            //         },
            //         messages: {
            //             text1_1: {
            //                 required    : "User Name is Required"
            //             },
            //             text1_3: {
            //                 required    : "Role Is Required",
            //             }
            //         },
            //         errorElement: 'span',
            //         errorPlacement: function (error, element) {
            //         error.addClass('invalid-feedback');
            //         element.closest('.col-md-9').append(error);
            //         },
            //             highlight: function (element, errorClass, validClass) {
            //             $(element).addClass('is-invalid');
            //         },
            //             unhighlight: function (element, errorClass, validClass) {
            //             $(element).removeClass('is-invalid');
            //         },
            //         submitHandler: function(form) {
            //             var formData    = new FormData(form);
            //             formData.append('transaction1', "");
            //             formData.append('fullname', s_id1);
            //             formData.append('userid', s_userid);
            //             formData.append('text1_5', s_getUsername);
                        
            //             $.ajax({
            //                 url         :   form.action,
            //                 type        :   form.method,
            //                 data        :   formData,
            //                 cache       :   false,
            //                 contentType :   false,
            //                 processData :   false,
            //                 dataType    :   "json",
            //                 beforeSend: function(){ 
            //                     webBlock2("Saving Changes...");
            //                 },
            //                 success: function(response) {
    
            //                     responseTosubmit(response[0], response[1], response[2], "frm_main2", "tbl_main", "mdl_main2");
                            
            //                 }            
            //             });
            //         }
            //     });

            //     var table = $('#tbl_main').DataTable( {
        
            //         'ajax': {
            //             'method' : 'POST',
            //             'url'    :'../actions/maintenance_addemployee_act.php',
            //             'data'   : {
            //                             s_table_main
            //             },
            //         },
            //         'columns': [
            //             { data: 'row1' ,
            //                 "render": function (data) {

            //                     var xhr = new XMLHttpRequest();
            //                     xhr.open('HEAD', `../img/users/${data}.jpg`, false);
            //                     xhr.send();
                                
            //                     if (xhr.status == "404") {
            //                         return `<img class="rounded-circle" src="../img/users/noimage.png" width="50">`;
            //                     } else {
            //                         return `<img class="rounded-circle" src="../img/users/${data}.jpg" width="50">`;
            //                     }
                                
            //                 }
            //             },
            //             { data: 'row2' },
            //             { data: 'row3' },
            //             {
            //                 "className":      'options',
            //                 "render": function(data, type, full, meta){
            //                     if (full.row4 == 0) {
            //                         return "<button class='btn btn-primary edit_btn'>Edit</button> <button class='btn btn-warning addtousers_btn'>Add / Edit as User</button><label class='text-danger'> <i> &nbsp;&nbsp; Not Yet a User</i></label>"
            //                     }else{
            //                         if (full.row5 == 0) {
            //                             return "<button class='btn btn-primary edit_btn'>Edit</button> <button class='btn btn-warning addtousers_btn'>Add / Edit as User</button> <button class='btn btn-success clk_enable'>Click to Enable</button>"
            //                         }else{
            //                             return "<button class='btn btn-primary edit_btn'>Edit</button> <button class='btn btn-warning addtousers_btn'>Add / Edit as User</button> <button class='btn btn-danger clk_enable'>Click to Disable</button>"
            //                         }

            //                     }
            //                 }
            //             },

            //         ],
            //         'order'  :   [[ 0, 'DESC']],
            //         "initComplete":function( settings, json){
            //             closePageLoader();
            //         },
            //     });
            //     $('#tbl_main tbody').on( 'click', '.edit_btn', function () {
            //         var data = table.row( $(this).parents('tr') ).data();
            //         $("#text_1").val(data['row2'].split(',')[0]);
            //         $("#text_2").val($.trim(data['row2'].split(',')[1]));
            //         $("#text_3").val(data['row3']).trigger("change");
            //         $("#text_4").val(data['row6']);
            //         $("#text_5").val(data['row7']);

            //         s_getEmail = data['row6'];
            //         s_getMobile= data['row7'];
            //         s_id = data['row1'];
            //         s_action = "UPDATE";
            //         $("#mdl_main").modal("show");
                    
            //     });
            //     $('#tbl_main tbody').on( 'click', '.addtousers_btn', function () {
            //         var data = table.row( $(this).parents('tr') ).data();
            //         viewUserinfo(data['row2']);
            //         s_id1 = data['row2'];
            //         s_userid = data['row1'];
            //         $("#mdl_main2").modal("show");
            //         $("#res1").text(data['row2']);
            //         $("#res2").text(data['row3']);

            //     });
            //     $('#tbl_main tbody').on( 'click', '.clk_enable', function () {
            //         var data = table.row( $(this).parents('tr') ).data();
            //         Swal.fire({
            //             title: `Are you sure you want to ${ ( data['row5'] == 0 ? "Enable" : "Disable" ) } this Account?`,
            //             type: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#3085d6',
            //             cancelButtonColor: '#d33',
            //             confirmButtonText: `Yes, ${ ( data['row5'] == 0 ? "Enable It" : "Disable It" ) }  `
            //         }).then((result) => {
            //             if (result.value) {
            //                 enableDisableact(data['row2'], data['row5']);
            //             }
            //         })


            //     });

            //     let viewUserinfo = (fullname) =>{ 
                
            //         let viewinfo    = "";
            //         $.ajax({
            //             url         :   `../actions/maintenance_addemployee_act.php?fullname=${fullname}`,
            //             method      :   "GET",
            //             dataType    :   "json",
            //             data        :   {
            //                     viewinfo
            //             },
            //             beforeSend : function() {
            //                 webBlock2("Fetching...");
            //                 $("#res3").html("");
            //             },
            //             success : function (response){
            //                 $.unblockUI();
            //                 $("#text1_1").val(response[2]);
            //                 s_getUsername = response[2];
                
            //                 $("#res3").text(response[4]);
            //                 $("#text1_3").val(response[3]).trigger("change");
            //             }
            //         })
            //     }
            // });

           
            // let enableDisableact = (acctname, acctstastus) => { 
            //     var enDisableAct = "";

            //     $.ajax({
            //         url     : "../actions/maintenance_addemployee_act.php",
            //         method  : "POST",
            //         dataType: "JSON",
            //         data    : {
            //              enDisableAct, acctname, acctstastus
            //         },
            //         beforeSend : function(params) {
            //             webBlock2("Updating...");
            //         },
            //         success :function (response){
            //             responseTosubmit(response[0], response[1], response[2], "frm_main", "tbl_main", "mdl_main");

            //         }

            //     })
            // }

        </script>
</body>
</html>
