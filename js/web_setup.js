$(function(){
    // $('.webTitle').text("Web Setup");
    closePageLoader();
    pageLocation("", "web_setup", "Web Setup");
    var mailisys = readTextFiles("../img/resources/setup/setup.txt");

    if (mailisys[0] =="off") {
        $("#customSwitch1").removeAttr("checked");
        $('#frm_mailer *').prop('disabled', true);
    }else  if (mailisys[0] =="on") {
        $('#customSwitch1').attr('checked', '');
        $('#frm_mailer *').prop('disabled', false);
    }else{
        alert("notfound");
    }

    $(document).on('change', '#customSwitch1', function (e) {
        var switch_mailer = "";
        var switch_status = "";
        let test = e.target.checked;
     
        if(test) {
            switch_status = "Mailing=on";
            $('#frm_mailer *').prop('disabled', false);
        }else{
            switch_status = "Mailing=off";
            $('#frm_mailer *').prop('disabled', true);
        }

        $.ajax({
            url : "../actions/act_web_setup.php",
            method : "post",
            dataType : "json",
            data : {
                switch_mailer, switch_status
            },
            beforeSend : function() {
                webBlock("Please Wait..."); 
            },
            success : function(response) {
                responseTosubmit2(response[0], response[1], response[2]);
            }

        });
    });


    $(document).on('click','#btn-mailer-test', function(e){
        e.preventDefault();
        $("#mdl_test_mail").modal("show");
        // var test_mailer = "";
        // $.ajax({
        //     url : "../actions/act_web_setup.php",
        //     method : "post",
        //     dataType : "json",
        //     data : {
        //         test_mailer
        //     },
        //     beforeSend : function() {
        //         webBlock("Please Wait..."); 
        //     },
        //     success : function(response) {

        //         responseTosubmit2(response[0], response[1], response[2]);
        //     }

        // });
        

    });


    $('#web_icon').on("change", function(e){
        var myarray = [];
        var fileName = e.target.files[0].name;
        myarray.push("jpg","png","jpeg");
        var ext = $(this).val().split('.').pop().toLowerCase();
        if(jQuery.inArray(ext, myarray) == -1){
                $('.custom-file-w').html(fileName);
                return false;
        }else{
            readImageselected(this);
            $('.custom-file-w').html(fileName);
        }
    });

    $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param) 
    }, 'File size must be less than 1mb');    

    $("form#frm_websetup").validate({
        rules: {
            web_icon: {
                extension: "jpeg|jpg|png",
                filesize : 1048576,
                required : true,
                // required :true
            },
            m_web_icon: {
                extension: "jpeg|jpg|png",
                filesize : 1048576,
                required : true,
                // required :true
            },
            web_name: { 
                required : true,
            }
        },
        messages: {
            web_icon :{
                extension: "Allowed File Types Are .jpg, png. jpeg",
                required : "Please Choose Your Web Icon"
            },
            m_web_icon :{
                extension: "Allowed File Types Are .jpg, png. jpeg",
                required : "Please Choose Your Mobile Web Icon"
            },
            web_name :{
                required : "Please Enter Your Web page name",
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
                url     : form.action,
                type    : form.method,
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){ 
                    webBlock2("Applying Changes ...");
                },
                success: function(response) {
  
                    $.unblockUI();
                    if(response[0] == "success") {
                        responseTosubmit(response[0], response[1], response[2], "frm_websetup", "no table", "no modal");
                        $(".custom-file-label").html('');
                        setTimeout(function(){ location.reload(); }, 3000);
                    }else{
                        responseTosubmit(response[0], response[1], response[2], "no form", "no table", "no modal");
                    }

                }            
            });
        }
    });




    /* =================================  MAILER  ======================================== */


    $("form#frm_mailer").validate({
        rules: {
            mailer_add: {
                required : true,
            },
            mailer_pass: { 
                required : true,
            }
        },
        messages: {
            mailer_add :{
                required : "Please Input Mailer Email Address"
            },
            mailer_pass :{
                required : "Please Input Mailer Password"
            }
        },
        errorElement: 'span',
            errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
            highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
            unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            formData.append("update_mailer", "");
            $.ajax({
                url     : form.action,
                type    : form.method,
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){ 
                    webBlock2("Applying Changes ...");
                },
                success: function(response) {
                    responseTosubmit(response[0], response[1], response[2], "0", "0", "0");
                }
            });
        }
    });

    $("form#frm_testmailer").validate({
        rules: {
            txt_2_0: {
                required : true,
            },
        },
        messages: {
            txt_2_0 :{
                required : "Please Input Email Address to test"
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
            formData.append("test_mailer", "");
            $.ajax({
                url     : form.action,
                type    : form.method,
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){ 
                    webBlock2("Testing ...");
                },
                success: function(response) {
                    responseTosubmit(response[0], response[1], response[2], "frm_testmailer", "0", "mdl_test_mail");
                }
            });
        }
    });
});


function readTextFiles(file) {
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, false);
    var result = new Array();
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                var allText = rawFile.responseText;
                // var allText = rawFile.responseText.slice(1, rawFile.responseText.indexOf("\n"));
                return allText;
            }
        }
    }
    rawFile.send(null);


    result[0] = rawFile.responseText.split("\n")[0].split("=").pop().replace(/(\r\n|\n|\r)/gm, "");
    result[1] = rawFile.responseText.split("\n")[1].split("=").pop();
    // result[1] = rawFile.responseText.split("\n")[1];
    // result[2] = rawFile.responseText.split("\n")[2];
    return result;
}
// 