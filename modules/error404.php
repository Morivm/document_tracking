<?php
    include 'session.php';

    include '../includes/header.php';
?>

<body class="vertical-layout vertical-menu 1-column   blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-8 col-10 p-0">
                            <div class="card-header bg-transparent border-0">
                                <h2 class="error-code text-center mb-2">404</h2>
                                <h3 class="text-uppercase text-center">Page Not Found !</h3>
                            </div>
                            <div class="card-content">
                                <fieldset class="row py-2">
                                    <div class="input-group col-12">
                                        <input type="text" class="form-control border-grey border-lighten-1 " placeholder="Search..." aria-describedby="button-addon2">
                                        <span class="input-group-append" id="button-addon2">
                                            <button class="btn btn-secondary border-grey border-lighten-1" type="button"><i class="ft-search"></i></button>
                                        </span>
                                    </div>
                                </fieldset>
                                <div class="row py-2">
                                    <div class="col-12 col-sm-6 col-md-6 mb-1">
                                        <a href="dashboard" class="btn btn-primary btn-block"><i class="las la-tachometer-alt"></i> Back To Dashboard</a>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 mb-1">
                                        <a href="#" class="btn btn-danger btn-block"><i class="ft-search"></i> Search</a>
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
</body>
<!-- END: Body-->
<script>
    closePageLoader();
</script>
</html>