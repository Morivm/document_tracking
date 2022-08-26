<?php
    include 'includes/session.php';
    $conn = $pdo->open();
    if(isset($_SESSION['doc_5fe2562907c4eafe29b4384343298787676'])){
        header('location: modules/dashboard');
    }
?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Login Page </title>
    <link rel="shortcut icon" class="shortcutico" type="image/x-icon" href="img/web/162918045116287627001627875343ss.jpg">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/icheck/custom.css">`
    <!-- END: Vendor CSS-->

    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/extensions/sweetalert2.min.css">

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/login-register.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->
    <style>
    #cover-spin {
        position:fixed;
        width:100%;
        left:0;right:0;top:0;bottom:0;
        background-color: rgba(255,255,255,0.7);
        z-index:9999;
        display:none;
    }
    #cover-spin::after {
        content:'';
        display:block;
        position:absolute;
        left:48%;top:40%;
        width:40px;height:40px;
        border-style:solid;
        border-color:black;
        border-top-color:transparent;
        border-width: 4px;
        border-radius:50%;
        -webkit-animation: spin .8s linear infinite;
        animation: spin .8s linear infinite;
    }

    #error_msg {
        color: red;
    }

    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px;
    }

    #msform fieldset .form-card {
        background: white;
        border: 0 none;
        border-radius: 0px;
        /* box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2); */
        padding: 20px 40px 30px 40px;
        box-sizing: border-box;
        width: 94%;
        margin: 0 3% 20px 3%;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    /*Hide all except first fieldset*/
    #msform fieldset:not(:first-of-type) {
        display: none;
    }

    #msform fieldset .form-card {
        text-align: left;
        color: #9E9E9E;
    }

    #msform input, #msform textarea {
        padding: 0px 8px 4px 8px;
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        color: #2C3E50;
        font-size: 16px;
        letter-spacing: 1px;
    }

    #msform input:focus, #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: none;
        font-weight: bold;
        border-bottom: 2px solid skyblue;
        outline-width: 0;
    }

    /*Blue Buttons*/
    #msform .action-button {
        width: 100px;
        background: skyblue;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button:hover, #msform .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue;
    }

    /*Previous Buttons*/
    #msform .action-button-previous {
        width: 100px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button-previous:hover, #msform .action-button-previous:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
    }

    /*Dropdown List Exp Date*/
    select.list-dt {
        border: none;
        outline: 0;
        border-bottom: 1px solid #ccc;
        padding: 2px 5px 3px 5px;
        margin: 2px;
    }

    select.list-dt:focus {
        border-bottom: 2px solid skyblue;
    }

    /*The background card*/
    .card {
        z-index: 0;
        border: none;
        border-radius: 0.5rem;
        position: relative;
    }

    /*FieldSet headings*/
    .fs-title {
        font-size: 25px;
        color: #2C3E50;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: left;
    }

    /*progressbar*/
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey;
    }

    #progressbar .active {
        color: #000000;
    }

    #progressbar li {
        list-style-type: none;
        font-size: 12px;
        width: 25%;
        float: left;
        position: relative;
    }

    /*Icons in the ProgressBar*/
    #progressbar #account:before {
        font-family: FontAwesome;
        content: "DB";
    }

    #progressbar #personal:before {
        font-family: FontAwesome;
        content: "SA";
    }

    /* #progressbar #payment:before {
        font-family: FontAwesome;
        content: "\f09d";
    } */

    #progressbar #confirm:before {
        font-family: FontAwesome;
        content: "✓";
    }

    /*ProgressBar before any progress*/
    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 18px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px;
    }

    /*ProgressBar connectors*/
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1;
    }

    /*Color number of the step and the connector before it*/
    #progressbar li.active:before, #progressbar li.active:after {
        background: skyblue;
    }

    /*Imaged Radio Buttons*/
    .radio-group {
        position: relative;
        margin-bottom: 25px;
    }

    .radio {
        display:inline-block;
        width: 204;
        height: 104;
        border-radius: 0;
        background: lightblue;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
        cursor:pointer;
        margin: 8px 2px; 
    }

    .radio:hover {
        box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3);
    }

    .radio.selected {
        box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1);
    }

    /*Fit image in bootstrap div*/
    .fit-image{
        width: 100%;
        object-fit: cover;
    }

    .button__text {
        font: bold 20px 'Quicksand', san-serif;
        color: #ffffff;
        transition: all 0.2s;
    }
    .button--loading::after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        border: 4px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: button-loading-spinner 1s ease infinite;
    }
    @keyframes button-loading-spinner {
    from {
        transform: rotate(0turn);
    }

    to {
        transform: rotate(1turn);
    }
}
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<div id="cover-spin"></div>
<body class="vertical-layout vertical-menu 1-column  bg-white bg-lighten-2 fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="1-column">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row ">
                    <!-- <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
              
                 -->
                 <li class="nav-item"><a class="navbar-brand" href="index">
                 <img class="wb_image" src="" alt="Web Icon" width="50"> <span class="wb_name"></span>

                            <!-- $stmt = $conn->prepare("SELECT top 1 image_name_m FROM tbl_web_setup ORDER BY id DESC");
                            $stmt->execute();
                            $count = $stmt->rowCount();

                            if($count == 0) {
                                echo "<img src='img/web/no_image.png'  alt='Company Logo'width='50' height='50'>";
                            }else{
                                $result = $stmt->fetch();
                                $imgpath = $result['image_name_m'];
                                echo "<img src='img/web/$imgpath'  alt='Company Logo' width='50' height='50'>";
                            }

                            $pdo->close(); -->
                        
                
                    <!-- <img class="brand-logo" alt="" width="500" height="50"> -->
                            <!-- <h3 class="brand-text"></h3> -->
                        </a></li>
                </ul>
            </div>
            <!-- <div class="navbar-container">
                <div class="collapse navbar-collapse justify-content-end" id="navbar-mobile">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"><a class="nav-link mr-2 nav-link-label" href="index.html"><i class="ficon ft-arrow-left"></i></a></li>
                        <li class="dropdown nav-item"><a class="nav-link mr-2 nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-settings"></i></a></li>
                    </ul>
                </div>
            </div> -->
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Content-->


    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body login-box">
                <section class="row navbar-flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <br>
                                        <!-- <img src="" class="brand-logo" alt="branding logo" width="200" height="200"> -->
                                        <!-- <img src="" class="brand-logo" alt="branding logo" width="300" height="300">
                                     -->
                                     <div class="card-title text-center">
                                        <br>
                                        <!-- <img src="" class="brand-logo" alt="branding logo" width="200" height="200"> -->
                                        <!-- <img src="" class="brand-logo" alt="branding logo" width="400" height="100"> -->


                                        <img class="wb_image" src="" alt="Web Icon" width="50%">
                                    </div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span class="wb_name"></span>
                                    </h6>
                                </div> 
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal" method="post" name="frm_login" id="frm_login" action="index_action.php" autocomplete="off" novalidate>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control input-lg" name="txt_username" id="txt_username" placeholder="Username" tabindex="1" value="chris" required data-validation-required-message="Please enter your username.">
                                                <div class="form-control-position">
                                                    <i class="la la-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control input-lg" name="txt_password" id="txt_password" placeholder="Password" tabindex="2" value="imppi000046136" required data-validation-required-message="Please enter your password.">
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                            </fieldset>
                                            <div class="alert mb-2 alertSet hidden" role="alert">
                                                <p id="al_message"></p>
                                            </div>
                                         
                                            <button type="submit" name="btn_login" id="btn_login" class="btn btn-success btn-block btn-lg">Login</button>
                                            <br>
                                            <!-- <div class="form-group row">
                                                <div class="col-md-12 text-center"><a href="recover-password.html" class="card-link">Forgot Password?</a></div>
                                            </div> -->
                                        
                                        </form>
                                    </div>
                                </div>
                                <!-- <div class="card-footer border-0">
                                    <button onclick="register-advanced.html" name="btn_login" id="btn_login" class="btn btn-info btn-block btn-lg"><i class="la la-user"></i> Register</button>
                                </div> -->
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

    <!-- BEGIN: Footer-->
    <footer class="footer fixed-bottom footer-light navbar-border navbar-shadow">
        <p class="clearfix dark lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; <?php echo $web_copyright_year ?><a class="text-bold-800 grey darken-2" href="<?php echo $web_company_site ?>" target="_blank"> <?php echo $web_company ?></a></span><span class="float-md-right d-none d-lg-block"><?php echo $web_version  ?></span></p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
    <script src="app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"></script>
    <script src="app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
    <script src="app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>


    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <script src="app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.js"></script>
    <script src="app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- <script src="app-assets/js/scripts/forms/form-login-register.js"></script> -->
    <script src="app-assets/jquery-validation/jquery.validate.js"></script>
    <script src="app-assets/js/scripts/customizer.min.js"></script>
    <script src="app-assets/js/scripts/footer.min.js"></script>

    <script src="js/index.js"></script>
    <script>

      $.ajax({
            url:'img/resources/webicon.png',
            type:'HEAD',
            error: function()
            {
                $(".wb_image").attr("src", "img/resources/no_asset_img.png");
                $(".shortcut_icon").attr("href", "img/resources/no_asset_img.png");
            },
            success: function()
            {
                $(".wb_image").attr("src", "img/resources/webicon.png");
                $(".shortcut_icon").attr("href", "img/resources/webicon.png");
            }
        });


// var rawFile = new XMLHttpRequest();
// rawFile.open("GET", "img/resources/setup/new.txt", false);
// var result = new Array();
// rawFile.onreadystatechange = function ()
// {
//     if(rawFile.readyState === 4)
//     {
//         if(rawFile.status === 200 || rawFile.status == 0)
//         {
//             var allText = rawFile.responseText;
//             // var allText = rawFile.responseText.slice(1, rawFile.responseText.indexOf("\n"));
//             return allText;
//         }
//     }
// }
// rawFile.send(null);


// var users_sts = result[0] = rawFile.responseText.split("\n")[0].split("=").pop().replace(/(\r\n|\n|\r)/gm, "");


// if(users_sts == 0) {
//     $("#mdl_def_user").modal("show");
// }else{
//     $("#mdl_def_user").modal("hide");
// }


// var current_fs, next_fs, previous_fs;
// var opacity;

// $("#btn-checkConn").click(function(){
//     var check_str_conn = "";
//     var conn_servername = $("#conn_servername").val();
//     var conn_databasename = $("#conn_databasename").val();
//     var conn_databaseusername = $("#conn_databaseusername").val();
//     var conn_databasepassword = $("#conn_databasepassword").val();

//     if( $("#label1").text() == "Connection Success") {

//         current_fs = $(this).parent();
//         next_fs = $(this).parent().next();

//         $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        
//         next_fs.show(); 

//         current_fs.animate({opacity: 0}, {
//             step: function(now) {
//                 opacity = 1 - now;

//                 current_fs.css({
//                     'display': 'none',
//                     'position': 'relative'
//                 });
//                 next_fs.css({'opacity': opacity});
//             }, 
//             duration: 600
//         });
//     }else{
//         $.ajax({
//             url     : "index_action.php",
//             method  : "post",
//             dataType: "json",
//             data : {
//                 check_str_conn,
//                 conn_servername,
//                 conn_databasename,
//                 conn_databaseusername,
//                 conn_databasepassword
//             },
//             beforeSend :function() {
//                 document.getElementById("cover-spin").style.display = 'block';
//                 $("#label1").text("");
//             },
//             success : function(response) {
//                 document.getElementById("cover-spin").style.display = 'none';
    
//                 if(response[0] =="success") {
//                     $("#label1").text(response[2]).removeClass('text-danger').addClass('text-success');
//                     $(".input_connectivity").prop("disabled",true);

//                 }else{
//                     $("#label1").text(response[2]).removeClass('text-success').addClass('text-danger');
//                 } 

//             }

//         });
//     }

// });


// $("#btn-checkSuperAd").click(function(){

//     if( $("#label2").text() == "Succesfully Registered") {
//         current_fs = $(this).parent();
//         next_fs = $(this).parent().next();

//         $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//         next_fs.show(); 

//         current_fs.animate({opacity: 0}, {
//             step: function(now) {
//                 opacity = 1 - now;

//                 current_fs.css({
//                     'display': 'none',
//                     'position': 'relative'
//                 });
//                 next_fs.css({'opacity': opacity});
//             }, 
//             duration: 600
//         });
//     }else{
//         var sa_lastname     = $("#sa_lastname").val();
//         var sa_firstname    = $("#sa_firstname").val();
//         var sa_email        = $("#sa_email").val();
//         var sa_mobile       = $("#sa_mobile").val();
//         var sa_username     = $("#sa_username").val();
//         var sa_password     = $("#sa_password").val();
//         var sa_repassword   = $("#sa_repassword").val();
//         var add_superadmin = "";

//         $.ajax({
//             url     : "index_action.php",
//             method  : "post",
//             dataType: "json",
//             data : {
//                 add_superadmin,
//                 sa_lastname,
//                 sa_firstname,
//                 sa_email,
//                 sa_mobile,
//                 sa_username,
//                 sa_password,
//                 sa_repassword
//             },
//             beforeSend :function() {
//                 document.getElementById("cover-spin").style.display = 'block';
//                 $("#label2").text("");
//                 $("#btn-checkSuperAd").prop("disabled",true);
//             },
//             success : function(response) {

//                 document.getElementById("cover-spin").style.display = 'none';
//                 $("#btn-checkSuperAd").prop("disabled",false);
//                 if(response[0] =="success") {
//                     $("#label2").text(response[2]).removeClass('text-danger').addClass('text-success');
//                     $(".input_sa").prop("disabled",true);

//                     $("#cred_username").text(sa_username);
//                     $("#cred_password").text(sa_password);
//                 }else{
//                     $("#label2").text(response[2]).removeClass('text-success').addClass('text-danger');
//                 } 

//             }
//         });
//     }
// });

// $("#btnCloseCred").click(function(){

//     window.location.reload();
// });

// $(".previous").click(function(){
    
//     current_fs = $(this).parent();
//     previous_fs = $(this).parent().prev();
    
//     //Remove class active
//     $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    
//     //show the previous fieldset
//     previous_fs.show();

//     //hide the current fieldset with style
//     current_fs.animate({opacity: 0}, {
//         step: function(now) {
//             // for making fielset appear animation
//             opacity = 1 - now;

//             current_fs.css({
//                 'display': 'none',
//                 'position': 'relative'
//             });
//             previous_fs.css({'opacity': opacity});
//         }, 
//         duration: 600
//     });
// });

// $('.radio-group .radio').click(function(){
//     $(this).parent().find('.radio').removeClass('selected');
//     $(this).addClass('selected');
// });

// $(".submit").click(function(){
//     return false;
// })







    </script>

</body>


</html>