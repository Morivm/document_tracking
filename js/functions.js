
readTextFile("../img/resources/webname.txt","wb_name");

$.ajax({
    url:'../img/resources/webicon.png',
    type:'HEAD',
    error: function()
    {
        $(".wb_image").attr("src", "../img/resources/no_asset_img.png");
        $(".shortcut_icon").attr("href", "../img/resources/no_asset_img.png");
    },
    success: function()
    {
        $(".wb_image").attr("src", "../img/resources/webicon.png");
        $(".shortcut_icon").attr("href", "../img/resources/webicon.png");
    }
});
function readTextFile(file,webnameClass) {
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, false);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                var allText = rawFile.responseText;
                $(`.${webnameClass}`).text(allText);
                // alert(allText);
            }
        }
    }
    rawFile.send(null);
}



function webBlock(message) {
    $.blockUI({ 
        baseZ: 2000,
        message : message,
        css: { 
        border: 'none', 
        padding: '25px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } }); 
}
function webBlock2(message) {
    $.blockUI({ 
        baseZ: 2000,
        message: `<h2><img src="../img/web/busy.gif" width="70" />${message} </h2>`,
        css: { 
        border: 'none', 
        padding: '10px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } }); 
}
function imgError()
{
    return 'The image could not be loaded.';
}
function responseTosubmit2(str_successmsg, str_body, str_title) {
    $.unblockUI();
    closePageLoader();
    if(str_successmsg == "success") {
        toastr.success(str_title, str_body, { "closeButton": true });
    }else if(str_successmsg == "error") {
        toastr.error(str_title, str_body, { "closeButton": true });
    }else {
        toastr.warning(str_title, str_body, { "closeButton": true });
    }
}
function responseTosubmit(str_successmsg, str_body, str_title, frm_class, dtclass, modalclass) {
    $.unblockUI();
    closePageLoader();
    if(str_successmsg == "success") {
        toastr.success(str_title, str_body, { "closeButton": true });
        $(`.${frm_class}`).trigger('reset');
        // $(`.select2`).val('').trigger('change');
        $(`.select2`).val('').trigger('change');
        $(`.${modalclass}`).modal('hide');
        $(`.${dtclass}`).DataTable().ajax.reload(null,false);
    }else if(str_successmsg == "error") {
        toastr.error(str_title, str_body, { "closeButton": true });
    }else {
        toastr.warning(str_title, str_body, { "closeButton": true });
    }
}
function responseTosubmitcustomselect(str_successmsg, str_body, str_title, frm_class, dtclass, modalclass) {
    $.unblockUI();
    if(str_successmsg == "success") {
        toastr.success(str_title, str_body, { "closeButton": true });
        $(`.${frm_class}`).trigger('reset');
        // $(`.select2`).val('').trigger('change');
        $(`.select2-custom`).val('').trigger('change');
        $(`.${modalclass}`).modal('hide');
        $(`.${dtclass}`).DataTable().ajax.reload(null,false);
    }else if(str_successmsg == "error") {
        toastr.error(str_title, str_body, { "closeButton": true });
    }else {
        toastr.warning(str_title, str_body, { "closeButton": true });
    }
}
function responseTosubmitnOselect(str_successmsg, str_body, str_title, frm_class, dtclass, modalclass) {
    $.unblockUI();
    if(str_successmsg == "success") {
        toastr.success(str_title, str_body, { "closeButton": true });
        $(`.${frm_class}`).trigger('reset');
        $(`.${modalclass}`).modal('hide');
        $(`.${dtclass}`).DataTable().ajax.reload(null,false);
    }else if(str_successmsg == "error") {
        toastr.error(str_title, str_body, { "closeButton": true });
    }else {
        toastr.warning(str_title, str_body, { "closeButton": true });
    }

}
function getDataSelect2(sel_class,sel_placeholder,sel_forname){
    $(`.${sel_class}`).select2({
        placeholder: sel_placeholder,
        allowClear: true,
        width: '100%'
    });
    $.ajax({
        type    : 'POST',
        url     : `../modules/select2.php`,
        dataType: 'json',
        data    : {
                    form: sel_forname
        },
        beforeSend : function() {
            $(`.${sel_class}`).html("");

        },
        success:function(data){
            $.each(data, function (key, value) {
                var id = value[0];
                var name = value[1];
                $(`.${sel_class}`).append(`<option value=''></option> <option value='${id}'>${name}</option>`);
            });
        }
    });
}

let closePageLoader = () => {
    document.getElementById("cover-spin").style.display = 'none';
}
let openPageLoader = () => {
    document.getElementById("cover-spin").style.display = 'block';
}

function getUserphoto(userphoto,photo_ext){ 
    if (userphoto == "") {
        return "../img/users/noimage.png"
    }else{
        return `../img/users/${userphoto}.${photo_ext}`;
    }
}
function getWebphoto(webphoto){
    if (webphoto == "") {
        return "../img/web/no_image.png"
    }else{
        return `../img/web/${webphoto}`;
    }
}

function readImageselected(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.prev_image,.previewimg,#previewimg2').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function readImageselected2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.prev_image_m').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function pageLocation(li_parent, li_child, li_webtitle) {
    if (!li_parent == null || !li_parent=='') {
        $(`#${li_parent}`).addClass('has-sub menu-collapsed-open open');
    }
    if (!li_child == null || !li_child=='') {
        $(`#${li_child}`).addClass('active');
    }
    if (!li_webtitle == null || !li_webtitle=='') {
        $('.webTitle').text(`${li_webtitle}`);
    }
}

function hideComponents(modulesdb) {
    var val= modulesdb;
    var array = val.split(' ');
    
    if(modulesdb.length == 1) {
    }else {
        for (i=1;i<array.length;i++){
            $(`.${array[i]}`).remove();
            $(`.${array[i]}`).prop( "checked", false );
        }
    }
}
function checkckinmodules(modulesdb) {
    var val= modulesdb;
    var array = val.split(' ');
    if(modulesdb.length == 1) {
    }else {
        for (i=1;i<array.length;i++){
            $(`.${array[i]}`).prop( "checked", false );
            // $(`.${array[i]}`).prop( "checked", false );
        }
    }
}

function makeUngiquid(length,urlsss) {

    var d                = new Date();
    var currentYear      = d.getFullYear();
    var currentDate      = ("0" + d.getDate()).slice(-2);
    var currentMonth     = ("0" + (d.getMonth() + 1)).slice(-2);
    var currentSec       = ("0" +d.getSeconds()).slice(-2); 
    var currentMin       = ("0" +d.getMinutes()).slice(-2);
    var currentHour      = ("0" +d.getHours()).slice(-2);
    
    var str = length+urlsss+currentYear+currentDate+currentMonth+currentSec+currentMin+currentHour;

    return str;
}
function webBlocker(message){
    $.blockUI({ 
        message: `<h2><img src="../img/web/busy.gif" width="80" />${message} </h2>`,css: { 
        border: 'none', 
        // padding: '25px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } }); 
}
function EmptyStr(value,str_textid) {
    if (value) {
        $(`#${str_textid}`).text(value).removeClass('text-danger');
    }else{
        $(`#${str_textid}`).text("No Details").addClass('text-danger');
    }
}
function date_time2(){
    var d = new Date();
    var time = d.getHours() + ":" + d.getMinutes() + ":" + pad(d.getSeconds());

    var dateObj   = new Date();
    var month     = dateObj.getMonth()+1; //months from 1-12
    var day       = dateObj.getDate();
    var year      = dateObj.getFullYear();

    var newdate   = year + "-" + pad(month) + "-" + pad(day);
    var date_time = newdate+" "+time;  

    return date_time;
}
