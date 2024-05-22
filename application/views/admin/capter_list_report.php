<div class="content-body">
	<div class="container-fluid">
	    		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow ">
				    
				    
				                   <div class="card-body">

	 <form  id="form" class="" method="">

		<div class="row">
				<div class="col-sm-3">
				<label>Class</label>
				<select class="form-control" name="class"  id="class" onchange="getClassName(this.value)"  required>
                    <option value="">Select</option>
                    <?php foreach($getClass as $val){?>
                    <option value="<?= $val->id?>" <?php if(@$_GET['class']==$val->id){ echo "selected";}?>><?= $val->class_name?></option>
                    <?php } ?>
				</select>
			</div>
			
				<div class="col-sm-3">
				<label>Subject</label>
				<select class="form-control" name="subject" onchange="getSubject(this.value)"  required>
                    <option value="">Select</option>
                    <?php foreach($getSubject as $val){?>
                    <option value="<?= $val->id?>" <?php if(@$_GET['subject']==$val->id){ echo "selected";}?>><?= $val->subject_name?></option>
                    <?php } ?>
				</select>
			</div>
		</div>
	</form>

</div>




      <div class="card-body">
                         <?php 	
						if(@$_GET['subject']){
						
						$getTeacherPepar = countChapterQuestion($_GET['class'],$_GET['subject'],3);
						if($getTeacherPepar){?>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered my_id_table_to_export" id="table">
                                <thead>
                                    <tr>
                                    <th>S.no</th>
                                    <th> CAPTER <?php //className($_GET['class'])?>  <?php //subjectName($_GET['subject'])?></th>
                                    <th>Total Question</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; 
                                         
                                    foreach($getTeacherPepar as $val){ ?>
                                    <tr>
                                       <td><?= $i?></td>
                                      <td><?= $val->chapter_name?></td>
                                       <td> (<?php questioncount($val->id)?>)<br>
                                             
                                    </tr>
                                      <?php $i++;}?>
                                </tbody>
                            </table>
                        </div>
                    
                        
                        <?php } } ?>
                    </div>
                    
                    
                    
				    
				    
				
				</div>
			</div>
		</div>
	</div>
</div>
<script>

function getClassName(id)
{
    
   window.location.href = '<?= base_url()?>admin_capter_list?class='+id;
}


function getSubject(id)
{
    window.location.href = '<?= base_url()?>admin_capter_list?class=<?= @$_GET['class']?>&subject='+id;
}



</script>