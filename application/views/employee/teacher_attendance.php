<!--**********************************
Content body start
***********************************-->
<div class="content-body">
<div class="container-fluid">
    <div class="row page-titles" style="padding: 0.9375rem 0rem;">
        <div class="col-lg-12">
		  <button type="button" class="btn btn-danger btn-xs waves-effect waves-light"> Week Off </button>
          <button type="button" class="btn btn-success btn-xs waves-effect waves-light"> <span>Day present(P)</span> </button>
          <button type="button" class="btn btn-info btn-xs waves-effect waves-light"> <span>Full day present(P)</span> </button>
          <button type="button" class="btn btn-light  btn-xs waves-effect waves-light">No Punch Out(P)</button>
             </div>
    </div>
    <!-- row -->

    <div class="row">
    <div class="col-lg-12">
     <!-- DataTales Example -->
     <div class="card shadow mb-4">
                     <div class="card-header py-3">
                        <div class="form-group col-sm-6">
								<label for="inputEmail3" class="col-sm-3 control-label">Department:</label>
								<div class="col-sm-5">
								    <select class="form-control" name="location"  onchange ="getDepartmentID(this.value)">
								         <option value="">Select  Department:</option>
								        <?php foreach($getdepartments as $val){?>
								           <option value="<?php echo $val->id?>"<?php  if(@$_GET['depid']==$val->id){ echo "selected" ;}  ?> ><?php echo $val->firstName.' ('.$val->role.')'?></option>
								        <?php } ?>
								    </select>
									
								</div>
							</div>
                     </div>
                     
                     
                     	<?php if(isset($_GET['depid']) && $_GET['depid']!=''){
                                $current_date=date("Y-M");
                                $current_date_data=   explode("-",$current_date);   
                                $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
                                $current_date_data=   explode("-",$date); ?>
                     
                     <div class="card-body">
                        <form  class="form-horizontal" method="post">
                         <div class="row">
							<div class="col-sm-1"> <a href="teacher_attendanced?date=<?= date("Y-m",strtotime(date("Y-m", strtotime($_GET['date'])) . " -1 month"))  ?>&&depid=<?php echo $_GET['depid'] ;?>" class="btn btn-info" >Previous</a></div>  
							<div class="col-sm-2 text-center"> <?= date("F-Y", strtotime($_GET['date'])); ?></div>
							<div class="col-sm-1"><a href="teacher_attendanced?date=<?= date("Y-m",strtotime(date("Y-m", strtotime($_GET['date'])) . "+1 month")) ?>&&depid=<?php echo $_GET['depid'] ;?>" class="btn btn-info">Next</a></div>
					     </div>
                        </form>
                         <br>
                         <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                       <tr>
                	    <?php
                	    $month =  $current_date_data['1'];
                	    $year =  $current_date_data['0'];
                	    
                	   		$d=  date('t', mktime(0, 0, 0, $month, 1, $year));// cal_days_in_month(CAL_GREGORIAN,$month,$year);
                			//echo $d;die;
                			
                			date_default_timezone_set("UTC");
                			for($i=0;$i<=$d;$i++)
                			{ 
                			    $date=$year."-".$month."-".$i;
                                $day= date("D",strtotime($date));
                				?>
                				
                        <td><?php 
                           if($i==0){ echo "DAY";
                           }else{  
				              if($day['0'].$day['1']=='Su') {   
				                  echo  "<p  style='color:red'>".$day['0'] ."<br>".$i."</p>";
				              }else{ echo "<p style='color:green'>".$day['0']."<br>".$i."</p>";
				                  
				              } } ?></td>
				   <?php }?>
                        
                      </tr>
                      
                      
                         <tr>
                     
                          <?php  for($j=0;$j<=$d;$j++){ 
                                $date=$year."-".$month."-".$j;
                                $day= date("D",strtotime($date));?>
                            <td>  
				           <?php   if($j==0){  echo "Holidays" ;
				             }else{
				                   if($day['0'].$day['1']=='Su') {   
				                  echo  '<button type="button" style="width: 17px;height: 27px;" class="bg-danger"> 
                                   <span title="">P </span> </button>';
				              }else{
				                  attendance($j,$_GET['date']);
				              }}?></td>
							 <?php }?>
                   
                           </tr>
				  
                                    </thead>
                                    <tbody>
                                </tbody>                           
                                </table>
                         </div>
                     </div>
                     
                     <?php } ?>
                     
                 </div>
        </div>
    </div>
</div>
</div>
<!--**********************************
Content body end
***********************************-->




<!-- Status modal -->
<div class="modal fade" id="myModalStatus" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="heading">Show Details Employee </h3>
               
            </div>
            <div class="modal-body form">
            <table class="table">
  <thead>
  <tbody id="showtable"></tbody>
</table>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</div><!-- /.modal -->

		
		
       <script>
       
       function getIpaddress(dates,day,empid){
           //alert(dates);
        $.ajax({
            type: "post",
            url: "<?php echo base_url();?>teacher_attendanced/getIpaddress",
            data:{'dates':dates ,
                  'day':day,
                  'empid':empid
            },            
            success:function(return_data){
               // alert(return_data);
                $('#myModalStatus').modal('show');
                $("#showtable").html(return_data);
                console.log(return_data);
               // $("modal")
            }
        });

       }
       
          function getDepartmentID(depid){
                window.location.href='teacher_attendanced?depid='+depid+'&date='+'<?php  if(isset($_GET['date'])){ echo date("Y-m");}else{ echo date("Y-m");} ?>'; 
 	
          	}
            </script> 
   


    
    