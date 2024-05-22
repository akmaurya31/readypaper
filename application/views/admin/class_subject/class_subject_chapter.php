<!--**********************************
Content body start
***********************************-->
<div class="content-body">
<div class="container-fluid">
   

    <div class="row">
    <div class="col-lg-12">
       <!-- DataTales Example -->
       <div class="card shadow mb-4">
          
                     <div class="card-body">

	 <form  id="form" class="" method="">

		<div class="row">
			
				<div class="col-sm-3">
				<label>Class</label>
				<select class="form-control" name="class"  required>
                    <option value="">Select</option>
                    <?php foreach($getClass as $val){?>
                    <option value="<?= $val->id?>" <?php if(@$_GET['class']==$val->id){ echo "selected";}?>><?= $val->class_name?></option>
                    <?php } ?>
				</select>
			</div>
			
				<div class="col-sm-3">
				<label>Subject</label>
				<select class="form-control" name="subject"  >
                    <option value="">Select</option>
                    <?php foreach($getSubject as $val){?>
                    <option value="<?= $val->id?>" <?php if(@$_GET['subject']==$val->id){ echo "selected";}?>><?= $val->subject_name?></option>
                    <?php } ?>
				</select>
			</div>
	
<div class="col-sm-3">
				<div class="form-group">
					<label>.</label>
				<input type="submit" class="btn btn-primary form-control-" style="width:100%;    padding: 13px;" name="submit" value="Submit">
				</div>
			</div>
			

		</div>
	</form>

</div>
                    
                    
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table-">
                                    <thead>
                                    <tr class="bg-warning">
                                            <th>S.no</th>   
                                            <th>Action</th>
                                             <th>Board</th>
                                             <th>Class </th>  
                                             <th>Subject</th> 
                                            <th>Create Date</th>
                                            
                                        </tr>
                                        
                                        
                                        <?php 
                                        $i=1;
                                        foreach($getClass_Subject as $class_subject){
                                         $subjectStyles = [
                                1 => '#ff0000',
                                3 => '#c3989f',
                                4 => '#145650',
                                5 => '#129d9b',
                                12 => '#422dc6',
                                13 => '#814435',
                                14 => '#4e6e4e',
                                16 => '#f72b50',
                                17 => '#607d8b',
                                18 => '#795548',
                                23 => '#ffc107',
                                24 => '#2196f3',
                                25 => '#673ab7',
                                26 => '#6e6e6e',
                                27 => '#ffa755',
                                28 => '#68e365',
                                29 => '#145650',
                                30 => '#0a0ae7',
                                31 => '#d653c1',
                            ];
                                         $color = isset($subjectStyles[$class_subject->subject_id]) ? $subjectStyles[$class_subject->subject_id] : 'text-primary';
                                         $status = isset($class_subject->status) && $class_subject->status == 'Y' ? 'N' : 'Y';
                                       
                                        if ($class_subject->status == 'Y')
            $statusIs = '<a href="javascript:void(0)" class="btn btn-success " title="Status Active" id="' . $class_subject->id . '" onclick="statusUpdate_clSub(' . "'" . $class_subject->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-info-circle"></i></a>';
        else
            $statusIs = '<a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="' . $class_subject->id . '" onclick="statusUpdate_clSub(' . "'" . $class_subject->id . "'" . "," . "'" . $status . "'" . ')"> <i class="fa fa-exclamation-triangle"></i></a>';
           
                                        ?>
                                        <tr>
                                            <th><?= $i?></th>   
                                            <th>
                                            
                                               
            <?= $statusIs.' <a href="admin_chapter?clas_sub_id='.$class_subject->id.'" class="btn btn-warning" title="Add chapter"> <i class="fa fa-plus"></i></a> '; 
            
                                            ?></th>
                                             <th><?php boardName($class_subject->board_id)?></th>
                                             <th><?php className($class_subject->class_id)?> </th> 
                                             
                                             
                                             <th> 
                                             <a href="javascript:;" style="color:<?= $color?>"><?php  subjectName($class_subject->subject_id)?></a>
                                             </th> 
                                            <th><?= date('d/M/Y', strtotime($class_subject->created_at))?></th>
                                            
                                        </tr>
                                        <?php $i++;} ?>
                                        
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
    var controllerListUrl = '<?php// echo site_url('admin_classsub_chapter/ajax_list') ?>';
    var statusUrl = '<?php echo site_url('admin_classsub_chapter/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_classsub_chapter/ajax_delete') ?>";

</script>
<script>
function statusUpdate_clSub(id,status){
    //alert(id);alert(status);
                        $.ajax({
                            url: '<?= base_url() ?>admin_classsub_chapter/statusUpdate_clSub',
                            type: "post",
                            data: {
                                id:id,
                                status:status
                            },
                            success: function(data) {
                                alert("Data Successfuly");
                                location.reload();
                            }
                        });
    
}

</script>

