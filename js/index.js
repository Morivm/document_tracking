$(function(){
    // $('.alert').hide();
    $('form#frm_login').validate({
        rules: {
            txt_username: {
                required: true,
            },
            txt_password: {
                required: true,
            },
        },
        messages: {
            txt_username: {
                required    : "Please Enter your username",
            },
            txt_password    : {
                required    : "Please Enter your Password",
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

            $.ajax({
                url     : form.action,
				type    : form.method,
				data    : $(form).serialize(),
                dataType: "json",
                beforeSend : function() {
                    $(".login-box *").prop('disabled',true);
                    $("#btn_login").html("Authenticating...");
                },
                success: function(response) {
                    $(".login-box *").prop('disabled',false);
                    $(".alertSet").removeClass('hidden');

                    if(response[0] == "success"){
                        $('#al_message').text(`${response[1]} ${response[2]}`).css('color', 'white');
                        $('.alert').show().addClass('alert-success').removeClass('alert-danger');
                        $("#btn_login").html(response[2]);
                        location.reload();
                    }else{
                        $('#al_message').text(`${response[1]} ${response[2]}`).css('color', 'white');
                        $('.alert').show().addClass('alert-danger').removeClass('alert-success');
                        $("#btn_login").html("Login");
                    }
                }
            });
        
        }
    });

    // readTextFile("img/resources/webname.txt","wb_name");

    // $.ajax({
    //     url:'img/resources/webicon.png',
    //     type:'HEAD',
    //     error: function()
    //     {
    //         $(".wb_image").attr("src", "img/resources/no_asset_img.png");
    //     },
    //     success: function()
    //     {
    //         $(".").attr("src", "img/resources/webicon.png");
    //     }
    // });
    // function readTextFile(file,webnameClass) {
    //     var rawFile = new XMLHttpRequest();
    //     rawFile.open("GET", file, false);
    //     rawFile.onreadystatechange = function ()
    //     {
    //         if(rawFile.readyState === 4)
    //         {
    //             if(rawFile.status === 200 || rawFile.status == 0)
    //             {
    //                 var allText = rawFile.responseText;
    //                 $(`.${webnameClass}`).text(allText);
    //             }
    //         }
    //     }
    //     rawFile.send(null);
    // }
})