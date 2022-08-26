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
<!-- RECEIVED -->
<div class="modal fade text-left mdl1" id="mdl1" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INPUT BARCODE</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="frm1" class="form form-horizontal frm1" method="post" action="../actions/act_recieve_transfer.php" autocomplete="off">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="text_1"><label class="text-danger">*</label> Barcode</label>
                                <div class="col-md-9 mx-auto">
                                    <input type="text" id="text_1" name="text_1" class="form-control" placeholder="Barcode">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="text_2"><label class="text-danger">*</label>Received By</label>
                                <div class="col-md-9 mx-auto">
                                    <input type="text" id="text_2" name="text_2" class="form-control textCapitalall" placeholder="Received By">
                                </div>
                            </div>
                            <input type="hidden" id="text_3" name="text_3">
                        </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-danger" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-success" value="Receive">
            </div>
            </form>
        </div>
    </div>
</div>
<!-- TRANSFER / APPROVED -->
<div class="modal fade text-left mdl2" id="mdl2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Transfer</h4>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <form class="form form-horizontal" id="formdownloadform" action="recieve_transfer_download.php" method="post">
                        <div class="form-group row">
                            <label class="col-md-3 label-control"></label>
                            <div class="col-md-9 mx-auto">
                                <input class="btn btn-warning" type="submit" onclick="vwreupbtn()";  value="Download Attachments">
                            </div> 
                        </div>
                    </form>
                    <form id="frm2" class="form form-horizontal frm2" method="post" action="../actions/act_recieve_transfer.php" autocomplete="off">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="text_2_1"></label>
                                <div class="col-md-9 mx-auto">

        

                                    <!-- <h4 class="cls-dlattachment font-weight-bold" id="cls-dlattachment">Download Attachment</h4> -->
                               </div>
                            </div>
                            <div class="alert alert-success hidden" id="success-alert">
                                <strong>Success!</strong> <h6>File Save At:</h6>
                                <h6 id="success_message"></h6>
                            </div>
                                  
                            <div class="form-group row div_reuplaodfile hidden"> <!-- KUNG SINO ANG MGA TAONG NASA DEPARTMENT NA KAPAREHAS NG NAKALOGIN -->
                                <label class="col-md-3 label-control" for="text_2_2">Attached File</label>
                                <div class="col-md-9 mx-auto">
                                    <input class="form-control" type="file" name="text_2_2[]" id="text_2_2" multiple>
                                </div>
                            </div>
                            <div class="form-group row" id="div_keepby">
                                <label class="col-md-3 label-control" for="text_2_3"><label class="text-danger">*</label> Keep By</label>
                                <div class="col-md-9 mx-auto">
                                    <select name="text_2_3" id="text_2_3" class="sel_processby">
                                        <option value="">Select</option>
                                    </select>
                                    <!-- <input type="text" id="text_2_3" name="text_2_3" class="form-control" placeholder="Keep By"> -->
                                </div>
                            </div>
                            <div class="form-group row custom-keptby hidden"> <!-- KAPAG WLA KEEP BY -->
                                <label class="col-md-3 label-control" for="text_2_30"></label>
                                <div class="col-md-9 mx-auto">
                                    <input type="text" class="form-control textCapitalall" name="text_2_30" id="text_2_30" placeholder="Enter Kept By.">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="text_2_4">Remarks</label>
                                <div class="col-md-9 mx-auto">
                                    <input type="text" id="text_2_4" name="text_2_4" class="form-control textCapitalall" placeholder="Remarks">
                                </div>
                            </div>
                            <input type="hidden" id="text_2_5" name="text_2_5">

                        </div>
                </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Approve</button> -->
                <button type="button" class="btn btn-danger" id="btn-returnCreator">Return to Creator</button>
                <button type="button" class="btn btn-info btn-reupload hidden">Re-Upload</button>
                <input type="submit" id="btn-trans_appr" class="btn btn-success" value="">
            </div>
            </form>
        </div>
    </div>
</div>
<!-- RETURN TO CREATOR -->
<div class="modal fade text-left mdl3" id="mdl3" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Return To Creator</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="frm3" class="form form-horizontal frm3" method="post" action="../actions/act_recieve_transfer.php"  enctype="multipart/form-data" autocomplete="off" >
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="text_3_1"><label class="text-danger">*</label> Remarks</label>
                                <div class="col-md-9 mx-auto">
                                    <textarea class="form-control textCapitalall" name="text_3_1" id="text_3_1" cols="30" rows="10" placeholder="Remarks"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 label-control" for="text_4_1"><label class="text-danger">*</label> User</label>
                                <div class="col-md-9 mx-auto">
                                    <input type="text" class="form-control textCapitalall" name="text_4_1" id="text_4_1">
                                </div>
                            </div>



                            <div class="form-group row div_reuplaodfile hidden"> <!-- KUNG SINO ANG MGA TAONG NASA DEPARTMENT NA KAPAREHAS NG NAKALOGIN -->
                                <label class="col-md-3 label-control" for="text_3_2">Attached File</label>
                                <div class="col-md-9 mx-auto">
                                    <input class="form-control" type="file" name="text_3_2[]" id="text_3_2" multiple>
                                </div>
                            </div>

                        </div>
                </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Approve</button> -->
                <button type="button" class="btn btn-danger" id="btn-returncancelCreator">Cancel</button>
                <button type="button" class="btn btn-info btn-reupload hidden">Re-Upload</button>
                <input type="submit" id="btn-subreturncreator" class="btn btn-success" value="Return To Creator">
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
                    <h3 class="content-header-title">Receive / Transfer </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Transactions   
                                </li>
                                <li class="breadcrumb-item active">Receive / Transfer  
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">

                </div>
            </div>
            <div class="content-body">
                <input type="hidden" name="depval" id="depval" value="<?php echo $userdeptname; ?>">
            <section id="sec_create_document">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"> </h4>
                                </div>
                                <div class="card-content ">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="tbl1" class="table table-hover table-bordered table-striped tbl1" style="width:100%">
                                                <thead class="cdtheadcolor">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>BARCODE</th>
                                                        <th>Document Type</th>
                                                        <th>Document Title</th>
                                                        <th>From</th>
                                                        <th>To</th>
                                                        <th>Due</th>
                                                        <th>Status</th>
                                                        <th>Received By</th>
                                                        <th>LASTID</th>
                                                        <th>LASTID</th>
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
        <?php include '../includes/footer.php';?>
        <script>
        

            $(function() {


                $("#success-alert").hide();
              
                pageLocation("li_transaction", "li_transact_recieved_trans", "Received / Transfer");
                var tbl_1 = "";
                var depcode = $("#depval").val();
                var att_barcode = "";
                var swalval = "";
                var rec_barcode_validate = "";


                // const myInput = document.getElementById('text_1');
                // myInput.onpaste = e => e.preventDefault();

                var delay = (function(){
                var timer = 0;
                return function(callback, ms){
                    clearTimeout (timer);
                    timer = setTimeout(callback, ms);
                };
                })();

                $("#text_1").on("input", function() {
                delay(function(){
                    if ($("#text_1").val().length < 10) {
                        $("#text_1").val("");
                    }else{
                        $("#text_2").focus();
                    }
                }, 20 );
                });


                /* =================== CLICK ====================  */
                $("#btn-returnCreator").click(function(e) {
                    e.preventDefault();

                    var remarksOnTrans = $("#text_2_4").val();
                    $("#text_3_1").val(remarksOnTrans);


                    $("#mdl3").modal("show");
                    $("#mdl2").modal("hide");
                });
                $("#btn-returncancelCreator").click(function(e) {
                    e.preventDefault();
                    $("#mdl3").modal("hide");
                    $("#mdl2").modal("show");
                });


                $(document).on("change","#text_2_3",function(e){
                    e.preventDefault();
                    var selval3 = $(this).val(); 


                    if(selval3 == "OTHERS") {
                        $(".custom-keptby").removeClass("hidden");
                        $("#text_2_30").css("border-color", "red");

                    }else{
                        $("#text_2_30").val("");
                        $(".custom-keptby").addClass("hidden");
                    
                    }
                })


                $( ".btn-reupload" ).click(function() {
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
                                        $(".btn-reupload").remove();
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

                // $(".cls-dlattachment").click(function showAlert() {
                //     var downloadattach = "";
                //     // shell = new ActiveXObject("WScript.Shell");
                //     // pathToMyDocuments = shell.SpecialFolders('MyDocuments');
                //     $.ajax({
                //         url         : "../actions/act_recieve_transfer.php",
                //         method      : "post",
                //         // dataType    : "json",
                //         data        : {
                //             downloadattach , att_barcode
                //         },
                //         // beforeSend : function(){
                //         //     webBlock2("Downloading File ...");
                //         // },
                //         success : function(response) {
                //             alert(response);
                //             // $.unblockUI();
                //             // if(response[0] != "success") {
                //             //     responseTosubmit2(response[0], response[1], response[2]);
                //             // }else{
                //             //     $("#btn-reupload").removeClass("hidden");
                //             //     $("#success_message").text(response[2]);
                //             //     $("#success-alert").fadeTo(10000, 500).slideUp(500, function() {
                //             //     $("#success-alert").slideUp(500); });
                //             // }
                //         }

                //     });
               
                // });
                /* ====================TABLE =================== */
                var table = $('#tbl1').DataTable( {
                    'ajax': {
                        'method' : 'POST',
                        'url'    :'../actions/act_recieve_transfer.php',
                        'data'   : {
                             tbl_1
                        },
                    },
                    "initComplete":function( settings, json){
                        closePageLoader();
                    },
                    'columns': [
                        { data: 'row1', visible : false },
                        { data: 'row2' },
                        { data: 'row3' },
                        { data: 'row4' },
                        { data: 'row5' },
                        { data: 'row6' },
                        { data: 'row7' },
                        { data: 'row8' },
                        { data: 'row9' },
                        { data: 'row10' , visible : false},
                        { data: 'row11' , visible : false},
                        {
                            "className":      'options',
                            "render": function(data, type, full, meta){
                            
                                if(full.row8 == "PENDING") {
                        

                                    if(full.row11 == depcode && full.row6 !== "") {
                                        return "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button>";
                                    // }else if(full.row11 == depcode && full.row6 == "") {
                                    //     return  "<button class='btn btn-primary'><i class='las la-print'></i></button> <button class='btn btn-danger'><i class='las la-share'></i></button> <button class='btn btn-success'><i class='las la-thumbs-up'></i></button>";

                                    }else if(full.row11 == depcode) {
                                        return  "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button> <button class='btn btn-danger btn-transfer' title='TRANSFER'><i class='las la-share'></i></button>";
                                    }else if(full.row6 == depcode) {
                                        return  "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button> <button class='btn btn-success btn-received' title='RECEIVED'><i class='las la-thumbs-up'></i></button>";
                                    }else if(full.row6 != depcode) {
                                        return  "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button>";
                                    }
                                    
                                }else if (full.row8 == "RECEIVED") {

                      
                                    if(depcode == full.row11 && full.row1 == full.row10 &&  full.row6 == depcode)  {
                                        return  "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button> <button class='btn btn-danger btn-transfer' title='TRANSFER'><i class='las la-share'></i></button> <button class='btn btn-success btn-received' title='RECEIVED'><i class='las la-thumbs-up'></i></button>";
                                    }else if(depcode == full.row11 && full.row1 != full.row10 )  {
                                        return "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button>";
                                    }else if(depcode != full.row11 && full.row1 != full.row10 )  {
                                        return "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button>";
                                    }else if(depcode != full.row11 && full.row1 == full.row10 && full.row6 == depcode )  {
                                        return  "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button> <button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button>";
                                    }else if(depcode != full.row11 && full.row6 == depcode && full.row6 != depcode )  {
                                        return "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button>";
                                    }

                                }else if (full.row8 == "Approved") {
                                    return "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button>";
                                }else if (full.row8 == "FORWARDED") {
                                    if(full.row6 == depcode && full.row1 == full.row10 ) {
                                        return  "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button> <button class='btn btn-success btn-received' title='RECEIVED'><i class='las la-thumbs-up'></i></button>";
                                    }else{
                                        return "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button>";
                                    }

                                }else if (full.row8 == "RETURN") {

                                    if(full.row6 == depcode) {
                                        return  "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button> <button class='btn btn-success btn-received' title='RECEIVED'><i class='las la-thumbs-up'></i></button>";
                                    }else{
                                        return "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button>";
                                    }                                    
                                }else{
                                    return "<button class='btn btn-primary btn-print' title='PRINT'><i class='las la-print'></i></button>";
                                }
                            }
                        }
                    ],
                    "order": [[ 0, "desc" ]]
                });
                $('#tbl1 tbody').on( 'click', '.btn-received', function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    $("#text_3").val(data['row8']);
                    rec_barcode_validate = data['row2'];
                    $("#mdl1").modal("show");
                    setTimeout(function() { $('input[name="text_1"]').focus() } , 500);
            
                    // $("#text_1").focus();
                } );
                $('#tbl1 tbody').on( 'click', '.btn-print', function () {
                    var data = table.row( $(this).parents('tr') ).data();
                
                    $.ajax({
                        url:`../img/barcodes/${data['row2']}/${data['row2']}.pdf`,
                            type:'HEAD',
                            error: function()
                            {
                                window.open(`pr/${data['row2']}.pdf`,"popupWindow", "width=600,height=600,scrollbars=yes");
                 
                            },
                            success: function()
                            {
                                window.open(`../img/barcodes/${data['row2']}/${data['row2']}.pdf`,"popupWindow", "width=600,height=600,scrollbars=yes");
                        
                            }
                    });

                    // window.open(`../img/barcodes/${data['row2']}/${data['row2']}.pdf`,"popupWindow", "width=600,height=600,scrollbars=yes");
              
                } );
                $('#tbl1 tbody').on( 'click', '.btn-transfer', function () {
                    var rec_status = "";
                    var data = table.row( $(this).parents('tr') ).data();
                    $("#formdownloadform").attr('action', `recieve_transfer_download.php?barcode=${data['row2']}`);
                    $(".btn-reupload").addClass("hidden");
                    att_barcode = data['row2'];
                    $.ajax({
                        url         : "../actions/act_recieve_transfer.php",
                        method      : "post",
                        dataType    : "json",
                        data        : {
                            rec_status, att_barcode
                        },
                        beforeSend: function() {
                            webBlock("Please Wait");
                        },
                        success : function(response) {
  
                            $.unblockUI();
                            $("#mdl2").modal("show");
                            if(response[2] == "NOT YET TURN") {
                                swalval = "Transfer";
                                $("#text_2_5").val("transfer");
                                $("#div_keepby").hide();
                                $("#btn-trans_appr").val("Transfer");
                            }else if(response[2] == "TURN") {
                                swalval = "Approved";
                                $("#text_2_5").val("approved");
                                $("#div_keepby").show();
                                $("#btn-trans_appr").val("Approved");
                            }
                        }
                    });
              
                } );
                /* ====================VALIDATION======================= */
                $("form#frm1").validate({
                    rules: {
                        text_1: {
                            required : true,
                            // remote: {
                            //     url     : '../actions/check_barcodeExist.php',
                            //     type    : "POST"
                            // }
                        },
                        text_2: {
                            required : true
                        },
                    },
                    messages: {
                        text_1: {
                            required    : "Barcode Is Required",
                            // remote      : "Invalid Barcode"
                        },
                        text_2: {
                            required    : "Received by is Required"
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

                        var barcode_valid = $("#text_1").val();
                        if (rec_barcode_validate != barcode_valid) {
                            responseTosubmit2("error", "Error Found", "Invalid Barcode"); 
                        }else{
                            var formData    = new FormData(form);
                            formData.append('transaction', "");
                            $.ajax({
                                url         :   form.action,
                                type        :   form.method,
                                data        :   formData,
                                cache       :   false,
                                contentType :   false,
                                processData :   false,
                                dataType    :   "json",
                                beforeSend: function(){ 
                                    webBlock2("Submitting...");
                                },
                                success: function(response) {
                            
                                    responseTosubmit(response[0], response[1], response[2], "frm1", "tbl1", "mdl1");
                                
                                }            
                            });
                        }
        
                        
                    }
                });

                $("form#frm2").validate({
                    rules: {
                        // text_2_3: {
                        //     required : true
                        // },
                    },
                    messages: {
                        // text_2_3: {
                        //     required    : "Keep By is Required",
                        // },
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
                            title: `Are you sure you want to ${swalval} this document?`,
                            text: "You won't be able to revert this!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: `Yes, ${swalval} it!`
                        }).then((result) => {
                            if (result.value) {
                                var formData    = new FormData(form);
                                formData.append('transaction_approved', "");
                                formData.append('barcode', att_barcode);
                                
                                $.ajax({
                                    url         :   form.action,
                                    type        :   form.method,
                                    data        :   formData,
                                    cache       :   false,
                                    contentType :   false,
                                    processData :   false,
                                    dataType    :   "json",
                                    beforeSend: function(){ 
                                        webBlock2("Submitting...");
                                    },
                                    success: function(response) {
                                
                                        responseTosubmit(response[0], response[1], response[2], "frm2", "tbl1", "mdl2");
                                    
                                    }            
                                });
                            }
                        })


                      
                    }
                });


                $("form#frm3").validate({
                    rules: {
                        text_3_1: {
                            required : true
                        },
                        text_4_1: {
                            required : true
                        }

                        
                    },
                    messages: {
                        text_3_1: {
                            required    : "Remarks is Required",
                        },
                        text_4_1: {
                            required    : "User is Required",
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
                        formData.append('returncreator', "");
                        formData.append('barcode', att_barcode);
                        
                        $.ajax({
                            url         :   form.action,
                            type        :   form.method,
                            data        :   formData,
                            cache       :   false,
                            contentType :   false,
                            processData :   false,
                            dataType    :   "json",
                            beforeSend: function(){ 
                                webBlock2("Submitting...");
                            },
                            success: function(response) {
                                responseTosubmit(response[0], response[1], response[2], "frm3", "tbl1", "mdl3");
                            
                            }            
                        });
                    }
                });

                /* ===================SELECT2 ===============" */

                getDataSelect2("sel_processby","Select Process By","select_processby");


            }); /* END */

            let vwreupbtn = () => {
                $(".btn-reupload").removeClass("hidden");
            }

        </script>
</body>
</html>
