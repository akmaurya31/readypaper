<!--**********************************
Content body start
***********************************-->
<div class="content-body">
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
         <!-- DataTales Example -->
         <div class="card shadow mb-4">
                     <div class="card-header py-3">
                     <a href="<?php echo base_url()?>admin_teacher_ad/menusAdd" 
                     class="d-none d-sm-inline-block btn  btn-primary shadow-sm" > Create Ads</a>
                    
                     <button class="d-none d-sm-inline-block btn btn-info shadow-sm" onclick="reload_table()">
                        <i class="fa fa-refresh"></i> Reload</button>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                            <th>S.no</th>   
                                            <th>Created By</th>
                                            <th style="width:15%;">Ads Images</th> 
                                            <th>Company Name</th>                                            
                                            <th>Content</th> 
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
    var controllerListUrl = '<?php echo site_url('admin_teacher_ad/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('admin_teacher_ad/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_teacher_ad/ajax_delete') ?>";
 


</script>





