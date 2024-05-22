
<div class="content-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow ">
					<div class="card-body">
						<div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                            <th>S.no</th>  
                                            <th>Action</th>
                                            <th>Exam Name</th>
                                            <th>Class </th> 
                                            <th>Subject </th> 
                                            <th>Pepar Type</th>
                                             <th>Group Exam</th>
                                             <th>Total Mark</th>
                                             <th>Duration</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <?php $i=1;foreach($getTeacherExam_list as $val){?>
                                    <tr>
                                         <td><?= $i?></td>
                                        <td><div class="dropdown">
						<button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown">
							<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
						</button>
						<div class="dropdown-menu">
						    <?php //$check = checkPeparCapter($val->cpid)?>
							<a class="dropdown-item" href="<?= base_url()?>teacher_capter?pepar_id=<?= base64_encode($val->cpid)?>"> Capter</a>  
						<a class="dropdown-item" href="<?= base_url()?>edit_teacher_pepar?pepar_id=<?= base64_encode($val->cpid)?>"> Edit Question Type</a>  
						
						</div>
					</div></td>
                                         <td><?= $val->exam_name?></td>
                                         <td><?= className($val->class_id)?></td>
                                          <td><?= subjectName($val->subject_id)?></td>
                                          <td><?= $val->ename?></td>
                                          <td><?= $val->group_exam_name?></td>
                                          <td>0</td>
                                          <td>00:00 hh:mm</td>
                                          <td><?= date('d M Y H:i:s',strtotime($val->cdate))?> </td><!---->
                                    </tr>
                                    <?php $i++;} ?>
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

