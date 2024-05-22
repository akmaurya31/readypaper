<div class="content-body">
<div class="container-fluid">
    <div class="row">
    <div class="col-lg-12">
       <!-- DataTales Example -->
       <div class="card shadow mb-4">
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                        <tr>
                                            <th>S.no</th>   
                                            <th>Action</th>
                                             <!--<th>Board</th>
                                             <th>Class </th> --> 
                                             <th>Subject</th> 
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
    var controllerListUrl = '<?php echo site_url('admin_classsub_question/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('admin_classsub_question/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_classsub_question/ajax_delete') ?>";


</script>

