<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />

    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title><?php echo $this->config->item('site_name'); ?> </title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>assets/images/favicon.png" />
    <!-- Datatable -->
    <link href="<?= base_url() ?>assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/js/dataTables.bootstrap4.min.css" rel="stylesheet">


    <link href="<?= base_url() ?>assets/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">

    <!-- Style css -->
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/paika_technologies.css" rel="stylesheet">

    <style>
    .page-titles {
    
     background: #f8f8f8;
    }
    
    table.dataTable tbody td {
    font-size: 15px;
    
    }
    label {
    margin-bottom: 0.5rem;
    font-size: 16px;
   }
    .btn {
    padding: 0.638rem 1.1rem;
        
    }
        .dlabnav .metismenu a {
   
    color: #3d4140;
}
        .dlabnav .metismenu ul a {
            font-size: 0.9975rem;
        }

        .help-block {
            color: #ff0000;
        }

        .content-body .container-fluid,
        .content-body .container-sm,
        .content-body .container-md,
        .content-body .container-lg,
        .content-body .container-xl,
        .content-body .container-xxl {
            padding-top: 0.5rem;
            padding-right: 1.5rem;
            padding-left: 1.5rem;
        }
    </style>
    
    
    	<script>
document.onkeydown = function(e) {
        if (e.ctrlKey && 
            (e.keyCode === 67 || 
             e.keyCode === 86 || 
             e.keyCode === 85 || 
             e.keyCode === 117)) {
            return false;
        } else {
            return true;
        }
};
$(document).keypress("u1",function(e) {
  if(e.ctrlKey)
  {
return false;
}
else
{
return true;
}
});
</script>
    
</head>

<body id="top"  oncontextmenu="return false;" onload="callerOffer();">



    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="<?= base_url() ?>" class="brand-logo">
                <div>
                    <h3>Ready<span class='text-primary'>Paper</span></h3>
                    
                </div>

            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar text-light-">
                                <?= $title ?>
                            </div>

                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                    <img src="<?= base_url() ?>assets/images/logo.png" width="40" alt="PaikaSoft_Technologies_LLP" style="    width: 7.5rem;" />
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php if($this->session->userdata('role')=='admin'){?>
                                    <a href="<?= base_url() ?>admin_profile" class="dropdown-item ai-icon">
                                        <svg id="icon-user2" xmlns="" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span class="ms-2">Profile </span>
                                    </a>
                                    <?php }?>

                                    <a href="<?= base_url() ?>logout" class="dropdown-item ai-icon">
                                        <svg xmlns="" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span class="ms-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->