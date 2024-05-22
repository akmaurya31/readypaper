<!--**********************************
Content body start
***********************************-->
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
                                              <th>Status</th>
                                             <th> Date</th>
                                            <th>Teacher Pic</th>   
                                            <th>Username / Role </th>                                            
                                            <th>Name / Mobile No /Email id <br>DOB / Gender</th>                                                                                    
                                            <th>State City District <br> Address</th>
                                           
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
    var controllerListUrl = '<?php echo site_url('inactive_teacher/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('inactive_teacher/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('inactive_teacher/ajax_delete') ?>";
 


</script>








