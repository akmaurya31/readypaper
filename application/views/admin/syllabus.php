
<div class="content-body">
<div class="container-fluid">
   <div class="row page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="<?= base_url()?>admin_classsub_syllabus">Syllabus Subjects</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0)"><?php class_subName($_GET['syllabus_id'])?></a></li>
					</ol>
                </div>

    <div class="row">
    <div class="col-lg-12">
       <!-- DataTales syllabusple -->
       <div class="card shadow mb-4">
                     <div class="card-header py-3">
                     <button class="d-none d-sm-inline-block btn  btn-primary shadow-sm" onclick="add_syllabus()"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                                    </span>Create Syllabus </button>
                     <button class="d-none d-sm-inline-block btn btn-info shadow-sm" onclick="reload_table()">
                        <i class="fa fa-refresh"></i> Reload</button>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                            <th>S.no</th> 
                                            <th>Syllabus Name</th> 
                                             <th>Number</th>  
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
     var controllerListUrl = '<?php echo site_url('admin_syllabus/ajax_list?syllabus_id='.$_GET['syllabus_id']) ?>';
    var statusUrl = '<?php echo site_url('admin_syllabus/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_syllabus/ajax_delete') ?>";
 

function add_syllabus()
{
    save_method = 'add';
    $('#form')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $('#modal_form').modal('show'); 
    $('.modal-title').text('Add syllabus'); 

}

function edit_syllabus(id)
{
    save_method = 'update';
    $('#form')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin_syllabus/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);          
            $('[name="syllabus_name"]').val(data.syllabus_name);
            $('[name="syllabus_no"]').val(data.syllabus_no);
            $('#modal_form').modal('show'); 
            $('.modal-title').text('Edit syllabus');
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
        url = "<?php echo site_url('admin_syllabus/ajax_add')?>";
    } else {
        url = "<?php echo site_url('admin_syllabus/ajax_update')?>";
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
                //alert(data.inputerror.length);
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
                }
            }
            $('#btnSave').text('save'); 
            $('#btnSave').attr('disabled',false);
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
                   <input type="hidden" value="<?= @$_GET['syllabus_id']?>" name="class_sub_id" name="class_sub_id"/> 

                    <div class="form-group mb-3">
                        <label>Syllabus Number</label>
                           <input type="number" class="form-control form-control-user" name="syllabus_no" id="syllabuspleFirstName" >
                           <span class="help-block"></span>
                    </div> 
                    <div class="form-group mb-3">
                        <label>Syllabus Name</label>
                           <input type="text" class="form-control form-control-user" name="syllabus_name" id="syllabuspleFirstName" >
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