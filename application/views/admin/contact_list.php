
		
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
                                            <th> Date</th>
                                            <th>Customer name </th>
                                            <th> Email Id </th>
                                             <th>Mobile NO.</th>                                            
                                            <th>Message / Address</th>                                             
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
    var controllerListUrl = '<?php echo site_url('admin_contact/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('admin_contact/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_contact/ajax_delete') ?>";
 
</script>
		

        
       