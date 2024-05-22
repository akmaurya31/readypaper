<!--**********************************
Content body start
***********************************-->
<div class="content-body">
<div class="container-fluid">
    

    <div class="row">
    <div class="col-lg-12">
       <!-- DataTales Example -->
       <div class="card shadow mb-4">
           <?php 
           $role = $this->session->userdata('role');
           if($role=='admin'){?>
                     <div class="card-header py-3">
                     <button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" onclick="add_menu()"><i
                                class="fa fa-user fa-sm text-white-50"></i> Create Menu </button>
                     <button class="d-none d-sm-inline-block btn btn-info shadow-sm" onclick="reload_table()">
                        <i class="fa fa-refresh"></i> Reload</button>
                     </div>
                     <?php  }else{
                     if($getCountList!=1){?>
                         <div class="card-header py-3">
                     <button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" onclick="add_menu()"><i
                                class="fa fa-user fa-sm text-white-50"></i> Create Menu </button>
                     <button class="d-none d-sm-inline-block btn btn-info shadow-sm" onclick="reload_table()">
                        <i class="fa fa-refresh"></i> Reload</button>
                     </div>
                     <?php }
                     ?>
                     
                     <?php }?>
                     
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                            <th>S.no</th>   
                                            <th>Created By</th> 
                                            <th>Menu Name</th>                   
                                            <th style="width:15%;"> Bg Image</th>  
                                            <th>Create Date</th>
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
<!--**********************************
Content body end
***********************************-->

        
        <script type="text/javascript">

var save_method; //for save method string
var table;
    var base_url = '<?php echo base_url(); ?>';
    var controllerListUrl = '<?php echo site_url('admin_menu/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('admin_menu/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_menu/ajax_delete') ?>";
 

function add_menu()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add menu'); // Set Title to Bootstrap modal title

    $('#photo-preview').hide(); // hide photo preview modal

    $('#label-photo').text('Upload Photo'); // label photo upload
}

function edit_menu(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin_menu/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);          
            $('[name="menu_name"]').val(data.menu_name);
            $('[name="title"]').val(data.title);
            $('[name="description"]').val(data.description);
            $('[name="metakey"]').val(data.metakey); 
             $('[name="content"]').val(data.content);
            $('[name="heading"]').val(data.heading);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit  menu'); // Set title to Bootstrap modal title

            $('#photo-preview').show(); // show photo preview modal

            if(data.bg_image)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'upload/banner/'+data.bg_image+'" class="img-responsive" style="width:30%">'); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.bg_image+'"/> Remove photo when saving'); // remove photo

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
        url = "<?php echo site_url('admin_menu/ajax_add')?>";
    } else {
        url = "<?php echo site_url('admin_menu/ajax_update')?>";
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
                            <label class="col-sm-4 col-form-label">Menu Title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title">
                            </div>
                            <span class="help-block"></span>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">MetaKey </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="metakey">
                            </div>
                            <span class="help-block"></span>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Meta Content </label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="description"></textarea>
                            </div>
                            <span class="help-block"></span>
                        </div>
                         
                        <div class="form-group row mb-3 ">                       
                            <div  id="photo-preview">                            
                               <div class="col-md-9">(No photo) <span class="help-block"></span></div>
                            </div>
                            <label class="col-form-label col-sm-4">Bg images</label>
                        <div class="col-sm-8">
                          <input type="file" name="bg_image" id="exampleFirstName" placeholder="Slider Image">
                        </div>
                        </div> 

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Menu Name </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="menu_name">
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