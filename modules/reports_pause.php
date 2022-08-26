<?php
    include 'session.php';

    include '../includes/header.php';
?>
<body class="vertical-layout vertical-menu 2-columns  fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">


<?php
    include '../includes/topbar.php';
    include '../includes/sidebar.php'
?>

<div class="modal fade text-left mdl_viewbarcode" id="mdl_viewbarcode">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Barcode History</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="container">
                        <div id="div_response"></div>
                    </div>
               
                </div>
            <div class="modal-footer">
                <form class="form form-horizontal" id="formdownloadform" action="recieve_transfer_download.php" method="post">
                    <input type="submit" class="btn btn-success" value="Download Attachments">
                </form>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <!-- <input type="button" class="btn btn-outline-primary btn-actions" id="btn-print" data-action="print" value="Print"> -->
            </div>
        </div>
    </div>
</div>




    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Reports</h3>
                    <div class="row breadcrumbs-top">
                        <!-- <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                </li>
                                <li class="breadcrumb-item active">
                                </li>
                            </ol>
                        </div> -->
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
                                    
                                        <div class="row">
                                            <div class="col-xl-3">
                                                    <input type="text" class="form-control" name="rs_text_1_2" id="rs_text_1_2" autocomplete="off">
                                            </div>
                                            <!-- <div class="col-xl-2">
                                                <button type="button" class="btn btn-success btn-block btn-actions" data-actions="print">Fetch Barcodes</button>
                                            </div> -->
                                        </div>
                                        
                                    
                                </div>
                                <div class="card-content ">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="tbl_1" class="table table-hover table-bordered table-striped tbl_1" style="width:100%">
                                                <thead class="cdtheadcolor">
                                                    <tr>
                                                        <th>Barcode</th>
                                                        <th>Document Title</th>
                                                        <th>Department</th>
                                                        <th>Date Paused</th>
                                                        <!-- <th>Action</th> -->
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

            $(function() {

                pageLocation("li_reports", "li_reports_pause", "Paused Documents");
                
                var returned_global_min = "";
                var returned_global_max = "";   
                var tbl_1               = "";
                var doc_status          = "PAUSED";

                $('input[name="rs_text_1_2"]').val('');
                $('input[name="rs_text_1_2"]').attr("placeholder","Choose a Date Pause range");

            


                /* =========================== DATE RANGEE PICKER =========================== */
                $("#rs_text_1_2").daterangepicker({
                    // "timePicker": true,
                    startDate: moment().startOf('hour'),
                    endDate: moment().startOf('hour').add(32, 'hour'),
                    // "timePicker24Hour": true,
                    showDropdowns: true,
                    autoUpdateInput: false,
                    cancelClass: "btn-danger",  
                    opens: 'right',
                        locale: {
                            format: 'YYYY-MM-DD',
                            cancelLabel: 'Clear'
                        },
                    },
                );
            
  
      
                /* =========================== TABLE =========================== */

                var table = $('#tbl_1').DataTable( {
                    "language": {
                        "emptyTable": "No Results Found."
                    },
                    // buttons: [
                    //     'copy', 'csv', 'excel', 'pdf', 'print'
                    // ],
                    'ajax': {
                        'method' : 'GET',
                        'url'    :`../actions/act_reports.php?status=${doc_status}`,
                        'data'   : {
                            tbl_1
                        },
                    },
                    // 'columnDefs': [
                    //     { "targets": 4,  "data": null, "defaultContent": "<button class='btn btn-success btn-vwDetails'>View Details</button>" },
                    // ],
                    'columns': [
                        { data: 'row1' },
                        { data: 'row2' },
                        { data: 'row3' },
                        { data: 'row4' },
                    ],
                    "initComplete":function( settings, json){
                        closePageLoader();
                    },

                });
                $.fn.dataTable.ext.search.push(
                    function( settings, data, dataIndex ) {
                    if ( settings.nTable.id !== 'tbl_1' ) {
                        return true;
                    }else{
                            var min_date_returned2 = returned_global_min;
                            var min_returned2 = new Date(min_date_returned2);
                            var max_date_returned2 = returned_global_max;
                            var max_returned2 = new Date(max_date_returned2);
                            var startDate_returned2 = new Date(data[3]); 
                
                            if (!min_date_returned2 && !max_date_returned2) {
                                    return true;
                                }
                                if (!min_date_returned2 && startDate_returned2 <= max_returned2) {
                                    return true;
                                }
                                if (!max_date_returned2 && startDate_returned2 >= min_returned2) {
                                    return true;
                                }
                                if (startDate_returned2 <= max_returned2 && startDate_returned2 >= min_returned2) {
                                    return true;
                                }
                                return false;
                        }
                    }
                )
                $(`#tbl_1 tbody`).on( 'click', '.btn-vwDetails', function (e) {
                    e.preventDefault();
                    var view_detailed_rep = "";
                    var data        = table.row( $(this).parents('tr') ).data();
                    var barcode     = data['row1'];
                    var status      = doc_status;
                    $.ajax({
                        url     : "../actions/act_reports_detailed.php",
                        method  : "POST",
                        dataType: "JSON",
                        data    : {
                            view_detailed_rep, status, barcode
                        },
                        beforeSend:function() {
                            $("#div_response").html("");

                            document.getElementById("cover-spin").style.display = 'block';
                        },
                        success: function(response) {
                            closePageLoader();
                            // alert(response);
                            $("#formdownloadform").attr('action', `recieve_transfer_download.php?barcode=${barcode}`);
                            $("#div_response").append(response);
                            $("#mdl_viewbarcode").modal("show");
                        }
                    });         
                } );
               

                $('#rs_text_1_2').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                    returned_global_min = picker.startDate.format('YYYY-MM-DD');
                    returned_global_max = picker.endDate.format('YYYY-MM-DD');

                    table.draw();
                });
                $('#rs_text_1_2').on('cancel.daterangepicker', function(ev, picker) {
                    returned_global_min = "";
                    returned_global_max = "";
                    table.draw();
                    $('#rs_text_1_2').val('');
                });
            });



           
        </script>
</body>
</html>
