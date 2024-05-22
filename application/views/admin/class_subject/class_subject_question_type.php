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
                          <?php $role = $this->session->userdata('role'); 
                         if($role=='admin'){?>
                     <a class="d-none d-sm-inline-block btn  btn-primary shadow-sm" href="<?= base_url()?>admin_class_subject_question_type/class_subject_add"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                                    </span>Create Question Type Mapping</a>
                                    <?php } ?>
                     <button class="d-none d-sm-inline-block btn btn-info shadow-sm" onclick="reload_table()">
                        <i class="fa fa-refresh"></i> Reload</button>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                            <th>S.no</th>   
                                            <th>Action</th>
                                             <th>Class </th>  
                                             <th>Subject</th> 
                                              <th>Question Type</th>
                                            <th>Create Date</th>
                                            
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
    var controllerListUrl = '<?php echo site_url('admin_class_subject_question_type/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('admin_class_subject_question_type/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_class_subject_question_type/ajax_delete') ?>";


</script>

