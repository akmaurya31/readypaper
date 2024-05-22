<!--**********************************
Content body start
***********************************-->
<div class="content-body">
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
         <!-- DataTales Example -->
         <div class="card shadow mb-4">
             <?php if ($countSchool){}else{?>
                     <div class="card-header py-3">
                     <button type="button" class="btn btn-rounded btn-secondary" onclick="add_school()">
                                    <span class="btn-icon-start text-secondary"><i class="fa fa-plus color-info  color-secondary"></i> </span>Create <?= $title?> </button>
                                <button type="button" class="btn btn-rounded btn-warning" onclick="reload_table()">
                                    <span class="btn-icon-start text-warning"><i class="fa fa-share-alt color-warning"></i>
                                    </span>Reload</button>
                     </div>
                     <?php } ?>
                     
                     
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                            <th>S.no</th>   
                                            <th>Created By</th> 
                                            <th style="width:15%;">Logo</th> 
                                            <th><?= $title?> Name</th> 
                                            <th>Address</th> 
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
        
        <script type="text/javascript">

var save_method; //for save method string
var table;
    var base_url = '<?php echo base_url(); ?>';
    var controllerListUrl = '<?php echo site_url('teacher_school/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('teacher_school/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('teacher_school/ajax_delete') ?>";
 

function add_school()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add School/Institute'); // Set Title to Bootstrap modal title

    $('#photo-preview').hide(); // hide photo preview modal

    $('#label-photo').text('Upload Photo'); // label photo upload
}

function edit_school(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('teacher_school/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);          
            $('[name="head"]').val(data.school_name);
            $('[name="address"]').val(data.address); 
            $('[name="fb"]').val(data.fb); 
            $('[name="lin"]').val(data.lin); 
            $('[name="you"]').val(data.you); 
            $('[name="teli"]').val(data.teli); 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit School/Institute'); // Set title to Bootstrap modal title
            $('#photo-preview').show(); // show photo preview modal

            if(data.pic)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'upload/school/'+data.pic+'" class="img-responsive" style="width:30%">'); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.pic+'"/> Remove photo when saving'); // remove photo

            }
            else
            {
                $('#label-photo').text('Upload logo'); // label photo upload
                $('#photo-preview div').text('(No logo)');
            }


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
        url = "<?php echo site_url('teacher_school/ajax_add')?>";
    } else {
        url = "<?php echo site_url('teacher_school/ajax_update')?>";
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
                location.reload();
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
                         
                        <div class="form-group row mb-3 ">                       
                            <div  id="photo-preview">                            
                               <div class="col-md-9">(No photo) <span class="help-block"></span></div>
                            </div>
                            <label class="col-form-label col-sm-4"><?= $title?>  images</label>
                        <div class="col-sm-8">
                          <input type="file" name="pic" id="exampleFirstName" placeholder="school Image">
                        </div>
                        </div> 

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label"><?= $title?> Name </label>
                            <div class="col-sm-8">
                            <input type="text" name="head" class="form-control" id="exampleFirstName" placeholder="">
                            <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Address </label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="address"></textarea>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <hr>
                         <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Facebook </label>
                            <div class="col-sm-8">
                            <input type="text" name="fb" class="form-control" id="exampleFirstName" placeholder="">
                            <span class="help-block"></span>
                            </div>
                        </div>
                         <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Youtube </label>
                            <div class="col-sm-8">
                            <input type="text" name="you" class="form-control" id="exampleFirstName" placeholder="">
                            <span class="help-block"></span>
                            </div>
                        </div>
                         <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Telegram </label>
                            <div class="col-sm-8">
                            <input type="text" name="teli" class="form-control" id="exampleFirstName" placeholder="">
                            <span class="help-block"></span>
                            </div>
                        </div>
                         <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Linkedin </label>
                            <div class="col-sm-8">
                            <input type="text" name="lin" class="form-control" id="exampleFirstName" placeholder="">
                            <span class="help-block"></span>
                            </div>
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

