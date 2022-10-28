<?php
    include 'session.php';

    $conn = $pdo->open();
    
    // if($userrole != "SUPERADMIN") {
    //     header("Location: error404"); 
    // }else{

        $session_barcode = $_GET['activity'];


        $stmt = $conn->prepare("SELECT row1 FROM vw_search_order_of_business WHERE row3 = :row3"); 
        $stmt->execute(['row3'=>$session_barcode]);
        $countstmt = $stmt->rowCount();

        if($countstmt == 0) {

            header("Location: error404"); 
        }
        // else {
        //     $ftcstmt = $stmt->fetch();

        //     if ($ftcstmt['created_by'] != $userid) {

        //         $stmt2 = $conn->prepare("SELECT id FROM search_committees WHERE barcode = :barcode AND userid = :userid");
        //         $stmt2->execute(['barcode'=>$session_barcode , 'userid'=>$userid ]);
        //         $countstmt2 = $stmt2->rowCount();

        //         if($countstmt2 == 0) {
        //             header("Location: error404"); 
        //         }


        //     }else {

        //         if( $ftcstmt['isAvailable'] == 0 ){ 
        //             header("Location: error404"); 
        //         }
        //     }

        // }

        $pdo->close();
    // }




    include '../includes/header.php';



?>

<!-- <style>
.inputfile {
	width: 0.1px;
	height: 0.1px;
	opacity: 0;
	overflow: hidden;
	position: absolute;
	z-index: -1;
}
.inputfile + label {
    font-size: 1.25em;
    font-weight: 700;
    color: black;
    background-color: white;
    display: inline-block;
}

.inputfile:focus + label,
/* .inputfile + label:hover {
    background-color: red;
} */
.inputfile + label {
	cursor: pointer; /* "hand" cursor */
}
.inputfile:focus + label {
	outline: 1px dotted #BF360C;
	outline: -webkit-focus-ring-color auto 5px;
}
</style> -->
<body class="vertical-layout vertical-menu 2-columns  fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">


<?php
    include '../includes/topbar.php';
    include '../includes/sidebar.php'
?>

<div class="modal fade text-left mdl_main" id="mdl_main" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Files</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <div id="div_original_file"></div>
                        <!-- <table id="tbl_main2" class="table table-hover table-bordered table-striped tbl_main2" style="width:100%">
                            <thead class="cdtheadcolor">
                                <tr>
                                    <th>Document Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table> -->
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary btn-actions" data-actions='uploadfILE'>Upload</button>
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
                                <li class="breadcrumb-item active">Activity <?php echo $session_barcode; ?>
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
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <?php 
                                                        $stmt3 = $conn->prepare("SELECT * FROM vw_search_order_of_business WHERE row3 = :row3");
                                                        $stmt3->execute(['row3'=>$session_barcode]);
                                                        $countstmt3 = $stmt3->rowCount();

                                                        if($countstmt3 == 0) {

                                                            echo "There's a problem found please contact support.";

                                                        }else {
                                                            $ftcstmt3 = $stmt3->fetch();
                                                                $order_of_business_date = $ftcstmt3['row2'];
                                                                $order_of_business_code = $ftcstmt3['row3'];
                                                                $order_of_business_cby = $ftcstmt3['row4'];
                                                                // $r_creator_name = ( $ftcstmt3['created_by'] == $userid ) ? "You" : $ftcstmt3['creator'];
                                                                // $r_date_created = $ftcstmt3['date_created'];
                                                                // $r_status       =  ($ftcstmt3['isAvailable'] == 1) ? "Session On Going <image src='../img/web/circle_green.png' width='10px'>" : "Session Done <image src='../img/web/circle_red.png' width='10px'>";

                                                            echo    "
                                                    
                                                                    <table class='table table-bordered'>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Barcode</td>
                                                                                <td>$order_of_business_code</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Order of Business Date</td>
                                                                                <td>$order_of_business_date</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Created By</td>
                                                                                <td>$order_of_business_cby</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>View</td>
                                                                                <td><a href='s_download_as_zip.php?orderofbusinesscode=$session_barcode'>Download as zip</a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>";
                                                                }
                                                       
                                                        $pdo->close();

                                                    ?>

                                            
                                                        <!-- $stmt4 = $conn->prepare("SELECT *,  func_Dateformat(uploadDateTime, 3) as uploaddate  FROM `tblupload` WHERE uploadFileName = :uploedFileName");
                                                        $stmt4->execute(['uploedFileName'=>$session_barcode.".pdf"]);
                                                        $countstmt4 = $stmt4->rowCount();

                                                        if($countstmt4 == 0) {

                                                            echo "There's a problem found please contact support.";

                                                        }else {
                                                            $ftcstmt4 = $stmt4->fetch();

                                                                $r_filesize = strlen($ftcstmt4['uploadFile']) ." KB";
                                                                $r_uploaddate = $ftcstmt4['uploaddate'];
                                                                // $r_status       =  ($ftcstmt3['isAvailable'] == 1) ? "Session On Going <image src='../img/web/circle_green.png' width='10px'>" : "Session Done <image src='../img/web/circle_red.png' width='10px'>";

                                                            echo    "
                                                                    <label class='text-primary font-weight-bold'>File Details</label>
                                                                    <table class='table table-bordered'>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>File Size</td>
                                                                                <td>$r_filesize</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Type</td>
                                                                                <td>Application/PDF</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Date Uploaded</td>
                                                                                <td>$r_uploaddate</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>";
                                                                }
                                                       
                                                        $pdo->close(); -->

                                     


                                                </div>
                                                <div class="col-md-8">
                                                        


                                                    <?php

                                            function convtoLetter($str) {
                                                $alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
                                                $newName = '';
                                                do {
                                                    $str--;
                                                    $limit = floor($str / 26);
                                                    $reminder = $str % 26;
                                                    $newName = $alpha[$reminder].$newName;
                                                    $str=$limit;
                                                } while ($str >0);
                                                    return $newName;
                                                }
                                                        function showDescriptions($orderofbusinessname ,$orderofbusinesscode, $conn) {

                                                            $output = "";
                                                            $stmtshowDesc = $conn->prepare("SELECT description as orderofbusinessdesc, barcode , order_of_business_code
                                                                                            FROM search_order_of_business
                                                                                            WHERE order_of_business_id = :order_of_business_id
                                                                                            AND order_of_business_code = :order_of_business_code");

                                                            $stmtshowDesc->execute(['order_of_business_id'=>$orderofbusinessname, 'order_of_business_code'=>$orderofbusinesscode]);

                                                            $countstmtshowDesc = $stmtshowDesc->rowCount();
                                                            
                                                            if($countstmtshowDesc == 0) {
                                                                $output .= "No Details Found";
                                                            }else{
                                                                while ($row2 = $stmtshowDesc->fetchObject()) {
                                                                    $output .= $row2->orderofbusinessdesc."<a href='#' class='cls-vw-files' data-barcode='$row2->barcode' data-businesscode='$row2->order_of_business_code'> Click to View Files.</a><hr>";
                                                                }   
                                                            }

                                                            return $output;
                                                        }



                                                        // $output = "";
                                                        try {
                                                       
                                                            $stmtshowDesc = $conn->prepare("SELECT DISTINCT(order_of_business_id) as orderofbusinamename ,
                                                                                            REPLACE(order_of_business_id,' ', '') as orderofbusi
                                                                                            FROM `search_order_of_business` 
                                                                                            WHERE order_of_business_code = :order_of_business_code");
                                                            $stmtshowDesc->execute(['order_of_business_code'=>$session_barcode]);
                                                            
                                                            $countstmtshowDesc = $stmtshowDesc->rowCount();

                                                            if($countstmtshowDesc == 0) {

                                                                echo "No Details Found";


                                                            }else {
                                                                $x = 'Z';
                                                                while ($row = $stmtshowDesc->fetchObject()) {
                                                                    $x++;
                                                                    echo "
                                                                        <div id='accordion31' role='tablist' aria-multiselectable='true'>
                                                                            <div class='card accordion collapse-icon accordion-icon-rotate'>
                                                                                <a id='heading31' class='card-header bg-info success collapsed' data-toggle='collapse' href='#$row->orderofbusi' aria-expanded='false' aria-controls='$row->orderofbusi'>
                                                                                    <div class='card-title lead white'>".substr($x, 1).". $row->orderofbusinamename</div>
                                                                                </a>
                                                                                <div id='$row->orderofbusi' role='tabpanel' data-parent='#accordion31' aria-labelledby='heading31' class='card-collapse collapse' aria-expanded='true' style=''>
                                                                                    <div class='card-content'>
                                                                                        <div class='card-body'>
                                                                                            ".showDescriptions($row->orderofbusinamename,$session_barcode, $conn)."
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    ";
                                                                }


                                                            }
                                                        }catch(PDOException $e) {
                                                            echo $e->getMessage();
                                                        }


                                                        $pdo->close();

                                                    ?>
                            
                                              
                                               </div>




                                               <div class="row">                                     
    <div class="col-md-12">
    <?php 
        function getLastVersio($conn, $barcode) {
            $lastpdfs = $conn->prepare("SELECT  a.barcode,  MAX(a.version_no)  AS mxvers, (SELECT CONCAT(order_of_business_id, ' - ', ordering) FROM `search_order_of_business` WHERE barcode = a.barcode ) as nname FROM  search_order_of_busines_files a WHERE a.barcode =:barcode");
            $lastpdfs->execute(['barcode'=>$barcode]);
            $ftclastpdfs = $lastpdfs->fetch();
            $barcodeftclastpdfs = $ftclastpdfs['barcode'] ."-". $ftclastpdfs['mxvers'] ;
            $businessnameftclastpdfs = $ftclastpdfs['nname'];


            if($ftclastpdfs['barcode'] == "") {
                $lastpdfs2 = $conn->prepare("SELECT  barcode, order_of_business_id, ordering FROM  search_order_of_business WHERE barcode =:barcode order by id DESC");
                $lastpdfs2->execute(['barcode'=>$barcode]);
                $ftclastpdfs2 = $lastpdfs2->fetch();
                $barcodeftclastpdfs2 = $ftclastpdfs2['barcode'];
                $businessnameftclastpdfs2 = $ftclastpdfs2['order_of_business_id'] ." - ". $ftclastpdfs2['ordering'] ;

                // return " 
                //         <div class='card'>
                //             <label>$businessnameftclastpdfs2</label>
                            // <iframe
                            //     src='../scanned_docs/$barcodeftclastpdfs2.pdf'
                                
                            //     height='100%'
                            //     width='20%'
                            // ></iframe>
                //         </div>
                //         ";

                return "
                        <div style='display:inline-block;'>
                            <div class='card' style='height:500px'>
                               <div class='card-body'>
                                    <iframe
                                        src='../scanned_docs/$barcodeftclastpdfs2.pdf'
                                        
                                        height='100%'
         
                                    ></iframe>
                                </div>                           
                                <div class='card-footer mx-auto'>
                                    <label class='text-info'>$businessnameftclastpdfs2</label>
                                </div>
                            </div>
                        </div>
                        
                        ";



                
            }else{
                return "
                <div style='display:inline-block;'>
                    <div class='card' style='height:500px'>
                       <div class='card-body'>
                            <iframe
                                src='../scanned_docs/$barcodeftclastpdfs.pdf'
                                
                                height='100%'
 
                            ></iframe>
                        </div>
                        <center>
                        <div class='card-footer mx-auto'>
                            <label class='text-info'>$businessnameftclastpdfs</label>
                        </div>
                        </center>
                    </div>
                </div>
                
                ";
            }

        }
        $stmtpdfs = $conn->prepare("SELECT barcode FROM search_order_of_business WHERE order_of_business_code = :order_of_business_code order by id DESC");
        $stmtpdfs->execute(['order_of_business_code'=>$session_barcode]);
        

        while($rowpdfs = $stmtpdfs->fetchObject()) {

            echo getLastVersio($conn,  $rowpdfs->barcode);
        }
    ?>
    </div>
</div>
                                          
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

                pageLocation("", "li_add_document", "Activity");
                closePageLoader();

                var g_order_ofbusinesscode="";
                var g_barcode="";

                $("#txt_1_1").keyup(function(event) {
                    if (event.keyCode === 13) {
                        $("#send_group_chat").click();
                    }
                });
                $('#uploadFile').change(function(){
                    $("#btn-submit-attachment").trigger("click");
                });


                $(document).on('click', '.btn-actions', function(e){
                    e.preventDefault();
                    var action = $(this).data("actions");

                    if(action =="add-comment") {

                        var add_comment = "";
                        var message = $("#txt_1_1").val();
                        var session_forum_id = "<?php echo $session_barcode ?>";

                        $.ajax({
                            url         : "../actions/s_activity_act.php",
                            method      : "post",
                            dataType    : "json",
                            data        : {
                                add_comment, message, session_forum_id
                            },
                            beforeSend : function() {
                                openPageLoader();
                         
                            },
                            success : function (response){
                                if(response[0] == "success") {
                                    closePageLoader();
                                    $("#group_chat_history").html("");
                                    $("#group_chat_history").html(response[1]);
                                    $("#txt_1_1").val("");
                                    responseTosubmit(response[0], "Success", response[2], "noform", "notbl", "nomodal");
                                }else{
                                    responseTosubmit(response[0], response[1], response[2], "noform", "notbl", "nomodal");
                                }
                            }
                        })
                    }else if(action == "submit-attachment") {

                        var formData    = new FormData();
                        formData.append('upload_att', "");
                        formData.append('file', $('#uploadFile')[0].files[0]);
                        formData.append('barcode', "<?php echo $session_barcode; ?>");
                        $.ajax({
                            url: "../actions/s_activity_act.php",
                            type: "POST",
                            dataType : "json",
                            data: formData,
                            contentType:false,
                            cache: false,
                            processData: false,
                            beforeSend : function() {
                                openPageLoader();
                            },
                            success: function(response){
                                if(response[0] == "success") {
                                    closePageLoader();
                                    $("#group_chat_history").html("");
                                    $("#group_chat_history").html(response[1]);
                                    $("#txt_1_1").val("");
                                    responseTosubmit(response[0], "Success", response[2], "noform", "notbl", "nomodal");
                                }else{
                                    responseTosubmit(response[0], response[1], response[2], "noform", "notbl", "nomodal");
                                }
                        
                        
                            }
                        });

                    }else if(action =="uploadfILE"){

                        var gen_page_cover = "";
                        var order_of_business_code = g_order_ofbusinesscode;
                        var barcode = g_barcode;

                        $.ajax({
                            url : "../actions/s_activity_act.php",
                            method : "post",
                            dataType : "json",
                            data : {
                                gen_page_cover, order_of_business_code, barcode
                            },
                            beforeSend : function() {
                                openPageLoader();
                            },
                            success : function(response) {
                                closePageLoader();
                                if(response[0] == "error") {
                                    responseTosubmit2(response[0], response[1] , response[2]);
                                }else{

                                    var add_version= "";
                                    var barcodeorig = response[4];  
                                    var barcodecc = g_barcode; 
                                    var maxversion = response[5];
                                    

                                    $.ajax({
                                        url : "../actions/s_activity_act.php",
                                        method : "post",
                                        dataType: "json",
                                        data : {
                                            add_version, barcodeorig, barcodecc, maxversion
                                        },
                                        success : function (response) {
                                            responseTosubmit2(response[0], response[1] , response[2]);
                                        }

                                    });


                                    var win = window.open(`s_print_generate_upload_file.php?barcode=${response[3]}&&barcodeorig=${response[4]}&&vers=${response[5]}`, "thePopUp", "width=500,height=500");
                                        win.document.title = 'Generating ... Please Dont Close';
                                        
                                        var pollTimer = window.setInterval(function() {
                                            if (win.closed !== false) {
                                                window.clearInterval(pollTimer);
                                                
                                                setTimeout(function() {        showPrintedCopy(response[3]); }, 1000);
                                                setTimeout(function() {        location.reload() }, 3000);
                                        
                                            }
                                     }, 200);

                                }
                            }
                        });  

                    }else if(action="downloadaszip") {
                    
                        window.location.href=`s_download_as_zip.php?orderofbusinesscode=${ "<?php echo $session_barcode ?>" }`;


                    }else{

                    
                        responseTosubmit2("error", "Error Found", "Please Reload page");
                    }
                    
                    
                    ;

                });


                $(document).on('click', '.cls-vw-files', function(e){
            
                    var vw_files = "";
                    var barcode = $(this).data('barcode');
                    var businesscode = $(this).data('businesscode');
                    g_order_ofbusinesscode =  businesscode;
                    g_barcode = barcode;


                    $.ajax({
                        url : "../actions/s_activity_act.php",
                        method : "post",
                        dataType : "json",
                        data : {
                            vw_files, barcode, businesscode
                        },
                        beforeSend : function() {
                            openPageLoader();
                            $("#div_original_file").html("");
                        },
                        success : function(response) {
                            closePageLoader()
                            $("#div_original_file").html(response[2]);
                            $("#mdl_main").modal("show");
                        }
                    });  
                });
            });

            //     pageLocation("", "li_add_document", "Add/Update Documents");

            //     var s_table_main    = "";

                
            
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

            //     var table = $('#tbl_main').DataTable( {
            //         'ajax': {
            //             'method' : 'POST',
            //             'url'    :'../actions/s_addupdate_doc_act.php',
            //             'data'   : {
            //                             s_table_main
            //             },
            //         },
            //         // 'columnDefs': [
            //         //     { "targets": 5,  "data": null, "defaultContent": "<button class='btn btn-primary btn-dl-files'>Download Files</button>" },
            //         // ],

            //         'columns': [
              
            //             { data: 'row1' },
            //             { data: 'row2', visible : false },
            //             { data: 'row3' },
            //             { data: 'row4' },
            //             {
            //                 "className":      'options',
            //                 "render": function(data, type, full, meta){
            //                     if(full.row5 == 1) {
            //                         return "Session On Going <image src='../img/web/circle_green.png' width='10px'>";
            //                     }else{
            //                         return "Session Done <image src='../img/web/circle_red.png' width='10px'>";
            //                     }
            //                 }
            //             }, 
            //             {
            //                 "className":      'options',
            //                 "render": function(data, type, full, meta){
            //                     if(full.row5 == 1) {
            //                         return "<button class='btn btn-primary btn-dl-files'>Download Files</button> <button class='btn btn-success btn-gotosession'>Go to Session</button> ";
            //                     }else{
            //                         return "<button class='btn btn-primary btn-dl-files'>Download Files</button>";
            //                     }
            //                 }
            //             },
                        
            //         ],

            //         'order'  :   [[ 0, 'DESC']],
            //         "initComplete":function( settings, json){
            //             // SyncDocument();
            //             closePageLoader();
            //         },
            //     });
            //     $('#tbl_main tbody').on( 'click', '.btn-dl-files', function () {
            //         var data = table.row( $(this).parents('tr') ).data();
            //         var getFileondb = "";
            //         var barcode = data['row1'];
              
            //         window.open(`s_print_blob_db.php?barcode=${barcode}`);
            //     } );

            //     $('#tbl_main tbody').on( 'click', '.btn-gotosession', function () {
            //         var data = table.row( $(this).parents('tr') ).data();
            //         alert(data['row1'])
            //         // var getFileondb = "";
            //         // var barcode = data['row1'];
              
            //         // window.open(`s_print_blob_db.php?barcode=${barcode}`);
            //     } );
            // });


            // let SyncDocument=() =>{
            //     var view_documents = "";
            //     $.ajax({
            //             url : "../actions/s_addupdate_doc_act.php",
            //             method : "post",
            //             dataType : "json", 
            //             data : {
            //                 view_documents
            //             },
            //             beforeSend : function() {
            //                 openPageLoader();
            //             },
            //             success : function (response) {
                            
            //                 closePageLoader();

            //                 // if(response[0] != "success") {
            //                 //     responseTosubmit2(response[0], response[1], response[2]);

            //                 // }
            //             }

            //         });
                
            // }


            let showPrintedCopy = (barcode) => {
                window.open(`pr/${barcode}.pdf`,"popupWindow", "width=900,height=900,scrollbars=yes");
                $("#mdl_print").modal("hide");

            }
        </script>
</body>
</html>
