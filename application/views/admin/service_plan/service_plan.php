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
                     <a href="<?php echo base_url()?>admin_service_plan/menusAdd" 
                     class="d-none d-sm-inline-block btn  btn-primary shadow-sm" > Create Plan</a>
                    
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
                                        <th style="width:15%;">Plan Pic</th> 
                                        <th>Plane Name<br>Access Plan</th>
                                        <th>Subject</th> 
                                        <th>Quantity</th>
                                        <th>Validity Date</th> 
                                        <th>Plane Validity </th>
                                        <th>Price</th> 
                                        
                                        <th>Content</th> 
                                        <th>Date</th>
                                        
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
    var controllerListUrl = '<?php echo site_url('admin_service_plan/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('admin_service_plan/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_service_plan/ajax_delete') ?>";
 
function getShow(name){
    //alert(name);
    $("#modal_formSubject").modal('show');
    $(".modal-title").text(name);
     $.ajax({
        url : "<?= base_url()?>admin_service_plan/getShow",
        type: "post",
        data: {name:name},
        success: function(data){
            //alert(data);
            $(".shoedata").html(data);
        }
     });
}


function editPlan(id,price,startdate,enddate,qty,validite){
    //alert(enddate);
    $("#modal_formEdit").modal('show');
    $("#start_date").val(startdate);
    $("#end_date").val(enddate);
    $(".heading").text('Plan validity '+validite+ ' Month');
    $("#id").val(id);
    $("#price").val(price);
    $("#qty").val(qty);
    $("#validite").val(validite);
}

function getPlanUpdate(){
     $.ajax({
        url : '<?= base_url()?>admin_service_plan/getPlanUpdate',
        type: "POST",
        data: {
                id:$("#id").val(),
                validite:$("#validite").val(),
                qty:$("#qty").val(),
                price:$("#price").val(),
                end_date:$("#end_date").val(),
                start_date:$("#start_date").val(),
        },
        success: function(data)
        {
            if(data==1){
            alert("Plan Succssfully Updated");
            location.reload();
        }
            
          }
         
     });
}

</script>


<!-- Edit Bootstrap modal -->
<div class="modal fade" id="modal_formEdit" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title ">Change Validity Date & Plan Validity</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">
            </button>
         </div>
         <div class="modal-body form">
           <div class="basic-form">
               <form id="form" class="user" method="post">
                         <input type="hidden" value="" id="qty"/> 
                         <input type="hidden" value="" id="validite"/> 
                         <input type="hidden" value="" id="price"/> 
                         <input type="hidden" value="" id="id"/> 
                          <h4 class="heading"></h4>
                         <div class="row">
                        	<div class="col-md-6 pt-3 pb-3">
								<div class="form-group">
									<label>Start Date</label>
									<input type="date" name="start_date"  id="start_date" class="form-control border-input" value="<?php echo set_value('start_date') ?>">
								</div>
							</div>
							
								<div class="col-md-6 pt-3  pb-3">
								<div class="form-group">
									<label>End Date</label>
									<input type="date" name="end_date" id="end_date" class="form-control border-input" value="<?php echo set_value('end_date') ?>">
								</div>
							</div>
							
                       <!-- <div class="col-md-6 pt-3 pb-3">
                            	<div class="form-group">
									<label>Plan validity (In Month)</label>
									<select name="validity" id="validity" class="form-control">
                                            
                                                    <option value="3">3 Month</option>
                                                    <option value="6">6 Month</option>
                                                    <option value="12">12 Month</option>
                                                    <option value="24">24 Month</option>
                                                     <option value="36">26 Month</option>
                                                      <option value="48">48 Month</option>
                                            </select>
								
								</div>
                        </div>-->
                      
                        <div class="">
							<button type="button" class="btn btn-info btn-fill btn-wd" onclick="getPlanUpdate()">Update </button>
						</div>
                       
                       </div>
                    </form>
               
            </div>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_formSubject" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Modal title</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">
            </button>
         </div>
         <div class="modal-body form">
           <div class="basic-form">
               <table class="table">
                   <tr>
                       <th>Subject</th>
                   </tr>
                   <tbody class="shoedata"></tbody>
                   </table></div>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->





