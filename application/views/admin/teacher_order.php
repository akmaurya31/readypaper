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
                         <button href="#" class="btn btn-warning"  style="width:100%" onclick="download_table_as_csv('my_id_table_to_export');">Download as CSV</button>
                         
                        
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
                                       $customerRes = customerName($val->teacher_id);
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
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





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