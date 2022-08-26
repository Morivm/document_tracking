var globalusertype ="";
var sweetglobalusertype ="";
$(function(){

    // nowLogin();
    // websetup();
    $('[data-toggle="tooltip"]').tooltip();
    $(".log_photo").on("error", function(){
        $(this).attr('src', '../img/users/noimage.png');
    });
    
    
    $(document).on('click', '.navPauseDoc', function(e){
        e.preventDefault();
        
        getDataSelect2("sel_pause","Sel Barcode","select_barcodes_pause");
        $("#mdl_pause").modal("show");
    });

    $(document).on('click', '.navPlayDoc', function(e){
        e.preventDefault();
        getDataSelect2("sel_play","Sel Barcode","select_barcodes_play");
        $("#mdl_play").modal("show");

    });
    $("#li_queshelp").click(function() {
        //Do stuff when clicked
        $("#mdl_view_tut").modal("show");
    });



    // $("form#frm_pause").validate({
    //     rules: {
    //         pause_txt_1: {
    //             required : true
    //         },
    //         pause_txt_2: {
    //             required : true
    //         }
    //     },
    //     messages: {
    //         pause_txt_1: {
    //             required : "Batcode is Required"
    //         },
    //         pause_txt_2: {
    //             required : "Remarks is Required"
    //         }
    //     },
    //     errorElement: 'span',
    //         errorPlacement: function (error, element) {
    //         error.addClass('invalid-feedback');
    //         element.closest('.col-md-9').append(error);
    //     },
    //         highlight: function (element, errorClass, validClass) {
    //         $(element).addClass('is-invalid');
    //     },
    //         unhighlight: function (element, errorClass, validClass) {
    //         $(element).removeClass('is-invalid');
    //     },
    //     submitHandler: function(form) {
    //         var bcodee = $('#pause_txt_1').find(":selected").text();
    //         var formData = new FormData(form);
    //         formData.append("pause_doc", "");
    //         formData.append("barcode", bcodee);
    //         $.ajax({
    //             url     :   form.action,
    //             type    :   form.method,
    //             data    :   formData,
    //             cache       :   false,
    //             contentType :   false,
    //             processData :   false,
    //             dataType    :   "json",
    //             beforeSend: function(){ 
    //                 webBlock2("Pausing Document...");
    //             },
    //             success: function(response) {
    //                 responseTosubmit(response[0], response[1], response[2], "frm_pause", "tbl1", "mdl_pause");
    //             }            
    //         });
    //     }
    // });

    // $("form#frm_play").validate({
    //     rules: {
    //         play_txt_1: {
    //             required : true
    //         }
    //     },
    //     messages: {
    //         pause_txt_1: {
    //             required : "Batcode is Required"
    //         }
    //     },
    //     errorElement: 'span',
    //         errorPlacement: function (error, element) {
    //         error.addClass('invalid-feedback');
    //         element.closest('.col-md-9').append(error);
    //     },
    //         highlight: function (element, errorClass, validClass) {
    //         $(element).addClass('is-invalid');
    //     },
    //         unhighlight: function (element, errorClass, validClass) {
    //         $(element).removeClass('is-invalid');
    //     },
    //     submitHandler: function(form) {
    //         var formData = new FormData(form);
    //         formData.append("play_doc", "");
    //         $.ajax({
    //             url     :   form.action,
    //             type    :   form.method,
    //             data    :   formData,
    //             cache       :   false,
    //             contentType :   false,
    //             processData :   false,
    //             dataType    :   "json",
    //             beforeSend: function(){ 
    //                 webBlock2("Pausing Document...");
    //             },
    //             success: function(response) {
    //                 responseTosubmit(response[0], response[1], response[2], "frm_play", "tbl1", "mdl_play");
    //             }            
    //         });
    //     }
    // });


//...........................................................................................................
//............hhhh...........................................................................................
//............hhhh...........................................................................................
//............hhhh...........................................................................................
//...cccccc...hhhhhhhh....aaaaaa...nnnnnnnn....ggggggggg..eeeeee..epppppppp....aaaaaa...sssssss...sssssss....
//..cccccccc..hhhhhhhhh..aaaaaaaa..nnnnnnnnn..gggggggggg.eeeeeeee.eppppppppp..aaaaaaaa.assssssss.sssssssss...
//.ccccc.cccc.hhhh.hhhhhhaaa.aaaaa.nnnn.nnnnnngggg.ggggggeee.eeee.epppp.ppppppaaa.aaaaaasss.ssss.ssss.ssss...
//.cccc..ccc..hhhh..hhhh....aaaaaa.nnnn..nnnnnggg...gggggeee..eeeeeppp...pppp....aaaaaaassss.....sssss.......
//.cccc.......hhhh..hhhh.aaaaaaaaa.nnnn..nnnnnggg...gggggeeeeeeeeeeppp...pppp.aaaaaaaaa.ssssss....ssssss.....
//.cccc.......hhhh..hhhhhaaaaaaaaa.nnnn..nnnnnggg...gggggeeeeeeeeeeppp...pppppaaaaaaaaa..sssssss...sssssss...
//.cccc..ccc..hhhh..hhhhhaaa.aaaaa.nnnn..nnnnnggg...gggggeee......eppp...pppppaaa.aaaaa......ssss......ssss..
//.ccccc.cccc.hhhh..hhhhhaaa.aaaaa.nnnn..nnnnngggg.ggggggeee..eeeeepppp.ppppppaaa.aaaaaasss..ssssssss..ssss..
//..ccccccccc.hhhh..hhhhhaaaaaaaaa.nnnn..nnnn.gggggggggg.eeeeeeee.eppppppppp.paaaaaaaaaassssssss.sssssssss...
//...cccccc...hhhh..hhhh.aaaaaaaaa.nnnn..nnnn..ggggggggg..eeeeee..epppppppp...aaaaaaaaa..ssssss....ssssss....
//..................................................gggg..........eppp.......................................
//...........................................ngggg.gggg...........eppp.......................................
//............................................ggggggggg...........eppp.......................................
//.............................................ggggggg............eppp.......................................
//...........................................................................................................
//     $("form#frm_changepassword").validate({
//         rules: {
//             log_new_pass: {
//                 required : true,
//                 minlength: 5
//             },
//             log_retype_pass: {
//                 required : true,
//                 equalTo: "#log_new_pass"
//             },
//             log_old_pass: {
//                 required : true,
//             },
//         },
//         messages: {
//             log_new_pass: {
//                 required : "New Password is Required",
//                 minlength: "Please type at least 6 characters"
//             },
//             log_retype_pass: {
//                 required : "Please Re-type your New password",
//                 equalTo  : "Please Re-type Your Password Correctly"
//             },
//             log_old_pass: {
//                 required : "Old Password is Required"
//             },
//         },
//         errorElement: 'span',
//             errorPlacement: function (error, element) {
//             error.addClass('invalid-feedback');
//             element.closest('.col-md-9').append(error);
//         },
//             highlight: function (element, errorClass, validClass) {
//             $(element).addClass('is-invalid');
//         },
//             unhighlight: function (element, errorClass, validClass) {
//             $(element).removeClass('is-invalid');
//         },
//         submitHandler: function(form) {

//             var formData = new FormData(form);
//             $.ajax({
//                 url     :   form.action,
//                 type    :   form.method,
//                 data    :   formData,
//                 cache       :   false,
//                 contentType :   false,
//                 processData :   false,
//                 dataType    :   "json",
//                 beforeSend: function(){ 
//                     $.blockUI({ message: '<h1> Changing Your Password...</h1>' });
//                 },
//                 success: function(response) {
//                     $.unblockUI();
//                     if (response[0] == 1) {
//                         $('#frm_changepassword').trigger('reset');
//                         $('#mdl_changepass').modal('hide');
//                         toastrConfirmation(response[2], response[1], "success");
//                     }else{
//                         toastrConfirmation(response[2], response[1], "error");
//                     }
//                 }            
//             });
//         }
//     });
//........................................................
//.llll..............................................ttt..
//.llll.............................................tttt..
//.llll.............................................tttt..
//.llll...oooooo....ggggggggg...oooooo..ouuu..uuuuuutttt..
//.llll.loooooooo..gggggggggg.ooooooooo.ouuu..uuuuuutttt..
//.llll.looo.oooooogggg.ggggg.oooo.oooooouuu..uuuuu.tttt..
//.lllllloo...oooooggg...gggggooo...ooooouuu..uuuuu.tttt..
//.lllllloo...oooooggg...gggggooo...ooooouuu..uuuuu.tttt..
//.lllllloo...oooooggg...gggggooo...ooooouuu..uuuuu.tttt..
//.lllllloo...oooooggg...gggggooo...ooooouuu..uuuuu.tttt..
//.llll.looo.oooooogggg.ggggg.oooo.oooooouuuu.uuuuu.tttt..
//.llll.loooooooo..gggggggggg.ooooooooo..uuuuuuuuuu.tttt..
//.llll...oooooo....ggggggggg...oooooo....uuuuuuuuu.tttt..
//.......................gggg.............................
//................ogggg.gggg..............................
//.................ggggggggg..............................
//..................ggggggg...............................
//........................................................
    $(".btn_logout").click(function() {
        $.ajax({
            type    : 'POST',
            url     : 'logout.php',
            success: function(response){
                location.reload();
            }
        });
    });
});

// function nowLogin() { 
//     let checklogined = "";    
//     $.ajax({
//         type    : 'POST',
//         url     : '../actions/logined_info.php',
//         dataType:   "JSON",
//         data    : {
//             checklogined
//         },
//         beforeSend : function () {
//             webBlock2("Please Wait")
//         },
//         success: function(response){
//             $.unblockUI();
//             $.each(response, function (key, value) {
//                 let lastname    = value[0];
//                 let firstname   = value[1];
//                 let middlename  = value[2];
//                 let suffix      = value[3];
//                 let photo       = value[4];
//                 let photo_ext   = getUserphoto(photo,value[5]);
//                 let modules     = value[6];
//                 let uType       = value[7];
//                 let usertype    = hidefromUser(value[7]);
//                 globalusertype  = uType;
//                 sweetglobalusertype = uType;
//                 hideComponents(modules);
//                 $('.log_lnfn').text(`${lastname} , ${firstname}`);
//                 $('#log_photo').attr('src', `${photo_ext}`);                
//             });	
            
//         }
//     });

// }
// function websetup() {
//     let checkWebsetup = "";
//     $.ajax({
//         type    : 'POST',
//         url     : '../actions/logined_info.php',
//         dataType:   "JSON",
//         data    : {
//             checkWebsetup
//         },
//         success: function(response){

//             $.unblockUI();
//             $.each(response, function (key, value) {
//                 let image_name     =  getWebphoto(value[0]);
//                 let web_name       =  value[1];
//                 $('.prev_image, .brand-logo').attr('src', `${image_name}`);
//                 $('.brand-text').text(web_name);
//                 $('#web_name').val(web_name);
//                 $('.shortcut_icon').attr('href', `${image_name}`);
                
//             });	
//         }
//     });
// }

// $.ajax({
//     url:'http://www.example.com/somefile.ext',
//     type:'HEAD',
//     error: function()
//     {
//         //file not exists
//     },
//     success: function()
//     {
//         //file exists
//     }
// });
