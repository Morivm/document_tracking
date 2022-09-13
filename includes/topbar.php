
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>

                    <a class="navbar-brand" href="dashboard"><img class="brand-logo wb_image" alt="Company Logo" src="" width="50">
                    <h3 class="brand-text">One Cainta</h3></a>


                        <!-- <img class="wb_image text-center" src="" class="brand-logo"  alt="branding logo" width="50%" "> -->
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                        <li class="nav-item d-none d-lg-block" title="Maximize"><a class="nav-link nav-link-expand"><i class="ficon ft-maximize"></i></a></li>
                        <!-- <li class="nav-item d-none d-lg-block" title="Pause Document"><a class="nav-link navPauseDoc"><i class="ficon ft-pause"></i></a></li>
                        <li class="nav-item d-none d-lg-block" title="Resume Document"><a class="nav-link navPlayDoc"><i class="ficon ft-play"></i></a></li> -->
                        
                    </ul>
                    <ul class="nav navbar-nav float-right">
                     
                       <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link " href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700"><?php echo $userdeptname ?></span><span class="avatar avatar-online"><img  src="<?php echo checkUserimgExist($userid) ?>"  alt="avatar"><i></i></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="../modules/profile" class="dropdown-item"> <?php echo $userempname ?></a>
                                <!-- <a href="#mdl_view_tut" class="dropdown-item" data-toggle="modal" data-target="#mdl_view_tut"><i class="ft-message-square"></i> Help</a> -->
                                <a class="dropdown-item btn_logout"><i class="ft-power"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="modal fade text-left" id="mdl_view_tut" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Help</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        

<h1>Quick start</h1>
Learn these top skills to get started quickly.<br><br>




<div id="accordionWrap3" role="tablist" aria-multiselectable="true">
    <div class="card accordion collapse-icon accordion-icon-rotate">
        <a id="heading31" class="card-header bg-info info" data-toggle="collapse" href="#accordion31" aria-expanded="false" aria-controls="accordion31">
            <div class="card-title lead white font-weight-bold">1. How to login</div>
        </a>
        <!-- 1 -->
        <div id="accordion31" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading31" class="card-collapse collapse"
            aria-expanded="true">
            <div class="card-content">
                <div class="card-body">
                    <label>1. Open Google Chrome</label><br>
                    <label>2. Type URL of Document Tracking System</label><br>
                    <label>3. http://xxx.xxx.xxx.xxx/doctrack/index</label><br>
                    <label>4. Enter Credentials </label><br>
                    <div class="container">
                        <div class="table-responsive">
                            <img src="../img/resources/pp/login_dash.PNG" alt="login image">
                        </div>
                    </div>
                   <br>
                </div>
            </div>
        </div>
        <!-- 2 -->
        <a id="heading32" class="card-header bg-info info" data-toggle="collapse" href="#accordion32" aria-expanded="false" aria-controls="accordion32">
            <div class="card-title lead white collapsed font-weight-bold">2. Change Password</div>
        </a>
        <div id="accordion32" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading32" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. Login to system</label><br>
                    <label>2. Click Avatar at Top-Right most</label><br>
                    <div class="container">
                        <div class="table-responsive">
                            <img src="../img/resources/pp/changepass_1.PNG" alt="Change Password image"><br>
                            <img src="../img/resources/pp/changepass_2.PNG" alt="Change Password image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 3 -->
        <a id="heading33" class="card-header bg-info info" data-toggle="collapse" href="#accordion33" aria-expanded="false" aria-controls="accordion33">
            <div class="card-title lead white collapsed font-weight-bold">3. Change Profile Picture</div>
        </a>
        <div id="accordion33" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading33" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. Login to system</label><br>
                    <label>2. Click Avatar at Top-Right most</label><br>
                    <div class="container">
                        <div class="table-responsive">
                            <img src="../img/resources/pp/changepic_1.PNG" alt="Change Profile Picture image"><br>
                            <img src="../img/resources/pp/changepic_2.PNG" alt="Change Profile Picture image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 4 -->
        <a id="heading34" class="card-header bg-info info" data-toggle="collapse" href="#accordion34" aria-expanded="false" aria-controls="accordion34">
            <div class="card-title lead white collapsed font-weight-bold">4. Create Transaction</div>
        </a>
        <div id="accordion34" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading34" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. Select Transactions in <b>Main Navigation</b></label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/create_transaction.PNG" alt="Create Transaction image"><br>
                    </div>
                    <label>2. Select Create Document</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/create_transaction2.PNG" alt="Create Transaction image"><br>
                    </div>
                    <label>3. Enter Details including Signatories</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/create_transaction3.PNG" alt="Create Transaction image"><br>
                    </div>
                    <br>
                    <label>4. Click <b>Submit</b> to save.</label><br>
                    <label>5. Print Cover page and attach to Physical Documents </label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/create_transaction4.PNG" alt="Create Transaction image"><br>
                    </div>
                </div>
            </div>
        </div>
        <!-- 5 -->
        <a id="heading34" class="card-header bg-info info" data-toggle="collapse" href="#accordion35" aria-expanded="false" aria-controls="accordion35">
            <div class="card-title lead white collapsed font-weight-bold">5. Receive Transaction</div>
        </a>
        <div id="accordion35" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading34" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. login.</label><br>
                    <label>2. View Pending Document from Dashboard.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/recieve_trans1.PNG" alt="Recieve Transaction image"><br>
                    </div>
                    <br>
                    <label>3. Select Transactions => Recieve/ Transfer.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/recieve_trans2.PNG" alt="Recieve Transaction image"><br>
                        <img src="../img/resources/pp/recieve_trans3.PNG" alt="Recieve Transaction image"><br>
                    </div>
                    <br>
                    <label>4. Click the Green Icon to Receive Document.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/recieve_trans4.PNG" alt="Recieve Transaction image"><br>
                    </div>
                    <label>5. Scan Barcode and enter Name (INITIALS).</label><br>
                    <label>6. Click <b>Receive</b> to confirm.</label><br>
                </div>
            </div>
        </div>
        <!-- 6 -->
        <a id="heading34" class="card-header bg-info info" data-toggle="collapse" href="#accordion36" aria-expanded="false" aria-controls="accordion36">
            <div class="card-title lead white collapsed font-weight-bold">6. Transfer Document</div>
        </a>
        <div id="accordion36" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading34" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. login.</label><br>
                    <label>2. Select Transactions => Recieve/ Transfer.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/recieve_trans2.PNG" alt="Recieve Transaction image"><br>
                        <img src="../img/resources/pp/transfer_doc_1.PNG" alt="Transfer image"><br>

                    </div>
                    <br>
                    <label>3. Click the Red Icon to Transfer Document.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/transfer_doc_2.PNG" alt="Transfer image"><br>
                    </div>
                    <label>4. Input Details and Click <b>Transfer</b></label><br>
                </div>
            </div>
        </div>
        <!-- 7 -->
        <a id="heading34" class="card-header bg-info info" data-toggle="collapse" href="#accordion37" aria-expanded="false" aria-controls="accordion37">
            <div class="card-title lead white collapsed font-weight-bold">7. Approve Document</div>
        </a>
        <div id="accordion37" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading34" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. Receive Document (see Receive Document).</label><br>
                    <label>2. Select Transactions => Recieve/ Transfer.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/recieve_trans2.PNG" alt="Recieve Transaction image"><br>
                        <img src="../img/resources/pp/transfer_doc_1.PNG" alt="Transfer image"><br>

                    </div>
                    <br>
                    <label>3. Click the Red Icon NOTE !!! Approve button will be available for Final Approving Authority Only) .</b></label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/approved.PNG" alt="Approved Document image"><br>
                    </div>
                    <br>
                    <label>4. Input Details and Click <b>Approved.</b></label><br>
                </div>
            </div>
        </div>
        <!-- 8 -->
        <a id="heading34" class="card-header bg-info info" data-toggle="collapse" href="#accordion38" aria-expanded="false" aria-controls="accordion38">
            <div class="card-title lead white collapsed font-weight-bold">8. Return to Creator</div>
        </a>
        <div id="accordion38" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading34" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. Receive Document (see Receive Document).</label><br>
                    <label>2. Select Transactions => Recieve/ Transfer.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/recieve_trans2.PNG" alt="Recieve Transaction image"><br>
                        <img src="../img/resources/pp/transfer_doc_1.PNG" alt="Transfer image"><br>

                    </div>
                    <br>
                    <label>3. Click the Red Icon.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/returntocreator.PNG" alt="Return to creator image"><br>
                    </div>
                    <label>4. Click <b>Return to Creator.</b></label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/returntocreator1.PNG" alt="Return to creator image"><br>
                    </div>
                    <label>5. Input Details and Click <b>Return to Creator.</b></label><br>
                </div>
            </div>
        </div>
        <!-- 9 -->
        <a id="heading34" class="card-header bg-info info" data-toggle="collapse" href="#accordion39" aria-expanded="false" aria-controls="accordion39">
            <div class="card-title lead white collapsed font-weight-bold">9. Update Document</div>
        </a>
        <div id="accordion39" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading34" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. Login</label><br>
                    <label>2. Review Dashboard and identify Documents to Update</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/update_document.PNG" alt="Update Document image"><br>
                    </div>
                    <br>
                    <label>3. Receive the document.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/update_document1.PNG" alt="Update Document image"><br>
                    </div>
                    <br>
                    <label>4. Navigate to History => Update/Cancel</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/update_document2.PNG" alt="Update Document image"><br>
                        <img src="../img/resources/pp/update_document3.PNG" alt="Update Document image"><br>
                    </div>
                    <br>
                    <label>5. CLick Update/Cancel Document.</label><br>
                    <br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/update_document4.PNG" alt="Update Document image"><br>
                    </div>
                    <br>
                    <label>6. Edit Details And Click Submit to Update.</label><br>
                </div>
            </div>
        </div>
        <!-- 10 -->
         <a id="heading34" class="card-header bg-info info" data-toggle="collapse" href="#accordion40" aria-expanded="false" aria-controls="accordion40">
            <div class="card-title lead white collapsed font-weight-bold">10. Cancel Document</div>
        </a>
        <div id="accordion40" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading34" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. Login.</label><br>
                    <label>2. Repeat Process for <b>UPDATE DOCUMENT.</b></label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/cancel_doc.PNG" alt="Cancel Document image"><br>
                    </div>
                    <br>
                    <label>3. Click the <b>Cancel</b> Button.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/cancel_doc1.PNG" alt="Cancel Document image"><br>
                    </div>
                    <br>
                    <label>4. Click <b>Yes, Proceed</b> when pop-up appears.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/cancel_doc2.PNG" alt="Cancel Document image"><br>
                    </div>
                    <br>
                    <label>5. Input <b>Remarks</b> And click <b>Cancel Document</b>.</label><br>
                    <br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/cancel_doc3.PNG" alt="Cancel Document image"><br>
                    </div>
                    <br>
                    <label>6. Click <b>Yes, Cancel it</b> to confirm.</label><br>
                </div>
            </div>
        </div>
        <!-- 11 -->
            <a id="heading34" class="card-header bg-info info" data-toggle="collapse" href="#accordion41" aria-expanded="false" aria-controls="accordion41">
            <div class="card-title lead white collapsed font-weight-bold">11. Print / Re-print Cover page</div>
        </a>
        <div id="accordion41" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading34" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. Login.</label><br>
                    <label>2. Select Transactions => Recieve/ Transfer.</b></label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/recieve_trans2.PNG" alt="Recieve Transaction image"><br>
                        <img src="../img/resources/pp/reprint.PNG" alt="Print Document image"><br>
                    </div>
                    <br>
                    <label>3. Click the Violet Icon to generate cover page.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/reprint1.PNG" alt="Print Document image"><br>
                    </div>
                </div>
            </div>
        </div>
        <!-- 12 -->
        <a id="heading34" class="card-header bg-info info" data-toggle="collapse" href="#accordion42" aria-expanded="false" aria-controls="accordion42">
            <div class="card-title lead white collapsed font-weight-bold">12. Download Attachments</div>
        </a>
        <div id="accordion42" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading34" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. Login.</label><br>
                    <label>2. Select Transactions => Recieve/ Transfer.</b></label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/recieve_trans2.PNG" alt="Recieve Transaction image"><br>
                    </div>
                    <br>
                    <label>3. Choose The Transaction and click <b>Download Attachment</b>. </label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/download_attachment.PNG" alt="Download Attachment image"><br>
                    </div>
                </div>
            </div>
        </div>
        <!-- 13 -->
        <a id="heading34" class="card-header bg-info info" data-toggle="collapse" href="#accordion43" aria-expanded="false" aria-controls="accordion43">
            <div class="card-title lead white collapsed font-weight-bold">13. Adding Document Type</div>
        </a>
        <div id="accordion43" role="tabpanel" data-parent="#accordionWrap3" aria-labelledby="heading34" class="card-collapse collapse" aria-expanded="false">
            <div class="card-content">
                <div class="card-body">
                    <label>1. Login.</label><br>
                    <label>2. Select Settings => Maintenance => Add Document Type</b>.</label><br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/doctype.PNG" alt="Add Document Type image"><br>
                        <img src="../img/resources/pp/doctype1.PNG" alt="Add Document Type image"><br>
                    </div>
                    <br>
                    <label>3. Click <b>Add Document Type</b> Button. </label><br>
                    <br>
                    <div class="table-responsive">
                        <img src="../img/resources/pp/doctype2.PNG" alt="Add Document Type image"><br>
                    </div>
                    <br>
                    <label>4. Input Details and click <b>Save</b> Button. </label><br>
                </div>
            </div>
        </div>
    </div>
</div>













                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>