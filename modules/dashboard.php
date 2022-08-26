
<?php
    include 'session.php';
    include '../includes/header.php';
?>

<body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">


<?php
    include '../includes/topbar.php';
    include '../includes/sidebar.php';
 
?>

    <div class="app-content content">
  
        <div class="content-overlay"></div>
        
        <div class="content-wrapper">
   
            <div class="content-header row">
            </div>
            <div class="content-body">
        <section id="ordering">
            <!-- PENDING -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-danger">Pending Documents</h4>
                        </div>
                        <div class="card-content ">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table id="tbl1" class="table table-hover table-bordered table-striped tbl1" style="width:100%">
                                        <thead class="cdtheadcolor">
                                            <tr>
                                                <!-- <th>ID</th> -->
                                                <th>Barcode</th>
                                                <th>Document Type</th>
                                                <th>Document Title</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Duration(hrs)</th>
                                                <th>Date Created</th>
                                                <th>Date Received</th>
                                                <th>Due</th>
                                                <th>Received By</th>
                                                <th>Status</th>
                                                <th>Due</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- APPROVED -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-success">Approved Documents</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table id="tbl2" class="table table-hover table-bordered table-striped tbl1" style="width:100%">
                                        <thead class="cdtheadcolor">
                                            <tr>
                                                <th>ID</th>
                                                <th>Barcode</th>
                                                <th>Document Type</th>
                                                <th>Document Title</th>
                                                <th>Date Created</th>
                                                <th>Date Approved</th>
                                                <th>Status</th>
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
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <?php include '../includes/footer.php' ?>


    <script>
    
        $(function(){
            closePageLoader();
        // 
        // });

                //         // setTimeout(function(){
                //         //     window.location.reload();
                //         // }, 10000);



                //         var date_time = date_time2();
                //         pageLocation("", "li_dashboard", "Web Setup");
                //         var tbl1 = "";
                //         var tbl2 = "";

                //         var table = $('#tbl1').DataTable( {
                //             // "order"       : [[ 11, "desc" ]],
                //             rowCallback : function( row, data, dataIndex ){
                //                 if ( data['row13'] < ''+date_time+'' && data['row12'] == 'PENDING'){
                //                     $('td', row).addClass('dtrowColumn');
                //                 }
                //             }, 
                //             'ajax': {
                //                 'method' : 'POST',
                //                 'url'    :'../actions/act_dashboard.php',
                //                 'data'   : {
                //                                 tbl1
                //                 },
                //             },
                        
                //             'columns': [
                //                 // { data: 'row1' },
                //                 { data: 'row2' },
                //                 { data: 'row3' },
                //                 { data: 'row4' },
                //                 { data: 'row5' },
                //                 { data: 'row6' },
                //                 { data: 'row7' },
                //                 { data: 'row8' },
                //                 { data: 'row9' },
                //                 { data: 'row10' },
                //                 { data: 'row11' },
                //                 { data: 'row12' },
                //                 { data: 'row13', visible: false },
                //             ],
                //             'order'  :   [[ 6, 'desc']],
                //         });


                //         var table = $('#tbl2').DataTable( {
                //             'ajax': {
                //                 'method' : 'POST',
                //                 'url'    :'../actions/act_dashboard.php',
                //                 'data'   : {
                //                                 tbl2
                //                 },
                //             },
                //             "initComplete":function( settings, json){
                //                 closePageLoader();
                //             },
                //             'columns': [
                //                 { data: 'row1' , visible: false},
                //                 { data: 'row2' },
                //                 { data: 'row3' },
                //                 { data: 'row4' },
                //                 { data: 'row5' },
                //                 { data: 'row6' },
                //                 { data: 'row8' },
                //             ],
                //             'order'  :   [[ 0, 'desc']],
                //         });

                //     });

                //     function pad(n)
                // {
                //   return n<10 ? '0'+n : n
         });


        </script>                            

</body>
</html>
