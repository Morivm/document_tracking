<?php
    include 'session.php';

    include '../includes/header.php';
?>
<style>
#wrapper {
    text-align:center;
    margin:0 auto;
    padding:0px;
    width:995px;
}
#drop-area {
    margin-top:20px;
    margin-left:220px;
    width:550px;
    height:200px;
    background-color:white;
    border:3px dashed grey;
}
.drop-text {
    margin-top:70px;
    color:grey;
    font-size:25px;
    font-weight:bold;
}
#drop-area img {
    max-width:200px;
}
</style>
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
                                <li class="breadcrumb-item active">My Profile
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
                        <div class="card-content ">
                            <div class="card-body card-dashboard">

                            <div class="nav-vertical">
                                <ul class="nav nav-tabs nav-left flex-column">
                                    <li class="nav-item">
                                    <a class="nav-link active" id="baseVerticalLeft-tab1" data-toggle="tab"
                                        aria-controls="tabVerticalLeft1" href="#tabVerticalLeft1" aria-expanded="true">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" id="baseVerticalLeft-tab2" data-toggle="tab" aria-controls="tabVerticalLeft2"
                                        href="#tabVerticalLeft2" aria-expanded="false">Account</a>
                                    </li>
                                </ul>
                                <div class="tab-content px-1">
                                    <div role="tabpanel" class="tab-pane active" id="tabVerticalLeft1" aria-expanded="true"
                                        aria-labelledby="baseVerticalLeft-tab1">
                                        <div class="container mt-3">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h2 style="color: #1E9FF2">Avatar</h2>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <img class="img-fluid" src="<?php echo checkUserimgExist($userid) ?>" alt="User-Pic">
                                                </div>
                                                <div class="col-md-9">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr width="20">
                                                                <th scope="col">NAME:</th>
                                                                <th scope="col"><?php echo $userempname; ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">DEPARTMENT CODE:</th>
                                                                <th scope="col"><?php echo $usedeptcode; ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">DEPARTMENT:</th>
                                                                <th scope="col"><?php echo $userdeptname; ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">ROLE:</th>
                                                                <th scope="col"><?php echo $userrole; ?></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <h2 style="color: #1E9FF2">Change Profile Picture</h2>
                                                </div>

                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div id="wrapper">
                                                        <input type="file" id="inpy"  style="display:none;">
                                                        <label for="inpy">Click me to upload (Max size: 3mb, Accepted Filetype :jpg)</label>
                                                        <div id="drop-area">
                                                            <h3 class="drop-text">Or Drag and Drop Images Here To Automatically Upload</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>        
                                    </div>
                                    <!-- TAB 2 -->
                                    <div class="tab-pane" id="tabVerticalLeft2" aria-labelledby="baseVerticalLeft-tab2">
                                        <div class="container mt-3">
                                            <h2 style="color: #1E9FF2">Change Password</h2>
                                        </div>
                                        <div class="container mt-3">

                                            <form id="frm_profile" class="form-horizontal frm_profile" action="../actions/act_profile.php" method="post">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="ch_oldpass">Old Password</label>
                                                    <div class="col-md-9 mx-auto">
                                                        <input type="text" id="ch_oldpass" class="form-control" placeholder="Old Password" name="ch_oldpass">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="ch_newpass">New Password</label>
                                                    <div class="col-md-9 mx-auto">
                                                        <input type="text" id="ch_newpass" class="form-control" placeholder="New Password" name="ch_newpass">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="ch_reenterpass">Re-Enter Password</label>
                                                    <div class="col-md-9 mx-auto">
                                                        <input type="text" id="ch_reenterpass" class="form-control" placeholder="Re-Enter Password" name="ch_reenterpass">
                                                    </div>
                                                </div>
                                                <div class="pull-right">
                                                    <input type="submit" class="btn btn-success" value="Update Password">
                                                </div>
                                            </form>

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

                pageLocation("", "", "My Profile");
                closePageLoader();

    
                $("#drop-area").on('dragenter', function (e){
                    e.preventDefault();
                    $(this).css('background', '#BBD5B8');
                    
                });

                $("#drop-area").on('dragover', function (e){
                    e.preventDefault();
                });

                $("#drop-area").on('drop', function (e){
                    $(this).css('background', '#D8F9D3');
                    e.preventDefault();
                    var image = e.originalEvent.dataTransfer.files;
                    createFormData(image);
                });

                $("#inpy").on('change',function(e){
                    $("#drop-area").css('background', '#D8F9D3');
                    e.preventDefault();
                    var image = e.target.files;
                    createFormData(image);
                });


                $("form#frm_profile").validate({
                    rules: {
                        ch_oldpass: {
                            required : true
                        },
                        ch_newpass: {
                            required : true
                        },
                        ch_reenterpass: {
                            required : true,
                            equalTo : "#ch_newpass"
                        },
                    },
                    messages: {
                        ch_oldpass: {
                            required    : "Old Password is Required."
                        },
                        ch_newpass: {
                            required    : "New Password is Required."
                        },
                        ch_reenterpass: {
                            required    : "Re-Enter Password is Required.",
                            equalTo     : "Please Enter new password to validate"

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
                        formData.append('changepass', "");

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
                                responseTosubmit(response[0], response[1], response[2], "frm_profile", "0", "0");
                            }            
                        });
                    }
                });



                function createFormData(image) {
                    var formImage = new FormData();
                    formImage.append('userImage', image[0]);
                    uploadFormData(formImage);
                }

                function uploadFormData(formData) {
                    formData.append('changeprofilepic', "");
                    $.ajax({
                        url: "../actions/act_profile.php",
                        type: "POST",
                        dataType : "json",
                        data: formData,
                        contentType:false,
                        cache: false,
                        processData: false,
                        beforeSend : function() {
                            webBlock("Uploading...");
                        },  
                        success: function(response){
                            if(response[0] == "error") {
                                responseTosubmit2(response[0], response[1], response[2]);
                            }else{
                                responseTosubmit2(response[0], response[1], response[2]);
                                $('#drop-area').html(response[3]);
                                setTimeout(function() { location.reload();}, 2000);
                            }
                      
                      
                        }
                    });
                }


            });
        </script>
</body>
</html>
