<div class="sidenav-overlay" style="touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div>
    <div class="drag-target" style="touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div>

 
 <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; <?php echo $web_copyright_year ?><a class="text-bold-800 grey darken-2" href="<?php echo $web_company_site ?>" target="_blank"> <?php echo $web_company ?></a></span><span class="float-md-right d-none d-lg-block"><?php echo $web_version  ?></span></span></p>
    
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->

    <script src="../app-assets/vendors/js/vendors.min.js"></script>
    <script src="../app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../includes/scripts.js"></script>
    <script src="../app-assets/daterange/moment.js"></script>
    <script src="../app-assets/daterange/daterangepicker.min.js"></script>


    <script src="../app-assets/js/scripts/extensions/block-ui.js"></script>
    <script src="../app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="../app-assets/vendors/js/extensions/polyfill.min.js"></script>

    <script src="../app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="../app-assets/datatable_prints/dataTables.buttons.min.js"></script>
    <script src="../app-assets/datatable_prints/jszip.min.js"></script>
    <script src="../app-assets/datatable_prints/pdfmake.min.js"></script>
    <script src="../app-assets/datatable_prints/vfs_fonts.js"></script>
    <script src="../app-assets/datatable_prints/buttons.html5.min.js"></script>
    <script src="../app-assets/datatable_prints/buttons.print.min.js"></script>
    <script src="../app-assets/datatable_prints/colVis.min.js"></script>

    <script src="../app-assets/jquery-validation/jquery.validate.js"></script>
    <script src="../app-assets/jquery-validation/additional-methods.min.js"></script> 
    <script src="../app-assets/jqueryDatatable_checkbox/datatable_checkbox.js"></script> 

    <script src="../app-assets/jqueryDatatable_checkbox/searchHighlight.min.js"></script> 
    <script src="../app-assets/jqueryDatatable_checkbox/jquery.highlight.js"></script> 

 
    <script src="../app-assets/vendors/js/extensions/toastr.min.js"></script>
    <script src="../app-assets/select2/js/select2.min.js"></script>
    <script src="../app-assets/vendors/js/forms/icheck/icheck.min.js"></script>

        
    <script src="../app-assets/js/core/app-menu.js"></script>
    <script src="../app-assets/js/core/app.js"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script src="../app-assets/vendors/js/charts/chart.min.js"></script>
    <script src="../app-assets/vendors/js/charts/raphael-min.js"></script>
    <script src="../app-assets/vendors/js/charts/morris.min.js"></script>
    <script src="../app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="../app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js"></script>
    <script src="../app-assets/data/jvector/visitor-data.js"></script>
    <script src="../app-assets/bootstrap-toggle/toggle.min.js"></script>
    <script>
        var phprole = "<?php echo $userrole?>";

        if(phprole != "SUPERADMIN") {
            $(".modforadm").remove();
        }else{
            
        }
    </script>
    


    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->

    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->



    <!-- <script src="../app-assets/js/scripts/tables/datatables/datatable-basic.js"></script> -->
    <!-- END: Page JS-->
