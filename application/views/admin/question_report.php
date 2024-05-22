<div class="content-body">
<div class="container-fluid">
   <div class="row">
    <div class="col-lg-12">
     <div class="card shadow mb-4">
         
         
         
                     <div class="card-body">
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                           <th style="">S.No</th>
                                                
                                                 <th style="width:6%">Created By</th>
                                                 <th style="width:6%">Created Date</th>
                                                <th style="width:15%">Chapter</th>
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
    var controllerListUrl = '<?php echo site_url('count_question_report/ajax_list?emp='.$_GET['emp'].'&dates='.$_GET['dates'].'&days='.$_GET['days']) ?>';
    var statusUrl = '<?php echo site_url('admin_question/activeInactivestatusUpdate') ?>';
    var deleteUrl = "<?php echo site_url('admin_question/ajax_delete') ?>";
 </script>
