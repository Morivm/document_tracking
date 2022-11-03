
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

<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
        <div class="card pull-up">
        <div class="card-content">
            <div class="card-body">
            <div class="media d-flex">
                <div class="align-self-center">
                <i class="las la-user font-large-2 success"></i>
                </div>
                <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Total Users</h5>
                <div id="spin_role1" class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <h3 id="text_role1" class="text-bold-600"></h3>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
        <div class="card pull-up">
        <div class="card-content">
            <div class="card-body">
            <div class="media d-flex">
                <div class="align-self-center">
                <i class="las la-book font-large-2 warning"></i>
                </div>
                <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Total Created Covers</h5>
                <div id="spin_role2" class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <h3 id="text_role2" class="text-bold-600"></h3>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
        <div class="card pull-up">
        <div class="card-content">
            <div class="card-body">
            <div class="media d-flex">
                <div class="align-self-center">
                <i class="la la-calendar-check-o font-large-2 info"></i>
                </div>
                <div class="media-body text-right">
                <!-- 7 Days -->
                <h5 class="text-muted text-bold-500">Recently Added</h5>
                <div id="spin_role3" class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <h3 id="text_role3" class="text-bold-600"></h3>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
        <div class="card pull-up">
        <div class="card-content">
            <div class="card-body">
            <div class="media d-flex">
                <div class="align-self-center">
                <i class="las la-file font-large-2 danger"></i>
                </div>
                <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Total Uploaded Files</h5>
                <div id="spin_role4" class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <h3 id="text_role4" class="text-bold-600"></h3>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>


<div class="row match-height">
  <div class="col-12 col-md-4">
    <div class="card" style="height: 453.359px;">
      <div class="card-header">
        <h4 class="card-title">Added Users</h4>
      </div>
      <div class="card-content">
        <div class="table-responsive">
          <table id="recent-orders" class="table table-hover table-xl mb-0">
          <tbody>

            <?php
                try {
                    $stmt = $conn->prepare("SELECT 
                                            CONCAT_WS(' ', b.lastname, firstname, middlename) AS fname ,
                                            added_date
                                            
                                        FROM `tbl_users` a
                                        LEFT JOIN tbl_users_detail b ON a.userid = b.id
                                        WHERE deleted_by = 0
                                        ORDER BY added_date DESC LIMIT 5");
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if($count == 0) {
                        echo "No Users Found";
                    }else{
                        while ($row = $stmt->fetchObject()) {
                           
                            echo    "<tr>
                                        <td>
                                            <div class='name'>$row->fname</div>
                                        </td>
                                        <td>
                                            ".$pdo->timeAgo($row->added_date)."
                                        </td>
                                    </tr>
                                    ";
                                }
                    }
                }catch(PDOException $e) {

                    echo $e->getMessage();
                }
            ?>
          </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div id="recent-appointments" class="col-12 col-md-8">
    <div class="card" style="height: 453.359px;">
      <div class="card-header">
        <h4 class="card-title">Recent CoverPage</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
      </div>
      <div class="card-content mt-1">
        <div class="table-responsive">
            <table id="recent-orders-doctors" class="table table-hover table-xl mb-0">
                <thead>
                    <tr>
                        <th class="border-top-0">Generated By</th>
                        <th class="border-top-0">Barcode</th>
                        <th class="border-top-0">Order Of Business Date</th>
                        <th class="border-top-0">Date Generated</th>
                        <th class="border-top-0">View</th>
                    </tr>
                </thead>
                <tbody>
                
                <?php
                try {
                    $stmt2 = $conn->prepare("SELECT created_by, order_of_business_code, order_of_business_date, generated_date 
                                            FROM 
                                            `tbl_generated_cover`
                                            ORDER BY generated_date DESC
                                            LIMIT 5");
                    $stmt2->execute();
                    $count2 = $stmt2->rowCount();
                    if($count2 == 0) {
                        echo "No Generated Cover Yet";
                    }else{
                        while ($row2 = $stmt2->fetchObject()) {
                           
                            echo    "
                                        <tr class='pull-up'>
                                        <td class='text-truncate'>$row2->created_by</td>
                                        <td class='text-truncate'>$row2->order_of_business_code</td>
                                        <td class='text-truncate'>".$pdo->dateFormating(2, $row2->order_of_business_date)."</td>
                                        <td class='text-truncate'>".$pdo->dateFormating(2, $row2->generated_date)." (".$pdo->timeAgo($row2->generated_date).")"."</td>
                                        <td class='text-truncate'><a href='s_activity.php?det=".$pdo->genRandString(300)."&&activity=$row2->order_of_business_code&&det=".$pdo->genRandString(300)."' class='btn btn-sm btn-outline-success'>View Cover</a></td>
                                        </tr>
                                    ";
                                }
                    }
                }catch(PDOException $e) {

                    echo $e->getMessage();
                }
            ?>


                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>



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

            pageLocation("", "li_gen_dashboard", "Dashboard");

            countActiveUsers();
            countTotalcovers();
            countTotalRecentcovers();
            countUploadedfile();
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
        
        
        let countActiveUsers = () =>{
            let getActiveUsers = "";
            $.ajax({
                url     : "../actions/s_dashboard_act.php",
                method  : "post",
                dataType : "json",
                data    : {
                    getActiveUsers
                },
                beforeSend : function() {
      
                },
                success : function(response) {
                    $("#spin_role1").addClass("d-none");
                    $("#text_role1").text(response[2]);
                }

            });
        }
        let countTotalcovers = () =>{
            let getTotalCovers = "";
            $.ajax({
                url     : "../actions/s_dashboard_act.php",
                method  : "post",
                dataType : "json",
                data    : {
                    getTotalCovers
                },
                beforeSend : function() {
      
                },
                success : function(response) {
                    $("#spin_role2").addClass("d-none");
                    $("#text_role2").text(response[2]);
                }

            });
        }
        let countTotalRecentcovers = () =>{
            let getRecentCovers = "";
            $.ajax({
                url     : "../actions/s_dashboard_act.php",
                method  : "post",
                dataType : "json",
                data    : {
                    getRecentCovers
                },
                beforeSend : function() {
      
                },
                success : function(response) {
                    $("#spin_role3").addClass("d-none");
                    $("#text_role3").text(response[2]);
                }

            });
        }
        let countUploadedfile = () =>{
            let getTotalUploaded = "";
            $.ajax({
                url     : "../actions/s_dashboard_act.php",
                method  : "post",
                dataType : "json",
                data    : {
                    getTotalUploaded
                },
                beforeSend : function() {
      
                },
                success : function(response) {
                    $("#spin_role4").addClass("d-none");
                    $("#text_role4").text(response[2]);
                }
            });
        }
        

        
        
        </script>                            

</body>
</html>
