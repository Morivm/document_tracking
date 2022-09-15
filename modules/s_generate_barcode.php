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
                                                <input type="text" class="form-control" name="txt1_0" id="txt1_0" placeholder="Order of Business Date">
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select class="form-control cls-employees" id="txt1_1" name="txt1_1">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div id="results_forms"></div>
                                            </div>
                                        </div>

                                        <hr>

                                        <label class="text-primary font-weight-bold">Order of Business</label>
                                        <div class="row">
                                            <div class="col-md-3">

                                                <select class="form-control cls-orderofbusiness select2-custom" id="txt1_2" name="txt1_2">
                                                    <option></option>
                                                </select>
                                                <br><br>

                                                <input type="text" class="form-control textfield-custom" name="text1_3" id="text1_3" placeholder="Title">
                                                <br>

                                                <input type="text" class="form-control textfield-custom" name="text1_4" id="text1_4" placeholder="Ordinance Code/ Referrence No.">
                                                <br>

                                                <textarea class="form-control textfield-custom" name="text1_5" id="text1_5" cols="30" rows="5" placeholder="Description"></textarea>
                                                <br>

                                                <button class="btn btn-success btn-block btn-actions" data-action="add_order_business">Add</button>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-stripped tbl_main1"  id="tbl_main1">
                                                        <thead style="background-color:#1E9FF2 ; color:white">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Order of Business</th>
                                                                <th scope="col">Title</th>
                                                                <th scope="col">Ordinance Code/ Ref No.</th>
                                                                <th scope="col">Description</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                        </div><br>


                                        <!-- ============================================COMMITTEE -->

                                        <hr>

                                        <label class="text-primary font-weight-bold">Committee</label>
                           
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select class="form-control cls-commitee select2-custom" id="txt1_6" name="txt1_6">
                                                    <option></option>
                                                </select>
                                                <br><br>

                                                <button class="btn btn-success btn-block btn-actions" data-action="addcommitee">Add</button>
                                            </div>

                                            <div class="col-md-9">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-stripped tbl_main2"  id="tbl_main2">
                                                    <thead style="background-color:#1E9FF2 ; color:white">
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Committee</th>
                                                            <th scope="col">Persons</th>
                                                            <th scope="col">Positions</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                </div>
                                            </div>


                                        </div>
                            
                                        <br>
                                        <button type="button" class="btn btn-success pull-right btn-actions" data-action="gen_coverpage">Generatate Cover Page</button>
                                         
                                            <!-- <div class="col-md-3">
                                                <select class="form-control cls-type-of-person" id="txt1_2" name="txt1_2">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-success btn-actions" data-action="generate_barcode">Generate Cover Page</button>
                                            </div> -->
                                      
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
            
                getDataSelect2("cls-employees","Select Contract Name","select_contractname");
                getDataSelect2("cls-orderofbusiness","Select Order of Business","select_orderofbusiness");
                getDataSelect2("cls-commitee","Select Commitee","select_commitee");
                getDataSelect2("cls-type-of-person","Select Type","select_type_of_person");

                deletefirstdb();

                var s_table_main1 = "";
                var s_table_main2 = "";
                

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

                    }else if(actions == "add_order_business") {
                        e.preventDefault();
                        
                        var create_order_of_busineess = "";
                        var order_business_id   = $("#txt1_2").val();
                        var order_title         = $("#text1_3").val();
                        var order_ordinance_code= $("#text1_4").val();
                        var order_description   = $("#text1_5").val();
                        var barcode             = "fafdsafdafdafdfadf";

                        $.ajax({
                            url : "../actions/s_generate_barcode_act.php",
                            method : "post",
                            dataType: "json",
                            data : {
                                barcode,
                                create_order_of_busineess,
                                order_business_id,
                                order_title,
                                order_ordinance_code,
                                order_description
                            },
                            beforeSend:function() {
                                openPageLoader();
                            },
                            success : function(response){
                                responseTosubmitcustomselect(response[0], response[1], response[2], "noform", "tbl_main1", "nomodal");
                            }

                        });
                    
                    }else if (actions == "addcommitee") {
                        
                        var create_commitees = "";
                        var committee_id = $("#txt1_6").val();

                        $.ajax({
                            url : "../actions/s_generate_barcode_act.php",
                            method : "post",
                            dataType: "json",
                            data    : {
                                create_commitees, committee_id
                            },
                            beforeSend:function() {
                                openPageLoader();
                            },
                            success : function(response){
                                responseTosubmitcustomselect(response[0], response[1], response[2], "noform", "tbl_main2", "nomodal");
                            }

                        });
                    }else if (actions=="gen_coverpage"){

                        var gen_cover_page = "";
                        $.ajax({
                            url : "../actions/s_generate_barcode_act.php",
                            method : "post",
                            dataType: "json",
                            data    : {
                                gen_cover_page
                            },
                            beforeSend:function() {
                                openPageLoader();
                            },
                            success : function(response){
                                if(response[0] == "error") {
                                    responseTosubmit2(response[0], response[1] , response[2]);
                                }else{

                                    var update_print_bc = "";
                                    var win = window.open(`s_print_generate_barcode.php?barcode=${response[2]}`, "thePopUp", "width=500,height=500");
                                        win.document.title = 'Generating ... Please Dont Close';
                                        var pollTimer = window.setInterval(function() {
                                            if (win.closed !== false) { // !== is required for compatibility with Opera
                                                window.clearInterval(pollTimer);

                                                setTimeout(function() {        showPrintedCopy(response[2]); }, 1000);
                                                setTimeout(function() {        location.reload() }, 3000);

                                                responseTosubmit2(response[0], response[1] , response[2]);


                                            }
                                     }, 200);

                                }
                                // responseTosubmitcustomselect(response[0], response[1], response[2], "noform", "tbl_main2", "nomodal");
                            }

                        });
                    
                    }else{
                        responseTosubmit2("error", "Error Found", "Please Reload Page First.");
                    }
                });
            

                


                $(document.body).on("change","#txt1_1",function(){
                    var x =  this.value;
                    var get_forms = "";
                    $.ajax({
                        url : "../actions/s_generate_barcode_act.php",
                        method : "post",
                        dataType : "json",
                        data : {
                            get_forms , x
                        },
                        beforeSend : function () {
                            $("#results_forms").html("");
                        },
                        success : function(response) {
                            console.log(response);
                            if(response[0] == "error") {
                                $("#results_forms").html("");
                            }else{
                                $("#results_forms").html(response);
                            }
                            
                        }
                    });
                });


                var table = $('#tbl_main1').DataTable( {
        
                    'ajax': {
                        'method' : 'POST',
                        'url'    :'../actions/s_generate_barcode_act.php',
                        'data'   : {
                                        s_table_main1
                        },
                    },
                    'columnDefs': [
                        { "targets": 5,  "data": null, "defaultContent": "<button class='btn btn-danger delete_btn' data-toggle='tooltip' title='Click to Remove'> Remove</button>" },
                    ],

                    'columns': [
              
                        { data: 'row1' , visible : false},
                        { data: 'row2' , "width" : "5%" },
                        { data: 'row3' , "width" : "5%"},
                        { data: 'row4' , "width" : "10%"},
                        { data: 'row5' , "width" : "50%"},
                    ],
                    "initComplete":function( settings, json){
                    },
                });

                var table2 = $('#tbl_main2').DataTable( {
        
                        'ajax': {
                            'method' : 'POST',
                            'url'    :'../actions/s_generate_barcode_act.php',
                            'data'   : {
                                            s_table_main2
                            },
                        },
                        'columnDefs': [
                            { "targets": 4,  "data": null, "defaultContent": "<button class='btn btn-danger delete_btn' data-toggle='tooltip' title='Click to Remove'> Remove</button>" },
                        ],

                        'columns': [
                
                            { data: 'row1'},
                            { data: 'row2'},
                            { data: 'row3'},
                            { data: 'row4'},
                            // { data: 'row5' , "width" : "50%"},
                        ],
                        "initComplete":function( settings, json){
                            closePageLoader();
                        },
                });


                

                // $('#tbl_main tbody').on( 'click', '.edit_btn', function () {
                //     var data = table.row( $(this).parents('tr') ).data();

                //     s_id = data['row1'];
                //     s_action = "UPDATE";
                //     $("#text_1").val(data['row2']);
                //     $("#text_2").val(data['row3']);
              

                //     $("#mdl_main").modal("show");
                    
                // } );
            });


            let deletefirstdb =() => {
        
                var deletefirst_tmp = "";

                $.ajax({
                    url : "../actions/s_generate_barcode_act.php",
                    method : "post",
                    dataType : "json",
                    data : {
                        deletefirst_tmp 
                    },
                    success : function(response) {
                        // alert(response);
                    }
                });

            }
            
            let showPrintedCopy = (barcode) => {

                window.open(`pr/${barcode}.pdf`,"popupWindow", "width=900,height=900,scrollbars=yes");
                $("#mdl_print").modal("hide");

            }

        </script>
</body>
</html>
