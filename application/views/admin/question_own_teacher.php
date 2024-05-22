<div class="content-body">
<div class="container-fluid">
  <style>
  .form-group p{
      color:#ff0000;
      display: -webkit-box;
  }
  
    b, strong {
    font-weight: 400;
    font-family: 'poppins', sans-serif;
}
table.dataTable tbody td p math{
    font-size: 14px;
    font-weight: 100;
    font-family: 'poppins', sans-serif;
}
span p{
    display: -webkit-inline-box;
}

.fa-2x {
    font-size: 1.3em;
}
    </style>
 
    <div class="row">
    <div class="col-lg-12">
    
       <div class="card shadow mb-4">
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                           <th style="">S.No</th>
                                                 <th style="width:6%">Action</th>
                                                 <th style="width:6%">Created By</th>
                                                 <th style="width:15%">Class/Subject</th>
                                                <th  style="width:30%">Question / Question A,B,C,D</th>
                                                <th  style="width:10%">Currect Answer</th>
                                                <th  style="width:30%">Answer Description</th>
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
    var controllerListUrl = '<?php echo site_url('question_own_teacher/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('question_own_teacher/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('question_own_teacher/ajax_delete') ?>";
    
    
    function addQuestion(question_own_teacher_id,classId,subjectid,class_sub_id){
         $("#question_own_teacher_id").val(question_own_teacher_id);
         $("#class_sub_id").val(class_sub_id);
         
        $.ajax({
            url : '<?= base_url()?>question_own_teacher/showChapter',
            type: "POST",
            data: {question_own_teacher_id:question_own_teacher_id,
                    classId:classId,
                    subjectid:subjectid,
            }, 
            success: function(data)
            { $("#modal_form").modal('show');
                  $("#chapter_name_id").html(data);
            }
            
        });
    }
    
    function getInsert(){
           //alert($("#question_own_teacher_id").val()),
         $.ajax({
            url : '<?= base_url()?>question_own_teacher/getInsert',
            type: "POST",
            data: {
                   class_sub_id:$("#class_sub_id").val(),
                   chapter_name_id:$("#chapter_name_id").val(),
                   id:$("#question_own_teacher_id").val(),
            }, 
            success: function(data)
            {
                //alert(data);
                alert("Your Question Insert Main Table");
                  $("#modal_form").modal('hide');
                  
            }
            
        });
    }
    
 </script>
	
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title">Question Add Main Table</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body form">
                  <div class="p-3=">  
                <form  id="form" class="user">
                   <input type="hidden" value="" name="id"/> 
                   <input type="hidden" value="" name="question_own_teacher_id" id="question_own_teacher_id"/> 
                    <input type="hidden" value="" name="class_sub_id" id="class_sub_id"/> 
                   <div class="form-group mb-3">
                        <label>Chapter Name*</label>
                            	<select class="form-control form-control-use" name="chapter_name" id="chapter_name_id" ></select>
                           <span class="help-block"></span>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                <button type="button" id="btnSave"  class="btn btn-primary" onclick="getInsert()">Submit</button>
            </div>
                
            </div>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

