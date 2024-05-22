<!--**********************************
Content body start
***********************************-->
<div class="content-body">
<div class="container-fluid">
    <div class="row page-titles">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $title?></a></li>
             <li class="breadcrumb-item active"><a href="javascript:void(0)">
				<?php menu($_GET['menu_id'])?></a>
        </ol>
    </div>
    <!-- row -->

    <div class="row">
    <div class="col-lg-12">
       <!-- DataTales Example -->
       <div class="card shadow mb-4">
                     <div class="card-header py-3">                     
                     <a href="<?php echo base_url()?>admin_menu_details/menusAdd?menu_id=<?= $_GET['menu_id']?>" 
                     class="d-none d-sm-inline-block btn  btn-primary shadow-sm" > Create Menu Content</a>
                    
                     <button class="d-none d-sm-inline-block btn btn-info shadow-sm" onclick="reload_table()">
                        <i class="fa fa-refresh"></i> Reload</button>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                            <th>S.no</th>
                                             <th>Menu Name</th> 
                                            <th style="width:15%;">Menu Image</th> 
                                            <th>Menu Heading</th> 
                                            <th>Menu Content</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                </tbody>                           
                                </table>
                         </div>
                     </div>
                 </div>
        </div>
    </div>
</div>
</div>
<!--**********************************
Content body end
***********************************-->

        
<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';
    var controllerListUrl = '<?php echo site_url('admin_menu_details/ajax_list?menu_id='.$_GET['menu_id']) ?>';
    var statusUrl = '<?php echo site_url('admin_menu_details/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_menu_details/ajax_delete') ?>";
 </script>


