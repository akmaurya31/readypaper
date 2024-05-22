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
                                            <th>Logo</th>   
                                            <th>Username<br> Send Mail(DOB)</th>
                                            <th>Role</th>                                            
                                            <th>Name<br> Mobile No <br> Email id</th>                                                                                    
                                            <th>Address <br> Editor API</th>
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
    var controllerListUrl = '<?php echo site_url('admin_profile/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('admin_profile/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_profile/ajax_delete') ?>";
 



function edit_admin_profile(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin_profile/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);
            $('[name="firstName"]').val(data.firstName);            
            $('[name="username"]').val(data.username);
            $('[name="emailId"]').val(data.email);
            $('[name="passwordhide"]').val(data.password);
            $('[name="mobile_no"]').val(data.mobile_no);

            $('[name="role"]').val(data.role);
            $('[name="address"]').val(data.address);
         
         
          $('[name="editor_api"]').val(data.editor_api);
           $('[name="send_mail"]').val(data.send_mail);
         
           // $('[name="dob"]').datepicker('update',data.dob);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Profile'); // Set title to Bootstrap modal title

            $('#photo-preview').show(); // show photo preview modal

            if(data.logo)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'upload/'+data.logo+'" class="img-responsive">'); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.logo+'"/> Remove photo when saving'); // remove photo

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
        url = "<?php echo site_url('admin_profile/ajax_add')?>";
    } else {
        url = "<?php echo site_url('admin_profile/ajax_update')?>";
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

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
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
            <h3 class="modal-title">admin_profile Form</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body form">
                  <div class="p-3">  
                <form  id="form" class="user">
                   <input type="hidden" value="" name="id"/> 

                   <div class="form-group row mb-3">
                   <div  id="photo-preview">
                    <label class="control-label">Logo</label>
                    <div>(No photo) <span class="help-block"></span></div>
                    </div>
                    <input name="logo" type="file" >
                    </div>
                    <div class="form-group row mb-3">
                           <input type="text" class="form-control form-control-user" name="username" id="exampleFirstName" placeholder="User Name">
                           <span class="help-block"></span>
                    </div>
                    <div class="form-group row mb-3">                          
                                <input name="password" placeholder="Password" class="form-control" type="text">
                                <input type="hidden" name="passwordhide" value="">
                                <span class="help-block"></span>                           
                        </div>
                    
                        <div class="form-group row mb-3">                           
                                <input name="firstName" placeholder="Employee Name" class="form-control" type="text">
                                <span class="help-block"></span>                            
                        </div>
                       

                    <div class="form-group row mb-3">
                    <select name="role" class="form-control ">
                                    <option value="">--Select Role--</option>                                   
                                    <option value="admin">Admin</option>  
                                </select>    
                                <span class="help-block"></span>                    
                    </div>
                    <div class="form-group row mb-3">                           
                                <input name="emailId" placeholder="Email Id" class="form-control" type="text">
                                <span class="help-block"></span>                           
                        </div>
                       
                        <div class="form-group row mb-3">
                        <input type="text" class="form-control form-control-user" name="mobile_no" id ="exampleInputEmail" placeholder="Mobile No.">
                        <span class="help-block"></span>  
                    </div>
                    
                    
                      <div class="form-group row mb-3">
                        <input type="email" class="form-control form-control-user" name="send_mail" id ="" placeholder="Send Mail DOB">
                        <span class="help-block"></span>  
                    </div>
                    
                    
                    
                       
                     
                       <div class="form-group row mb-3">                           
                                <textarea name="editor_api" placeholder="EDITOR API" class="form-control"></textarea>
                                                         
                        </div>

                     
                        <div class="form-group row mb-3">                           
                                <textarea name="address" placeholder="Address" class="form-control"></textarea>
                                                         
                        </div>

                    

                        
                </form>
                </div>
                <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Submit</button>
            </div>
                
            </div>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->