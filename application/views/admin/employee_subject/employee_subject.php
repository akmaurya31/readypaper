<div class="content-body">
<div class="container-fluid">

    <div class="row">
    <div class="col-lg-12">
       <!-- DataTales Example -->
       <div class="card shadow mb-4">
                     <div class="card-header py-3">
                     <a class="d-none d-sm-inline-block btn  btn-primary shadow-sm" href="<?= base_url()?>admin_employee_subject/employee_subject_add"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                                    </span>Assign Employee subject </a>
                     <button class="d-none d-sm-inline-block btn btn-info shadow-sm" onclick="reload_table()">
                        <i class="fa fa-refresh"></i> Reload</button>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                            <th>S.no</th>
                                             <th>Employee Name</th>
                                            
                                              <th>Subject </th>                   
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

<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';
    var controllerListUrl = '<?php echo site_url('admin_employee_subject/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('admin_employee_subject/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_employee_subject/ajax_delete') ?>";
</script>
<script>
function deletesubject(empId){
    $("#modal_formdelete").modal('show');
    $.ajax({
    url: '<?= base_url()?>admin_employee_subject/deletesubject',
    type: "POST",
    data: {
        empId: empId
    },
    success: function(data) {
        $("#emptbody").html(data);
    },
    error: function(xhr, status, error) {
        console.error("Ajax request failed:", status, error);
    }
});
    
}

function deteEmployee(id){
    $.ajax({
    url: '<?= base_url()?>admin_employee_subject/deteEmployee',
    type: "POST",
    data: {
        id: id
    },
    success: function(data) {
        alert("Data Delete succssfully");
        $("#modal_formdelete").modal('hide');
        location.reload();
    },
    error: function(xhr, status, error) {
        console.error("Ajax request failed:", status, error);
    }
});
}
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_formdelete" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Delete Employee For Subject</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">
            </button>
         </div>
         <div class="modal-body form">
           <div class="basic-form">
                  <table class="table table-striped table-bordered dataTable no-footer" id="table">  
                  <tr>
                      <th>Subject</th>
                      <th>Action</th>
                      </tr>
                      
                      <tbody id="emptbody">
                          </tbody>
                          
                  </table>
                </div>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

