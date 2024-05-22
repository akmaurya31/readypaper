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
   <div class="row page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="<?= base_url()?>admin_classsub_chapter">Chapter Subjects</a></li>
						<li class="breadcrumb-item"><a class="text-warning" href="<?= base_url()?>admin_chapter?clas_sub_id=<?= $_GET['clas_sub_id']?>"><?php class_subName($_GET['clas_sub_id'])?></a></li>
							<li class="breadcrumb-item"><a href="javascript:void(0)"><?php chapterName($_GET['chapter_id'])?></a></li>
					</ol>
                </div>
    <div class="row">
    <div class="col-lg-12">
    
       <div class="card shadow mb-4">
                    
                        
                          <div class="card-header py-3">
                     <a href="<?php echo base_url()?>admin_question/all_list?chapter_id=<?= $_GET['chapter_id']?>&clas_sub_id=<?= $_GET['clas_sub_id']?>" 
                     class="d-none d-sm-inline-block btn  btn-primary shadow-sm" ><span class="btn-icon-start text-secondary"><i class="fa fa-plus color-info  color-secondary"></i> </span> Create Question </a>
                     <?php $role = $this->session->userdata('role');
                        if($role=='admin' || $role=='super_employee' || $role=='employee'){?>
            &nbsp <a href="<?php echo base_url()?>admin_import_question?chapter_id=<?= $_GET['chapter_id']?>&clas_sub_id=<?= $_GET['clas_sub_id']?>" class="btn btn-warning" title="Import Questions"> <i class="fa fa-file-excel"></i></a>
            &nbsp <a href="<?php echo base_url()?>admin_import_question/export?chapter_id=<?= $_GET['chapter_id']?>&clas_sub_id=<?= $_GET['clas_sub_id']?>" class="btn btn-secondary" title="Export Questions"> <i class="fa fa-file-excel"></i></a>
                        <?php  }
                        ?>
                      </div>
                    
                    
                    
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                           <th style="width:5%">S.No</th>
                                                 <th style="width:15%">Action<br>Created By</th>
                                                <!--<th style="width:15%">Chapter</th>-->
                                                <th  style="width:80%">Question <br>Answer(Description)</th>
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
    var controllerListUrl = '<?php echo site_url('admin_question/ajax_list?chapter_id='.$_GET['chapter_id'].'&clas_sub_id='.$_GET['clas_sub_id']) ?>';
    var statusUrl = '<?php echo site_url('admin_question/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_question/ajax_delete') ?>";
 </script>
	

