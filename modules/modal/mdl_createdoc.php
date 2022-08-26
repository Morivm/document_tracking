
<div class="modal fade text-left mdl_create" id="mdl_create" tabindex="-1" role="dialog" aria-labelledby="myModalmdl_create" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mdl1title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="frm_doccreate" class="form form-horizontal frm_doccreate" method="post" action="../actions/act_create_document.php" enctype="multipart/form-data" autocomplete="off">
                        <div class="form-body">
                            <input type="hidden" name="create_doc" id="create_doc">
                    
                                    <div class="form-group row"> <!-- KUNG ANONG DEPARTMENT NITONG NAKALOGIN -->
                                        <label class="col-md-3 label-control" for="text_1">Department</label>
                                        <div class="col-md-9 mx-auto">
                                            <label id="text_1"><?php echo $userdeptname?></label>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <!-- SYSTEM GENERATED -->
                                        <label class="col-md-3 label-control" for="text_2">Barcode</label>
                                        <div class="col-md-9 mx-auto">
                                            <input type="text" class="form-control capitalizefletter" name="text_2" id="text_2" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="form-group row"> <!-- MGA AVAILABLE NA DOCUMENT BASE ON DEPARTMENT NG NAKALOGIN -->
                                        <label class="col-md-3 label-control" for="text_3">Document Type</label>
                                        <div class="col-md-9 mx-auto">
                                            <select class="form-control sel_doctype select2" id="text_3" name="text_3">
                                                <option value="" selected>- Select -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row custom-doctype hidden"> <!-- KAPAG WLA SO DOCTYPE -->
                                        <label class="col-md-3 label-control" for="text3_0"></label>
                                        <div class="col-md-9 mx-auto">
                                            <input type="text" class="form-control capitalizefletter" name="text3_0" id="text3_0" placeholder="Enter Doctype">
                                        </div>
                                    </div>


                                    <div class="form-group row"> <!-- RANDOM STRING -->
                                        <label class="col-md-3 label-control" for="text_4">Document Title</label>
                                        <div class="col-md-9 mx-auto">
                                            <input type="text" class="form-control" name="text_4" id="text_4">
                                        </div>
                                    </div>
                                    <div class="form-group row"> <!-- KUNG SINO ANG MGA TAONG NASA DEPARTMENT NA KAPAREHAS NG NAKALOGIN -->
                                        <label class="col-md-3 label-control" for="text_6">Process By</label>
                                        <div class="col-md-9 mx-auto">
                                            <input type="text" class="form-control" name="text_6" id="text_6" readonly>
                                            <!-- <select class="form-control sel_processby select2" id="text_6" name="text_6">
                                                <option value="" selected>- Select -</option>
                                            </select> -->
                                        </div>
                                    </div>
                                    <div class="form-group row custom-processby hidden"> <!-- KAPAG WLA SO PROCESS BY -->
                                        <label class="col-md-3 label-control" for="text6_0"></label>
                                        <div class="col-md-9 mx-auto">
                                            <input type="text" class="form-control textCapitalall" name="text6_0" id="text6_0" placeholder="Enter Process By.">
                                        </div>
                                    </div>

                                    <div class="form-group row" id="attachehiddenonreturn"> <!-- KUNG SINO ANG MGA TAONG NASA DEPARTMENT NA KAPAREHAS NG NAKALOGIN -->
                                        <label class="col-md-3 label-control" for="text_8">Attached File</label>
                                        <div class="col-md-9 mx-auto">
                                            <input class="form-control" type="file" name="text_8[]" id="text_8" multiple>
                                        </div>
                                    </div>
                               
                                    <textarea class="hidden" name="text_8text" id="text_8text" cols="30" rows="10"></textarea>
                                    <div class="form-group row"> <!-- KUNG SINO ANG MGA TAONG NASA DEPARTMENT NA KAPAREHAS NG NAKALOGIN -->
                                        <label class="col-md-3 label-control" for="text_9">Brief Description</label>
                                        <div class="col-md-9 mx-auto">
                                            <textarea class="form-control" name="text_9" id="text_9" cols="30" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="show_on_returndoc hidden">
                                        <div class="form-group row">
                                            <div class="col-md-12 mx-auto">
                                                <button type="button" id="btn_editsignatories" class="btn btn-danger">Edit Signatories</button>
                                            </div>
                                            <hr>
                                        </div> 
                                    </div>
                                    <div id="hide_on_returndoc" class="hidden">
                                        <div class="form-group row">
                                            <div class="col-md-9 mx-auto">
                                                <select class="form-control sel_department select2-custom" id="text_7" name="text_7">
                                                    <option value="" selected>- Select -</option>
                                                </select>
                                            </div>
                                            <div>
                                                <button class="btn btn-success btn-actions mr-4" type="button" id="btnadddept" name="btnadddept" data-action="receiving_dept"><i class="las la-plus"></i> Add Signatories</button>
                                            </div>
                                            <hr>
                                        </div> 
                                    </div>
                                    <table id="tbl_tmp" class="table table-hover table-bordered table-striped tbl_tmp"  style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Department</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                               
                                    <div class="form-group row">  <!-- KUNG ANONG DEPARTMENT ANG HULING MAG SA SIGN -->
                                        <label class="col-md-3 label-control" for="text_5">Final Approving Authority</label>
                                        <div class="col-md-9 mx-auto">
                                            <label class="text-danger" id="label_finalapproving"></label>
                                            <input type="hidden" name="text_5" id="text_5">
                                            <!-- <select class="form-control sel_department select2-custom" id="text_5" name="text_5">
                                                <option value="" selected>- Select -</option>
                                            </select> -->
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="show_on_returndoc hidden">
                                        <div class="form-group row">
                                            <div class="col-md-12 mx-auto">
                                                <button type="button" id="btn_editattachments" class="btn btn-danger">Download Attachments</button> <button type='button' id="btnreuploadfile" class='btn btn-primary hidden'>Reupload</button> <br> &nbsp; <br> <input class="form-control hidden" type="file" name="text_10[]" id="text_10" multiple>
                                            </div>
                                            <hr>
                                        </div> 
                                    </div>


                        </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-danger" id="cancelreturn">Cancel</button>
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-outline-primary" value="Submit">
            </div>
            </form>
        </div>
    </div>
</div>