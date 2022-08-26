$(function(){
    var tbl_attendancedetails = "";
    pageLocation("", "li_logs", "Logs");

    // $('.d-nones').remove();
    // $( "#btn_add_asset" ).click(function() {
    //     $('#mdl_add').modal('show');
    // });

    var returned_global_min = "";
    var returned_global_max = "";
    
    $(".sel_1").select2({
        placeholder: "Select Type",
        allowClear: true,
        width: '100%'
    });
    $(".sel_2").select2({
        placeholder: "Select Action",
        allowClear: true,
        width: '100%'
    });
    $(".sel_3").select2({
        placeholder: "Select ID",
        allowClear: true,
        width: '100%'
    });
    
    $(".sel_4").select2({
        placeholder: "Select Action By",
        allowClear: true,
        width: '100%'
    });

    

    $("#text_5").daterangepicker({
        "timePicker": true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        // "timePicker24Hour": true,
        showDropdowns: true,
        autoUpdateInput: false,
        cancelClass: "btn-danger",  
        opens: 'right',
            locale: {
                format: 'YYYY-MM-DD hh:mm A',
                cancelLabel: 'Clear'
            },
        },
    );

    $('#text_5').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD hh:mm A') + ' - ' + picker.endDate.format('YYYY-MM-DD hh:mm A'));
        returned_global_min = picker.startDate.format('YYYY-MM-DD hh:mm A');
        returned_global_max = picker.endDate.format('YYYY-MM-DD hh:mm A');
        tbl_attendance.draw();
    });
    $('#text_5').on('cancel.daterangepicker', function(ev, picker) {
        returned_global_min = "";
        returned_global_max = "";
        tbl_attendance.draw();
        $('#text_5').val('');
    });


    // $('#tbl_logs').DataTable( {
    //     // "scrollY":        "200px",
    //     // "scrollCollapse": true,
    //     // "paging":         false,
    //     'ajax': {
    //         'method' : 'POST',
    //         'url'    :'../actions/datatables_logs.php',
    //         'data'   : {
    //                         form: 'logs_mainte_asset_name'
    //                     },
    //         'deferRender': true,
    //     },
    //     'columnDefs': [
    //         { "visible": false,  "searchable": false, "targets": 0 },
    //     ],
    //     'columns': [
    //         { data: 'array0' },
    //         // {   
    //         //     "className":      'details-control',
    //         //     "orderable":      false,
    //         //     "data":           null,
    //         //     "defaultContent": '',
    //         // },
    //         { data: 'array1' },
    //         { data: 'array2' },
    //         { data: 'array3' },
    //         { data: 'array4' },
            
    //     ],
    //     'order'  :   [[ 0, 'desc']],
    // });


    // $( "#link_log" ).click(function() {
    //     $('#mdl_log').modal('show');
    //     $('#tbl_logs').DataTable().ajax.reload();
    // });
    // $( "#btn_reload_log" ).click(function() {
    //     $('#tbl_logs').DataTable().ajax.reload();
    // });
    

    var tbl_attendance = $('#tbl_attendancedetails').DataTable( {
        "searchHighlight"   : true,
        dom: 'Bfrtip',
            buttons: [
    
                {
                    extend: 'copyHtml5',
                    text: 'Copy',
                    title: 'Asset Issuance',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Export To Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Generate PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
    
                },
                'colvis'
            ],
        'ajax': {
            'method' : 'POST',
            'url'    :'logs_act.php',
            'data'   : {
                            tbl_attendancedetails
                        },
            // 'deferRender': true,
        },
        // 'columnDefs': [
        //     { "visible": false,  "searchable": false, "targets": 0 },
        // ],
        'columns': [
            { data: 'row1' , "visible" : false},
            { data: 'row2' },
            { data: 'row3' },
            { data: 'row4' },
            { data: 'row5' },
            { data: 'row6' },
            { data: 'row7' }
        ],
        'order'  :   [[ 0, 'desc']],
        initComplete: function () {
            this.api().columns('.th_type').every( function () {
                var column = this;
                var select = $('#text_1').addClass('hidden')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
            this.api().columns('.th_action').every( function () {
                var column = this;
                var select = $('#text_2').addClass('hidden')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
            this.api().columns('.th_id').every( function () {
                var column = this;
                var select = $('#text_3').addClass('hidden')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
            this.api().columns('.th_actionby').every( function () {
                var column = this;
                var select = $('#text_4').addClass('hidden')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );



            
        }
    });
    var detailRowsreturned = [];   
    $('#tbl_attendancedetails tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tbl_attendance.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRowsreturned );
        if ( row.child.isShown() ) {
            tr.removeClass( 'shown' );
            row.child.hide();
            detailRowsreturned.splice( idx, 1 );
        }
        else {
            if ( tbl_attendance.row( '.shown' ).length ) {
                $('.details-control', tbl_attendance.row( '.shown' ).node()).click();
            }
            tr.addClass( 'shown' );
            row.child( formatreturned( row.data() ) ).show();
            if ( idx === -1 ) {
                detailRowsreturned.push( tr.attr('id') );
            }
        }
    
    } );
    tbl_attendance.on( 'draw', function () {
        $.each( detailRowsreturned, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
        if ( settings.nTable.id !== 'tbl_attendancedetails' ) {
            return true;
        }else{
                var min_date_returned2 = returned_global_min;
                var min_returned2 = new Date(min_date_returned2);
                var max_date_returned2 = returned_global_max;
                var max_returned2 = new Date(max_date_returned2);
                var startDate_returned2 = new Date(data[6]);
    
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
  

    /* ADD */
    // $("form#frm_mainte_addevent").validate({
    //     rules: {
    //         text_1: {
    //             required : true
    //         },
    //         text_2: {
    //             required : true
    //         },
    //         text_3: {
    //             required : true
    //         },
    //     },
    //     messages: {
    //         text_1: {
    //             required    : "Event Name Is Required"
    //         },
    //         text_2: {
    //             required    : "Start Time Is Required"
    //         },
    //         text_3: {
    //             required    : "End Time Is Required"
    //         },
    //     },
    //         errorElement: 'span',
    //         errorPlacement: function (error, element) {
    //         error.addClass('invalid-feedback');
    //         element.closest('.col-md-9').append(error);
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
    //                 url         :   form.action,
    //                 type        :   form.method,
    //                 data        :   formData,
    //                 cache       :   false,
    //                 contentType :   false,
    //                 processData :   false,
    //                 dataType    :   "json",
    //             beforeSend: function(){ 
    //                 webBlock2("Adding Event ...");
    //             },
    //             success: function(response) {
    //                 responseTosubmit(response[0], response[1], response[2], "frm_mainte_addevent", "tbl_events", "mdl_add");
    //             }            
    //         });
    //     }
    // });
    /* EDIT */
    // $(document).on('click', '.updateDetails', function(e){
    //     e.preventDefault();

    //     let id          =   $(this).data('id');
    //     let name        =   $(this).data('name');
    //     let status      =   $(this).data('status');
    //     removEonStatus("btn_status","mdl_edit",status);

    //     $('#mdl_edit').modal('show');
    //     $('#text_1_edit').val(name);
    //     $('#input_mainteassetname_id').val(id);
        

    //     $("form#frm_mainte_asset_name_edit").validate({
    //         rules: {
    //             text_1_edit: {
    //                 required : true
    //             },
    //         },
    //         messages: { 
    //             text_1_edit: {
    //                 required    : "Attribute Is Required"
    //             },
    //         },
    //             errorElement: 'span',
    //             errorPlacement: function (error, element) {
    //             error.addClass('invalid-feedback');
    //             element.closest('.col-md-9').append(error);
    //             },
    //                 highlight: function (element, errorClass, validClass) {
    //                 $(element).addClass('is-invalid');
    //             },
    //                 unhighlight: function (element, errorClass, validClass) {
    //                 $(element).removeClass('is-invalid');
    //             },
    //             submitHandler: function(form) {

    //                 var formData = new FormData(form);
    //                 $.ajax({
    //                     url         :   form.action,
    //                     type        :   form.method,
    //                     data        :   formData,
    //                     cache       :   false,
    //                     contentType :   false,
    //                     processData :   false,
    //                     dataType    :   "json",
    //                 beforeSend: function(){ 
    //                     $.blockUI({ message: '<br><div class="spinner-border text-secondary" role="status">  <span class="sr-only">Loading...</span> </div><h1> Updating ...</h1>' });
    //                 }, 
    //                 success: function(response) {
    //                     $.unblockUI();
    //                     if(response[0] == 1) {
    //                         toastrConfirmation(response[2], response[1], "success");
    //                         $('#frm_mainte_asset_name_edit').trigger("reset");
    //                         $('#tbl_asset,#tbl_logs').DataTable().ajax.reload(null,false);
    //                         $('#mdl_edit').modal('hide');
    //                     }else{
    //                         toastrConfirmation(response[2], response[1], "error");
    //                     }
    //                 }            
    //             });
    //         }
    //     });
    // });
    /* DELETE */
    // $(document).on('click', '.deleteDetails', function(e){
    //     e.preventDefault();

    //     let id      =   $(this).data('id');
    //     let name    =   $(this).data('name');
    //     let status    =   $(this).data('status');
    //     removEonStatus("btn_status","mdl_edit",status);
    //     let input_mainteassetname_deLete = "";


    //     Swal.fire({
    //         title: `Are you sure you want to Delete This Asset Name? `,
    //         html:
    //         `<h1 class="text-danger font-weight-bold"> ${name}</h1>`,
    //         text: "You won't be able to revert this!",
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: `Yes Delete It! `,
    //         confirmButtonClass: 'btn btn-primary',
    //         cancelButtonClass: 'btn btn-danger ml-1',
    //         buttonsStyling: false,
    //     }).then(function (result) {
    //         if (result.value) {
    //             $.ajax({
    //                 method  : "POST",
    //                 url     : "action_maintenance.php",
    //                 dataType: "JSON",
    //                 data    : {
    //                     input_mainteassetname_deLete,id
    //                 },
    //                 beforeSend: function(){ 
    //                     $.blockUI({ message: '<br><div class="spinner-border text-secondary" role="status">  <span class="sr-only">Loading...</span> </div><h1> Deleting Please Wait ...</h1>' });
    //                 },
    //                 success :function (response){
    //                     $.unblockUI();
    //                     if (response[0] == 1) {
    //                         toastrConfirmation(response[2], response[1], "success");
    //                         $('#tbl_asset,#tbl_logs').DataTable().ajax.reload(null, false);
    //                     }else{
    //                         toastrConfirmation(response[2], response[1], "error");
    //                         $('#tbl_asset,#tbl_logs').DataTable().ajax.reload(null, false);
    //                     }
    //                 }
    //             });
    //         }
    //     })

    // });
});

