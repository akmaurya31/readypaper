 <?php $role = $this->session->userdata('role'); 
                         if($role=='admin'){?>
                    
                                   
<div class="content-body">
	<div class="container-fluid">
	

		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow ">
					<div class="card-body">
						<?php 
						$sub = @$_GET['sub'];
						$attributes = array('class' => '', 'id' => 'myform');
						echo form_open_multipart("admin_class_subject/class_subject_add?sub={$sub}", $attributes); ?>

						<div class="row">
						    
						    <div class="col-sm-3 form-group  mb-3">
                   
                   <select name="board_id" class="form-control" onchange="getBoard(this.value)">
                        <option value="">Select Board</option>
                        <?php foreach ($getboard_type as $val) { ?>
                            <option value="<?= $val->id ?>" <?php if(@$_GET['board_id']==$val->id){ echo "selected";}?> ><?= $val->board_type_name ?></option>
                        <?php } ?>
                    </select>
                       
                        <span class="help-block"></span>
                 </div>
						    
						       <div class="col-sm-3 form-group  mb-3">
                   
                   <select name="class_id" class="form-control" onchange="getSubject(this.value)">
                        <option value="">Select Class</option>
                        <?php foreach ($getClass as $val) { ?>
                            <option value="<?= $val->id ?>" <?php if(@$_GET['sub']==$val->id){ echo "selected";}?> ><?= $val->class_name ?></option>
                        <?php } ?>
                    </select>
                       
                        <span class="help-block"></span>
                 </div>
                 
                 <?php if(@$_GET['sub']){?>
                 
					 <div class="form-group mb-3">   
                    <label>Subject Name:- </label> 
                     <?php 
                     $count=0;
                     foreach ($getSubject as $val) {
                         
                     $count=checkSubjectId($val->id,$_GET['sub']);
                     if($count==0){?>
                     
                   <div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" id="subject_id" name="subject_id[]" value="<?= $val->id ?>">
  <label class="form-check-label" for="inlineCheckbox1"><?= $val->subject_name ?></label>
</div>

 <?php }} ?>
 
                           <span class="help-block"></span>
                    </div> 
						</div>
					
						<div class="">
							<button type="submit" class="btn btn-info btn-fill btn-wd">Submit</button>
						</div>
						<?php } ?>
						<div class="clearfix"></div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--**********************************
Content body end
***********************************-->

<script>
function getBoard(id)
{
    window.location.href = '<?= base_url()?>admin_class_subject/class_subject_add?board_id='+id;
}
function getSubject(id)
{
    window.location.href = '<?= base_url()?>admin_class_subject/class_subject_add?board_id=<?= @$_GET['board_id']?>&sub='+id;
}
</script>
 <?php } ?>
