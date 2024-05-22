<!--**********************************
Content body start
***********************************-->
<div class="content-body">
<div class="container-fluid">
   <div class="row page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="<?= base_url()?>admin_classsub_chapter">Chapter Subjects</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0)"><?php class_subName($_GET['clas_sub_id'])?></a></li>
					</ol>
                </div>

    <div class="row">
    <div class="col-lg-12">
       <!-- DataTales Example -->
       <div class="card shadow mb-4">
                     
                  
                                     <?php $role = $this->session->userdata('role'); 
                         if($role=='admin'){?>
                         <div class="card-header py-3">
                        <button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" onclick="add_chapter()"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                                    </span>Create Chapter </button>
                                    
                            &nbsp <a href="<?php echo base_url()?>admin_import_question/Class_Subject_Export?clas_sub_id=<?= $_GET['clas_sub_id']?>" 
                            class="btn btn-secondary" title="Export Questions"> <i class="fa fa-file-excel"></i></a>
                             
                                    
                        </div>
                                    <?php } ?>
                    
                     
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                            <th>S.no</th>  
                                            <th>Action</th>
                                            <!--<th>Created By</th> 
                                            <th>Board Name</th> 
                                            <th>Subject Name </th> 
                                            <th>Class Name</th> -->
                                            <th>Chapter  </th> 
                                            <th>Chapter Name </th> 
                                            <th> Date</th>
                                            
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
    var controllerListUrl = '<?php echo site_url('admin_chapter/ajax_list?clas_sub_id='.$_GET['clas_sub_id']) ?>';
    var statusUrl = '<?php echo site_url('admin_chapter/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_chapter/ajax_delete') ?>";
 

function add_chapter()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Chapter'); // Set Title to Bootstrap modal title

}

function edit_chapter(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin_chapter/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);          
           // $('[name="board"]').val(data.board_id);
           // $('[name="class"]').val(data.class_id);
           // $('[name="subject"]').val(data.subject_id);
            $('[name="chapter_name"]').val(data.chapter_name);
            $('[name="chapter_type"]').val(data.chapter_type);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Chapter'); // Set title to Bootstrap modal title

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
        url = "<?php echo site_url('admin_chapter/ajax_add')?>";
    } else {
        url = "<?php echo site_url('admin_chapter/ajax_update')?>";
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
            <h3 class="modal-title">Slider Form</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body form">
                  <div class="p-3=">  
                <form  id="form" class="user">
                   <input type="hidden" value="" name="id"/> 
                   <input type="hidden" value="<?= @$_GET['clas_sub_id']?>" name="clas_sub_id" name="clas_sub_id"/> 
                         <!--<div class="form-group  mb-3">
                                            <label class="form-label">Board*</label>
                                            <select class="form-control form-control-use" name="board" >
                                               <option value="">Select Board</option>
                                               <?php foreach($getBoard as $val){?>
                                               	 <option value="<?= $val->id?>"><?= $val->board_type_name?></option>
                                               <?php } ?>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                           <div class="form-group  mb-3">
                                            <label class="form-label">Subject*</label>
										<select class="form-control form-control-use " name="subject" >
										 <option value="">Select Subject</option>
											<?php
										
											
											foreach($getsubject as $val){ ?>
                                               	 <option value="<?= $val->id?>"><?= $val->subject_name?></option>
                                              
                                               <?php }?>
										</select>
										<span class="help-block"></span>
										 </div>
                                     
										 
										    <div class="form-group  mb-3">
                                            <label class="form-label">Class*</label>
									       	<select class="form-control form-control-use" name="class" >
										     <option value="">Select Class</option>
											<?php
											foreach($getclass as $val){?>
                                                <option value="<?= $val->id?>"><?= $val->class_name?></option>
                                           <?php   } ?>
										</select>
										<span class="help-block"></span>
										 </div>
										 -->
										 
										    <div class="form-group  mb-3">
                                            <label class="form-label"> Chapter Type*</label>
									       	<select class="form-control form-control-use" name="chapter_type" >
										     <option value="">Select Type</option>
											<?php
											foreach($getchapter_type as $val){?>
                                                <option value="<?= $val->id?>"><?= $val->chapter_type_name?></option>
                                           <?php   } ?>
										</select>
										<span class="help-block"></span>
										 </div>
										 
                   
                   <div class="form-group mb-3">
                        <label>Chapter Name*</label>
                           <input type="text" class="form-control form-control-user" name="chapter_name" id="exampleFirstName">
                           <span class="help-block"></span>
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