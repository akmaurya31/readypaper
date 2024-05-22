 <div class="content-body">
            <div class="container-fluid">
				
			


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <button type="button" class="btn btn-rounded btn-secondary" onclick="add_category()">
                                    <span class="btn-icon-start text-secondary"><i class="fa fa-plus color-info  color-secondary"></i> </span>Create <?= $title?> </button>
                                <button type="button" class="btn btn-rounded btn-warning" onclick="reload_table()">
                                    <span class="btn-icon-start text-warning"><i class="fa fa-share-alt color-warning"></i>
                                    </span>Reload</button>
                                    
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table" class="table table-striped table-bordered" >
                                        <thead>
                                            <tr>
                                             <th>S.No.</th>
                                             
                                                <th>Exam Name </th>
                                                <th> Group Exam </th>
                                                <th>Status / Action</th>
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
    var controllerListUrl = '<?php echo base_url('admin_group_exam/ajax_list') ?>';
    var statusUrl = '<?php echo base_url('admin_group_exam/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo base_url('admin_group_exam/ajax_delete') ?>";
 

function add_category()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Group Exam'); // Set Title to Bootstrap modal title

}

function edit_group_exam(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin_group_exam/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);          
            $('[name="exam_id"]').val(data.exam_id);
             $('[name="group_exam_name"]').val(data.group_exam_name);
            
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Group Exam'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

 

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('admin_group_exam/ajax_add')?>";
    } else {
        url = "<?php echo site_url('admin_group_exam/ajax_update')?>";
    }

    // ajax adding data to database

    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
            //alert(data.status);

            if(data.status) //if success close modal and reload ajax table
            {               
                $('#modal_form').modal('hide');               
                reload_table();
            }
            else
            {
                //alert(data.inputerror.length);
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Modal title</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">
            </button>
         </div>
         <div class="modal-body form">
            
           <div class="basic-form">
                    <form id="form" class="user">
                         <input type="hidden" value="" name="id"/> 
                         
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Exam Name </label>
                            <div class="col-sm-9">
                                <select class=" form-control wide mb-3" name="exam_id">
												<?php foreach($get_exam as $val){?>
											<option value="<?= $val->id?>"><?= $val->exam_name?></option>
										 <?php }?>
										</select>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Group Exam Name </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="group_exam_name">
                            </div>
                            <span class="help-block"></span>
                        </div>
                        
                        
                        
                     
                     
                    </form>
                </div>
           
            
            <div class="modal-footer">
               <button type="button" id="btnSave" onclick="save()" class="btn btn-rounded btn-secondary">Submit</button>
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
