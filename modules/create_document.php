<?php
    include 'session.php';
    include '../includes/header.php';
?>
<style>
    div.t { display: table; margin: 4px; padding: 1px; }
    div.t {
    display: table-cell;
    width: 100%;
}
div.t > input {
    width: 100%;
    margin: 1px;
}
</style>
<body class="vertical-layout vertical-menu 2-columns  fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

<?php
    include '../includes/topbar.php';
    include '../includes/sidebar.php';
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
            <section id="sec_create_document">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">CREATE DOCUMENT</h4>
                                </div>
                                <div class="card-content ">
                                    <div class="card-body card-dashboard">
                                    <form id="frm_doccreate" class="form form-horizontal frm_doccreate" method="post" action="../actions/act_create_document.php" enctype="multipart/form-data" autocomplete="off">
                        <div class="form-body">
                            <input type="hidden" name="create_doc" id="create_doc">
                    
                                    <div class="form-group row"> <!-- KUNG ANONG DEPARTMENT NITONG NAKALOGIN -->
                                        <label class="col-md-3 label-control" for="text_1">Department</label>
                                        <div class="col-md-9 mx-auto">
                                            <label id="text_1"><?php echo $userdeptname?></label>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <!-- SYSTEM GENERATED -->
                                        <label class="col-md-3 label-control" for="text_2">Barcode</label>
                                        <div class="col-md-9 mx-auto">
                                            <input type="text" class="form-control capitalizefletter" name="text_2" id="text_2" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="form-group row"> <!-- MGA AVAILABLE NA DOCUMENT BASE ON DEPARTMENT NG NAKALOGIN -->
                                        <label class="col-md-3 label-control" for="text_3">Document Type</label>
                                        <div class="col-md-9 mx-auto">
                                            <select class="form-control sel_doctype select2" id="text_3" name="text_3">
                                                <option value="" selected>- Select -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row custom-doctype hidden"> <!-- KAPAG WLA SO DOCTYPE -->
                                        <label class="col-md-3 label-control" for="text3_0"></label>
                                        <div class="col-md-9 mx-auto">
                                            <input type="text" class="form-control capitalizefletter" name="text3_0" id="text3_0" placeholder="Enter Doctype">
                                        </div>
                                    </div>


                                    <div class="form-group row"> <!-- RANDOM STRING -->
                                        <label class="col-md-3 label-control" for="text_4">Document Title</label>
                                        <div class="col-md-9 mx-auto">
                                            <input type="text" class="form-control textCapitalall" name="text_4" id="text_4">
                                        </div>
                                    </div>
                                    <div class="form-group row"> <!-- KUNG SINO ANG MGA TAONG NASA DEPARTMENT NA KAPAREHAS NG NAKALOGIN -->
                                        <label class="col-md-3 label-control" for="text_6">Process By</label>
                                        <div class="col-md-9 mx-auto">
                                            <input type="text" class="form-control" name="text_6" id="text_6" value ="<?php echo $userempname  ?>" readonly>
                                            <!-- <select class="form-control sel_processby select2" id="text_6" name="text_6">
                                                <option value="" selected>- Select -</option>
                                            </select> -->
                                        </div>
                                    </div>
                                    <div class="form-group row custom-processby hidden"> <!-- KAPAG WLA SO PROCESS BY -->
                                        <label class="col-md-3 label-control" for="text6_0"></label>
                                        <div class="col-md-9 mx-auto">
                                            <input type="text" class="form-control textCapitalall" name="text6_0" id="text6_0" placeholder="Enter Process By.">
                                        </div>
                                    </div>

                                    <div class="form-group row" id="attachehiddenonreturn"> <!-- KUNG SINO ANG MGA TAONG NASA DEPARTMENT NA KAPAREHAS NG NAKALOGIN -->
                                        <label class="col-md-3 label-control" for="text_8">Attached File</label>
                                        <div class="col-md-9 mx-auto">
                                            <input class="form-control" type="file" name="text_8[]" id="text_8"  onchange="javascript:updateList()" multiple>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control"></label>
                                        <div class="col-md-9 mx-auto">
                                            <div id="fileList"></div>
                                        </div>
                                    </div>
                                    <textarea class="hidden" name="text_8text" id="text_8text" cols="30" rows="10"></textarea>
                                    <div class="form-group row"> <!-- KUNG SINO ANG MGA TAONG NASA DEPARTMENT NA KAPAREHAS NG NAKALOGIN -->
                                        <label class="col-md-3 label-control" for="text_9">Brief Description</label>
                                        <div class="col-md-9 mx-auto">
                                            <textarea class="form-control textCapitalall" name="text_9" id="text_9" cols="30" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="show_on_returndoc hidden">
                                        <div class="form-group row">
                                            <div class="col-md-12 mx-auto">
                                                <button type="button" id="btn_editsignatories" class="btn btn-danger">Edit Signatories</button>
                                            </div>
                                            <hr>
                                        </div> 
                                    </div>
                                    <div id="hide_on_returndoc" class="hidden">
                                        <div class="form-group row">
                                            <div class="col-md-9 mx-auto">
                                                <select class="form-control sel_department select2-custom" id="text_7" name="text_7">
                                                    <option value="" selected>- Select -</option>
                                                </select>
                                            </div>
                                            <div>
                                                <button class="btn btn-success btn-actions mr-4" type="button" id="btnadddept" name="btnadddept" data-action="receiving_dept"><i class="las la-plus"></i> Add Signatories</button>
                                            </div>
                                            <hr>
                                        </div> 
                                    </div>
                                    <table id="tbl_tmp" class="table table-hover table-bordered table-striped tbl_tmp"  style="width:100%">
                                        <thead class="cdtheadcolor">
                                            <tr>
                                                <th>ID</th>
                                                <th>Department</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                               
                                    <div class="form-group row">  <!-- KUNG ANONG DEPARTMENT ANG HULING MAG SA SIGN -->
                                        <label class="col-md-3 label-control" for="text_5">Final Approving Authority</label>
                                        <div class="col-md-9 mx-auto">
                                            <label class="text-danger" id="label_finalapproving"></label>
                                            <input type="hidden" name="text_5" id="text_5">
                                            <!-- <select class="form-control sel_department select2-custom" id="text_5" name="text_5">
                                                <option value="" selected>- Select -</option>
                                            </select> -->
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="show_on_returndoc hidden">
                                        <div class="form-group row">
                                            <div class="col-md-12 mx-auto">
                                                <button type="button" id="btn_editattachments" class="btn btn-danger">Download Attachments</button> <button type='button' id="btnreuploadfile" class='btn btn-primary hidden'>Reupload</button> <br> &nbsp; <br> <input class="form-control hidden" type="file" name="text_10[]" id="text_10" multiple>
                                            </div>
                                            <hr>
                                        </div> 
                                    </div>


                        </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-danger" id="cancelreturn">Cancel</button>
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-outline-primary" value="Submit">
            </div>
            </form>
                                        <!-- <div class="table-responsive">
                                            <table id="tbl_main" class="table table-hover table-bordered table-striped tbl_main" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Received ID</th>
                                                        <th>Barcode</th>
                                                        <th>Document Type</th>
                                                        <th>Document Title</th>
                                                        <th>From</th>
                                                        <th>To</th>
                                                        <th>Duration</th>
                                                        <th>Date Created</th>
                                                        <th>Date Received</th>
                                                        <th>Due</th>
                                                        <th>Received By</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div> -->
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
                var  n_lgn = "<?php echo $usedeptcode; ?>";

        </script>
<script>
         


$(function() {
    // window.open(`print_project_proposal.php?barcode=OCOOWLT20221603483913`,"popupWindow", "width=200,height=200,scrollbars=yes");  
    
    pageLocation("li_transaction", "li_transact_createdoc", "Create Document");
    $("#hide_on_returndoc").removeClass("hidden");
    $("#mdl1title").text("Create Document");
    $("#cancelreturn").remove();
    

    getDataSelect2("sel_doctype","Select Document Type","select_doctype");
    getDataSelect2("sel_department","Select Department","select_department");
    getDataSelect2("sel_processby","Select Process By","select_processby");

    varuniid = makeUngiquid(n_lgn,"");

    $("#text_2").val(varuniid);
    reloadTmp(0);
    cleartmp(varuniid);
    var pendingDocs = "";


    updateList = function() {
        var input = document.getElementById('text_8');
        var output = document.getElementById('fileList');
        var children = "";
        for (var i = 0; i < input.files.length; ++i) {
            children += '<li>' + input.files.item(i).name + '</li>';
        }
        output.innerHTML = '<ul>'+children+'</ul>';
    }



    $(document).on('click', '.btn-actions', function(e){
        e.preventDefault();
        let action = $(this).data('action');

        if(action == 'add') {
            $("#mdl_create").modal("show");
        }else if(action =='receiving_dept') {

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
        }else if (action =='delete_tmp') {
            var remove_tmp_receivingdept = "";
            var id = $(this).data('id');
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
                    responseTosubmit2(response[0],  response[1], response[2]);
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
        }else if(action =="print") {
            var barcode = $(this).data("barcode");
            window.open(`pr/${barcode}.pdf`,"popupWindow", "width=900,height=900,scrollbars=yes");
            $("#mdl_print").modal("hide");
        }
    });

    // $("#tbl_main").DataTable( {

    //     "destroy" :     true,
    //     'ajax': {
    //         'url'       :  "../actions/act_create_document.php",
    //         'method'    :  "POST",
    //         'dataType'  : "JSON",
    //         'data'      :  {
    //                     pendingDocs
    //                 },
                    
    //     },
    //     "initComplete":function( settings, json){
    //         closePageLoader();
    //     },
    //     'columns': [
    //         { data: 'row1', visible: false},
    //         { data: 'row2'  },
    //         { data: 'row3'  },
    //         { data: 'row4'  },
    //         { data: 'row5'  },
    //         { data: 'row6'  },
    //         { data: 'row7'  },
    //         { data: 'row8'  },
    //         { data: 'row9'  },
    //         { data: 'row10'  },
    //         { data: 'row11'  },
    //         { data: 'row12'  },

    //     ],
    //     'order'  :   [[ 0, 'desc']],
    // });

    $(document).on("change","#text_3",function(e){
        e.preventDefault();
        var selval = $(this).val(); 


        if(selval == "OTHERS") {
            $(".custom-doctype").removeClass("hidden");
            $("#text3_0").css("border-color", "red");
        }else{
            $("#text3_0").val("");
            $(".custom-doctype").addClass("hidden");
            var text = $(this).find(":selected").text();
            var matches = text.match(/\b(\w)/g);
            var acronym = "";
            if(text !="") {
    
                var acronym =  matches.join('');
                $("#text_2").val(makeUngiquid(n_lgn,acronym));
            }else{
    
                var acronym =  "";
                $("#text_2").val(makeUngiquid(n_lgn,acronym));
            }
        }

        var newBcode =  $("#text_2").val();
        doctypeOnchange(newBcode);
    })


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


    $("#text3_0").blur(function(){
        var x = $(this).val();
        var matches = x.match(/\b(\w)/g);
        var acronym =  matches.join('');
        
        $("#text_2").val(makeUngiquid(n_lgn,acronym));

        var newBcode =  $("#text_2").val();
        doctypeOnchange(newBcode);
    });



    closePageLoader();


    $('#mdl_print').on('hidden.bs.modal', function () {
        window.location.reload();
    })


});

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
                    },
                    
        },
        'columns': [
            { data: 'row1', visible : false },
            { data: 'row2' },
            { data: 'row3' }
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

let doctypeOnchange = (newbarcode) => {
    var chg_tmp_tbl_bcode = "";

    $.ajax({
        url     : "../actions/act_create_document.php",
        method  : "post",
        dataType: "JSON",
        data    : {
            chg_tmp_tbl_bcode, newbarcode
        },
        beforeSend : function (){
            webBlock2("Please Wait...");
        },
        success : function (response) {

            if(response[0] == "error") {
                responseTosubmit(response[0],response[1], response[2], "no_form", "tbl_tmp", "no_modal");
            }else{
                $.unblockUI();
            }
        }
    });


} 

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

                $.ajax({
                    url         :   form.action,
                    type        :   form.method,
                    data        :   formData,
                    cache       :   false,
                    contentType :   false,
                    processData :   false,
                    dataType    :   "json",
                    beforeSend: function(){ 
                        webBlock2("Generating Please Dont Close Any Pop-up.");
                    },
                success: function(response) {
                    
                        if(response[0] =='success') {
                            var win = window.open(`print_project_proposal.php?barcode=${response[3]}`, "thePopUp", "width=200,height=200");
                            win.document.title = 'Generating ... Please Dont Close';
                            var pollTimer = window.setInterval(function() {
                                if (win.closed !== false) { // !== is required for compatibility with Opera
                                    window.clearInterval(pollTimer);
                                    $("#mdl_print").modal("show");
                                    responseTosubmit(response[0], response[1], response[2], "frm_doccreate", "tbl_main", "mdl_create");
                                }
                            }, 200);

                            $("#text_2").val(makeUngiquid(n_lgn,""));
                            reloadTmp(response[3]);
                            $("#text_5").val("");
                            $("#label_finalapproving").text("");
                            
                            $("#btn-print").data('barcode',response[3]);
                         
                        }else{
                            responseTosubmit(response[0], response[1], response[2], "frm_doccreate", "tbl_main", "mdl_create");

                        }
                    }            
                });


        }
    });




        </script>

    
</body>
</html>
