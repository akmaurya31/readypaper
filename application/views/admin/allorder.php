<style>
.table tbody tr td {
    font-size: 15px;
}
</style>
<div class="content-body">
    <div class="container-fluid">


        <div class="row">
            <div class="col-lg-12">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    
                    <div class="card-body">

	 <form  id="form" class="" method="">

		<div class="row">
			<!--<div class="col-sm-3">
				<label>Order Status</label>
				<select class="form-control" name="qstatus" onchange="">
                    <option value="">Select</option>
                    <option value="1" <?php if(1==@$_GET['qstatus']){ echo "selected";}?>>All</option>
                    
				</select>
			</div>-->
			   <div  class="col-lg-3">
          <div class="form-group">
              <label>Starting Date</label>
              <input type="date" name="starting_date" class="form-control border-input" value="<?= @$_GET['starting_date']?>" required>
          </div> 
        </div>
                    <div class="col-sm-3">
       <div class="form-group">
              <label>End Date</label>
              <input type="date" name="ending_date" class="form-control border-input" value="<?= @$_GET['ending_date']?>"  >
          </div>   
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
                         <button href="#" class="btn btn-warning"  style="width:100%" onclick="download_table_as_csv('my_id_table_to_export');">Download as CSV</button>
                          <?php if(@$_GET['starting_date']){?>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered my_id_table_to_export" id="table">
                                <thead>
                                    <tr>
                                    <th>S.no</th>
                                    <th>Customer Details</th>
                                    <th>Plan Name</th>
                                    <th>Order Details</th>
                                     <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;
                                    foreach($allOrder as $val){
                                       $customerRes = customerName($val->cust_id);
                                    ?>
                                    <tr>
                                       <td><?= $i?></td>
                                        <td><span class="text-info-"> <i class="fa fa-user" aria-hidden="true"></i> </span><?= @ucwords($customerRes->firstName)?><br>
                                        <span class="text-info-"> <i class="fa fa-phone" aria-hidden="true"></i> </span><?= @$customerRes->mobile_no?><br>
                                        <span class="text-info-"> <i class="fa fa-envelope" aria-hidden="true"></i> </span><?= @$customerRes->email?></td>
                                      
                                      <td><?= $val->plan_name?><br>
                                     Start:- <?= $val->plan_start_date?><br>
                                     End:- <?= $val->plan_end_date?><br>
                                     Validity:- <?= $val->plan_validity?><br>
                                      Qty:-<?= $val->plan_pepar_qty?></td>
                                      
                                       <td>Purchase Date:- <?= $val->created_at?><br>
                                     Order Id:- <?= $val->merchantTransactionId?><br>
                                     Payment Id:- <?= $val->merchantOrderId?><br>
                                     Transaction Id:-<?php if($val->code!='PAYMENT_SUCCESS'){
                                           echo "<h6 class='text-danger'>NOT PAYMENT</h6>";}
                                           else{ echo $val->providerReferenceId;}?> </td>
                                       <td> RS <?= $val->total_amount?></td>  
                                    </tr>
                                   <?php $i++;} ?>
                                </tbody>
                            </table>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_view" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Modal title</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">
            </button>
         </div>
         <div class="modal-body form">
           <div class="basic-form">
                   <table class="table table-striped table-bordered my_id_table_to_export" id="table">
                        <thead>
                            <tr>
                            <th>S.no</th>
                            <th>Product Name</th>
                            <th>Product Details</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="allData">
                            </tbody>
                    </table>
                </div>
          
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script>
function getViewProduct(order_id,name){
    $("#modal_form_view").modal('show');
    $(".modal-title").text(name);
    
         $.ajax({
                url:"<?php echo base_url(); ?>admin_order/getViewProduct?qstatus="+<?= $_GET['qstatus']?>,
                method:"POST",
                data:{id:order_id},
                success:function(data)
                {     
                   $(".allData").html(data);
                }
            });
    }
    
    
function getQstatus(id,order_id){
    //alert(order_id);
    if(id==1){
         $.ajax({
                url:"<?php echo base_url(); ?>admin_order/delivered_order",
                method:"POST",
                data:{id:order_id},
                success:function(data)
                {     
                   location.reload();
                }
            });
        
    }else{
         if(confirm("Are you sure you want to cancelled product?"))
            {
               
            $.ajax({
                url:"<?php echo base_url(); ?>admin_order/cancle_order",
                method:"POST",
                data:{row_id:order_id},
                success:function(data)
                {     
                location.reload();
                }
            });
            }
            else
            {
            return false;
            }
        
    }
}
</script>


<script>
    // Quick and simple export target #table_id into a csv
    function download_table_as_csv(table_id, separator = ',') {
        // Select rows from table_id
        var rows = document.querySelectorAll('table.' + table_id + ' tr');
        // Construct csv
        var csv = [];
        for (var i = 0; i < rows.length; i++) {
            var row = [],
                cols = rows[i].querySelectorAll('td, th');
            for (var j = 0; j < cols.length; j++) {
                // Clean innertext to remove multiple spaces and jumpline (break csv)
                var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
                data = data.replace(/"/g, '""');
                // Push escaped string
                row.push('"' + data + '"');
            }
            csv.push(row.join(separator));
        }
        var csv_string = csv.join('\n');
        // Download it
        var filename = 'export_' + table_id + '_' + new Date().toLocaleDateString() + '.csv';
        var link = document.createElement('a');
        link.style.display = 'none';
        link.setAttribute('target', '_blank');
        link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>