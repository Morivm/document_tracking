<?php
    include 'session.php';
  

    include '../includes/header.php';
?>
<body class="vertical-layout vertical-menu 2-columns  fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">


<?php
    include '../includes/topbar.php';
    include '../includes/sidebar.php';
    include 'modal/mdl_createdoc.php'
?>
<div class="modal fade text-left mdl_print" id="mdl_print">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Print</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <h1>Do You Want To Print?</h1>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                <input type="button" class="btn btn-outline-primary btn-actions" id="btn-print" data-action="print" data-barcode=""  value="Print">
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left mdl_2" id="mdl_2" tabindex="-1" role="dialog" aria-labelledby="myModalmdl_cancel" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cancel Document</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="frm_2" class="form form-horizontal frm_2" method="post" action="../actions/act_history_created_doc.php"  autocomplete="off">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="text_4">Remarks</label>
                            <div class="col-md-9 mx-auto">
                                <textarea class="form-control" name="text_2_1" id="text_2_1" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-outline-danger" value="Cancel Document">
                </div>
                    </form>
            </div>
        </div>  
    </div>
</div>

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Update/ Cancel</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">History
                                </li>
                                <li class="breadcrumb-item active">Update/ Cancel
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
                                </div>
                                <div class="card-content ">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="tbl_1" class="table table-hover table-bordered table-striped tbl_1" style="width:100%">
                                                <thead class="cdtheadcolor">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Barcode</th>
                                                        <th>Reason</th>
                                                        <th>Date Created</th>
                                                        <th>Status</th>
                                                        <th>Date Updated</th>
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
        pageLocation("li_histories", "li_histories_createdoc", "Created Doc");
        $(".show_on_returndoc").removeClass("hidden");
        $("#mdl1title").text("Edit Document");
        
        getDataSelect2("sel_doctype","Select Document Type","select_doctype");
        getDataSelect2("sel_processby","Select Process By","select_processby");
        getDataSelect2("sel_department","Select Department","select_department");

        var gbarcode = "";
        /* ========================= CLICKED ========================= */

        $(document).on('click', '#btn_editsignatories', function(e){
            Swal.fire({
                title: 'All Signatories will be deleted and need to enter again?',
                html: "You may click <b>view signatories</b> for checking of deleted signatories",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Edit Signatories!'
            }).then((result) => {
                if (result.value) {
                    var barcode = $("#text_2").val();
                    $("#btn_editsignatories").attr("disabled", true);
                    $("#hide_on_returndoc").removeClass("hidden");
                    checkAssignatiries("new",barcode);
                }
            })
        });
        $(document).on('click', '#btn_editattachments', function(e){
            $("#btnreuploadfile").removeClass("hidden");
            window.location.href = `recieve_transfer_download.php?barcode=${gbarcode}`;
        });
        $( "#btnreuploadfile" ).click(function() {
            var reuploadattach = "";
            Swal.fire({
                title: 'Did you make any changes in attachments?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    att_barcode = gbarcode;
                    Swal.fire({
                            title: 'Old attachments will be deleted and cannot be undone, please attach it again if still needed.',
                            text: "Would you like to proceed?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.value) {
                                $("#btnreuploadfile").remove();
                                $("#text_10").removeClass("hidden");
                                
                                $.ajax({
                                    url     : "../actions/act_recieve_transfer.php",
                                    method  : "POST",
                                    dataType: "json",
                                    data    : {
                                        reuploadattach, att_barcode
                                    },
                                    success : function (response){
                    
                                        if(response[0] =="success"){
                                            $(".div_reuplaodfile").removeClass("hidden");
                                            // $("#cls-dlattachment,#icon_download").addClass("hidden");
                                        }else{
                                            responseTosubmit2(response[0], response[1], response[2]);
                                        }
                                    }
                                });
                                
                            }
                        });

                    };
                }
            );

        });
        $(document).on('click', '#cancelreturn', function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure you want to Cancel this Document?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel it!'
            }).then((result) => {
                if (result.value) {
                    $("#mdl_2").modal("show");
                    $("#mdl_create").modal("hide");
                }
            })


        });


        
        $(document).on("change","#text_6",function(e){
            e.preventDefault();
            var selval2 = $(this).val(); 


            if(selval2 == "OTHERS") {
                $(".custom-processby").removeClass("hidden");
                $("#text6_0").css("border-color", "red");

            }else{
                $("#text6_0").val("");
                $(".custom-processby").addClass("hidden");
            
            }
        })


        $(document).on('click', '.btn-actions', function(e){
            var actions = $(this).data("action");

            if(actions =="delete_tmp") {
                var remove_tmp_receivingdept = "";
                var id      = $(this).data("id");
                $.ajax({
                    url     : "../actions/act_create_document.php",
                    method  : "POST",
                    dataType: "JSON",
                    data    : {
                        remove_tmp_receivingdept, id
                    },
                    beforeSend : function() {
                        webBlock2("Adding Signatories...");
                    },
                    success: function(response) {
                        responseTosubmit(response[0], response[1], response[2], "0", "0", "0");
                        if(response[0] == "success") {
                            reloadTmp(response[3]);
                            $("#label_finalapproving").text(response[4]);
                            if(response[4] =="") {
                                $("#text_5").val("");
                            }else{
                                $("#text_5").val(response[4]);
                            }
                            
                        }
                    }
                }); 
            }else if(actions =="receiving_dept"){
                var tmp_receivingdept   = "";
                var receiving_dept      = $("#text_7 :selected").text();
                var barcode             = $("#text_2").val();
            
            
                if(receiving_dept == "- Select -") {
                    responseTosubmit2("error","No Signatories Selected", "Please Select Signatories From the dropdown");
                }else{
                    $.ajax({
                        url     : "../actions/act_create_document.php",
                        method  : "POST",
                        dataType: "JSON",
                        data    : {
                            tmp_receivingdept, barcode,  receiving_dept
                        },
                        beforeSend : function() {
                            webBlock2("Adding Signatories...");
                        },
                        success: function(response) {
                            responseTosubmitcustomselect(response[0], response[1], response[2], "0", "0", "0");
                            if(response[0] == "success") {
                                reloadTmp(response[3]);
                                $("#label_finalapproving").text(receiving_dept);
                                $("#text_5").val(receiving_dept);
                            }
                        }

                    }); 
                }
            }else  if(actions =="print") {
                var barcode = $(this).data("barcode");
                window.open(`pr/${barcode}.pdf`,"popupWindow", "width=900,height=900,scrollbars=yes");
                $("#mdl_print").modal("hide");
            }

        });


        var tbl_1 = "";
        var table = $('#tbl_1').DataTable( {
            'ajax': {
                'method' : 'POST',
                'url'    :'../actions/act_history_created_doc.php',
                'data'   : {
                    tbl_1
                },
            },
            'columnDefs': [
                { "targets": 6,  "data": null, "defaultContent": "<button class='btn btn-danger edit_btn'>Update / Cancel Document</button>"},
            ],
            'columns': [
                { data: 'row1', visible : false },
                { data: 'row2' },
                { data: 'row3' },
                { data: 'row4' },
                { data: 'row5' },
                { data: 'row6' },
            ],
            // 'order'  :   [[ 5, 'desc']],
            "initComplete":function( settings, json){
                closePageLoader();
            },
        });
        $('#tbl_1 tbody').on( 'click', '.edit_btn', function () {
            var check_ifapproved ="";
            var check_doc_returned = "";
            var data = table.row( $(this).parents('tr') ).data();
            var barcode = data['row2'];
            gbarcode = barcode;
            $("#frm_doccreate").attr("action", "../actions/act_history_created_doc.php")
            $("#attachehiddenonreturn").hide();
            cleartmp(barcode);
            $.ajax({

                url     : "../actions/act_history_created_doc.php",
                method  : "post",
                dataType: "json",
                data    : {
                    check_ifapproved , barcode
                },
                beforeSend : function() {
                    webBlock2("Fetching Details");
                },
                success : function(response) {
                
                    if(response[0] =="error") {
                        $.unblockUI();
                        responseTosubmit2(response[0], response[1], response[2]);
                    }else{
                        $.ajax({
                            url     : "../actions/act_history_created_doc.php",
                            method  : "post",
                            dataType: "json",
                            data    : {
                                check_doc_returned , barcode
                            },
                            beforeSend : function() {
                                webBlock2("Fetching Details");
                            },
                            success : function(response) {
                                if(response[0] =="success") {
                                    $("#text_2").val(response[1]);
                                    $("#text_3").val(response[2]).trigger("change");
                                    $("#text_3").select2({disabled:'readonly'});
                                    $("#text_4").val(response[3]);
                                    $("#text_6").val(response[6]);
                                    // $("#text_6").val(response[6]).trigger("change");
                                    $("#text_9").val(response[5]);
                                
                                    checkAssignatiries("old",barcode);
                                  
                                }else{
                                    responseTosubmit2(response[0], response[1], response[2]);
                                }
                            }
                        });
                    }
                
                }
            });
        });

        
        $('#mdl_print').on('hidden.bs.modal', function () {
            window.location.reload();
        })


    });

    $("form#frm_doccreate").validate({
        rules: {
            text_2: {
                required : true
            },
            text_3: {
                required : true
            },
            text_4: {
                required : true
            },
            text_5: {
                required : true
            },
            text_6: {
                required : true
            },
            
        },
        messages: {
            text_2: {
                required    : "Barcode Is Required"
            },
            text_3: {
                required    : "Doctype Is Required"
            },
            text_4: {
                required    : "Document Title Is Required"
            },
            text_5: {
                required    : "Final Approving Authority Is Required"
            },
            text_6: {
                required    : "Approved By Is Required"
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

            var formData = new FormData(form);
            var table = $('#tbl_tmp').DataTable();
            var countrow = table.rows().count();

            if(countrow == 0) {
                responseTosubmit2("error", "Error Found", "Please provide at least 1 Receiving Signatories")
            }else{
                $.ajax({
                    url         :   form.action,
                    type        :   form.method,
                    data        :   formData,
                    cache       :   false,
                    contentType :   false,
                    processData :   false,
                    dataType    :   "json",
                    beforeSend: function(){ 
                        webBlock2("Generating Updated Document Please Dont Close Any Pop-up.");
                    },
                    success: function(response) {
                    
                        if(response[0] == "success") {

                            var win = window.open(`print_project_proposal_returned.php?barcode=${response[3]}`, "thePopUp", "width=200,height=200");
                            win.document.title = 'Generating ... Please Dont Close';
                            var pollTimer = window.setInterval(function() {
                                if (win.closed !== false) { // !== is required for compatibility with Opera
                                    window.clearInterval(pollTimer);
                                    $("#mdl_print").modal("show");
                                    responseTosubmit(response[0], response[1], response[2], "frm_doccreate", "tbl_1", "mdl_create");
                                }
                            }, 200);

                            $("#btn-print").data('barcode',response[3]);

                            // window.open(`print_project_proposal_returned.php?barcode=${response[3]}`,"popupWindow", "width=200,height=200,scrollbars=yes");      
                            // responseTosubmit(response[0], response[1], response[2], "frm_doccreate", "tbl_1", "mdl_create");
                        
                        }else{
                            responseTosubmit2(response[0], response[1], response[2]);
                        }

                   
                    }            
                });
            }
        }
    });

    $("form#frm_2").validate({
        rules: {
            text_2_1: {
                required : true
            }
        },
        messages: {
            text_2_1: {
                required    : "Remarks is Required"
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

                Swal.fire({
                    title: 'Are you sure you want to proceed.',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Proceed'
                }).then((result) => {
                    if (result.value) {
                        var doctypname  = $('#text_3').find(":selected").text();
                        var b_barcode   = $('#text_2').val();
                        var b_doctitle  = $('#text_4').val();
                        var b_desc      = $('#text_9').val();
                        var b_finalapp  = $('#text_5').val();
     

                        var formData = new FormData(form);
                        formData.append('cancel_doc', "");
                        formData.append('doctypename', doctypname);
                        formData.append('barcode', b_barcode);
                        formData.append('doctitle', b_doctitle);
                        formData.append('description', b_desc);
                        formData.append('plm', b_finalapp);

                        $.ajax({
                            url         :   form.action,
                            type        :   form.method,
                            data        :   formData,
                            cache       :   false,
                            contentType :   false,
                            processData :   false,
                            dataType    :   "json",
                            beforeSend: function(){ 
                                webBlock2("Generating ...");
                            },
                            success: function(response) {  
                                responseTosubmit(response[0], response[1], response[2], "frm_2", "tbl_1", "mdl_2");
                            }            
                        });

                    }
                })
        }
    });


    let checkAssignatiries = (check,barcode) => {
        var checkassignatories = "";
        
        $("#tbl_tmp").DataTable( {
            "destroy" :     true,
            'ajax': {
                'url'       :  "../actions/act_history_created_doc.php",
                'method'    :  "POST",
                'dataType'  : "JSON",
                'data'      :  {
                    checkassignatories, check, barcode
                }
            },
            // 'columnDefs': [
            //             { "targets": 2,  "data": null, "defaultContent": "<button type='button' class='btn btn-primary btn-actions' data-action='delete_tmp'>Delete</button>" },
            // ],     
            'columns': [
                { data: 'row1' , visible : false  },
                { data: 'row2'  },
                { data: 'row3'  },
            ],
            "initComplete":function( settings, json){
                $.unblockUI();
       
                $("#mdl_create").modal("show");
            
            },
        });
       
    }
    let reloadTmp = (barcode) => {
        var tmp_receiving_dept = "";
        var tmp_receiving_dept_barcode = barcode;
   
        $("#tbl_tmp").DataTable( {

            "destroy" :     true,
            'ajax': {
                'url'       :  "../actions/act_create_document.php",
                'method'    :  "POST",
                'dataType'  : "JSON",
                'data'      :  {
                                tmp_receiving_dept, tmp_receiving_dept_barcode
                }
            },
            // 'columnDefs': [
            //             { "targets": 2,  "data": null, "defaultContent": "<button type='button' class='btn btn-primary btn-actions' data-action='delete_tmp'>Delete</button>" },
            //     ],
            'columns': [
                { data: 'row1', visible : false },
                { data: 'row2' },
                { data: 'row3' },
            ],
            // 'order'  :   [[ 0, 'desc']],
        });

    }
    let cleartmp = (uniquibarcode) => {

        var cleartmptbl     = "";
        var barcode_id      = uniquibarcode;

        $.ajax({

            url     : "../actions/act_create_document.php",
            method  : "post",
            dataType: "json",
            data    : {
                cleartmptbl , barcode_id
            },
            beforeSend : function() {
                webBlock2("Please Wait...");
            },
            success : function(response) {
                $.unblockUI();
            }

        });
    }
</script>
</body>
</html>
