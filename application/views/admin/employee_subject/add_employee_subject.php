<!--**********************************
Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
	

		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow ">
					<div class="card-body">
						<?php 
						$classid = @$_GET['classid'];
						$employee_id = @$_GET['employee_id'];
						$section_id = @$_GET['section_id'];
						$attributes = array('class' => '', 'id' => 'myform');
						echo form_open_multipart("admin_employee_subject/employee_subject_add?classid={$classid}&section_id={$section_id}&employee_id={$employee_id}", $attributes); ?>

						<div class="row">
						    
						    
						      <!-- <div class="form-group  mb-3 col-sm-4">
                   
                   <select name="class_id" class="form-control" onchange="getClass(this.value)" required >
                        <option value="">Select Class</option>
                        <?php foreach ($getClass as $val) { ?>
                            <option value="<?= $val->id ?>" <?php if(@$_GET['classid']==$val->id){ echo "selected";}?> ><?= $val->class_name ?></option>
                        <?php } ?>
                    </select>
                       
                        <span class="help-block"></span>
                 </div>-->
                 
                    <div class="form-group  mb-3 col-sm-4">
                   
                   
                          <select name="employee_id" class="form-control" onchange="getEmployee(this.value)" required >
										<option value="">Select Employee</option>
										<?php foreach ($getemployees as $val) { ?>
											<option value="<?= $val->id ?>" <?php if(@$_GET['employee_id']==$val->id){ echo "selected";}?>>
											    <?= $val->firstName.'('.ucwords($val->role).')' ?></option>
										<?php } ?>
									</select>
									<?php echo form_error('employee_id'); ?>
                 </div>
                 
                 <?php if(@$_GET['employee_id']!=''){ //@$_GET['classid']!='' &&?>  
                 
					 <div class="form-group mb-3">   
                    <label>Subject Name:- </label> 
                    <?php 
                    foreach ($getSubject as $val) { 
                    $count = checkSubjectAssign($val->id, $_GET['employee_id']);
                    if ($count === 0){?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="subject_id" name="subject_id[]" value="<?= $val->id ?>">
                            <label class="form-check-label" for="inlineCheckbox1"><?= $val->subject_name ?></label>
                        </div>
                    <?php } } ?>

 
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

function getClass(id)
{
    window.location.href = '<?= base_url()?>admin_employee_subject/employee_subject_add?classid='+id;
}

function getEmployee(id)
{
    window.location.href = '<?= base_url()?>admin_employee_subject/employee_subject_add?employee_id='+id; //classid=<?= @$_GET['classid']?>&
}

</script>
