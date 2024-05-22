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
    var controllerListUrl = '<?php echo site_url('active_teacher/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('active_teacher/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('active_teacher/ajax_delete') ?>";
 
function getFreePlan(id){
    //alert(id);
    $("#modal_form_free").modal('show');
    $("#teacher_id").val(id);
}

function savePlan(){
     $.ajax({
        url : "<?php echo site_url('active_teacher/save_orderPlanFREE')?>",
        type: "post",
        data: {
            teacher_id:$('#teacher_id').val(),
            plan_id:$('#plan_name_id').val(),
        },
        success: function(data)
        {
            alert("Plan Successfully Assign This Teaher");  
            location.reload();
        },
      
    });
}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_free" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Free Plan Assign Teacher</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">
            </button>
         </div>
         <div class="modal-body form">
            
           <div class="basic-form">
                    <form id="form" class="user">
                         <input type="hidden" value="" name="id" id="teacher_id"/> 
                         
                        <div class="form-group row mb-3 ">                       
                          
                            <label class="col-form-label col-sm-4">Plan Name</label>
                        <div class="col-sm-8">
                            <select name="plan_name_id" id="plan_name_id" class="form-control">
                                <?php foreach($getFreePlan as $val){?>
                                <option value="<?= $val->id?>"><?= $val->heading?></option>
                                <?php } ?>
                            </select>
                        </div>
                        </div> 

                        
                    </form>
                </div>
           
            
            <div class="modal-footer">
               <button type="button" id="btnSave" onclick="savePlan()" class="btn btn-rounded btn-secondary">Submit</button>
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

