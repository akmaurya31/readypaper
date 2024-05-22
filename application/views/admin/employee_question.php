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
	 <form  id="form" >

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
			
			<div class="col-sm-3">
				<label>Capter Name</label>
				<select class="form-control" name="qtype" onchange="getCapter(this.value)" required>
                    <option value="">Select</option>
                    <?php foreach($getChapter as $val){?>
                    <option value="<?= $val->id?>" <?php if(@$_GET['qtype']==$val->id){ echo "selected";}?> ><?= $val->chapter_name?></option>
                    <?php } ?>
				</select>
			</div>
			
	<div class="col-sm-3">
				<label>Date</label>
			<input type="date"  name="dates" class="form-control"  onchange="getDate(this.value)" value="<?= @$_GET['dates']?>" required>
			</div>
			

		</div>
	</form>
</div>
                    <div class="card-body">
                         <button href="#" class="btn btn-warning"  style="width:100%" onclick="download_table_as_csv('my_id_table_to_export');">Download as CSV</button>
                          <?php if(@$_GET['dates']){?>
                        
                        <div class="table-responsive">
                           <table class="table table-striped table-bordered" id="table">
                                    <thead>
                                    <tr>
                                        <!--<th style="">S.No</th>-->
                                         <th style="width:6%">Action</th>
                                        <th  style="width:30%">Question <br> Question A,B,C,D</th>
                                        <th  style="width:10%">Currect Answer</th>
                                        <th  style="width:30%">Answer Description</th>
                                         <th style="width:6%">Created By</th>
                                        </tr>
                                <tbody>
                                    <?php $i=1; 
                                         $countQuestion=0;
                                    foreach($getQuestion_list as $val){ ?>
                                    <tr>
                                      <!-- <td><?= $i?></td>-->
                                       <td><a href="javascript:void(0)" class="btn btn-warning " title="Status Inactive" id="2440" onclick="getstatusUpdate(<?= $val->id?>)"> <i class="fa fa-exclamation-triangle"></i></a></td>
                                       
                                      <td><?= $val->question_name?><br><?= $val->answer1?><br>
                                             <?= $val->answer1?><br>
                                             <?= $val->answer1?><br>
                                             <?= $val->answer1?></td>
                                       <td> <?= $val->currect_ans?></td>  
                                        <td> <?= $val->description_answer?></td>  
                                         <td><?= teacherName($val->created_by)?></td>
                                    </tr>
                                    
                                   <?php $i++;$countQuestion++;} 
                                   echo "Total number of iterations: " . $countQuestion;
                                   ?>
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


<script>


function getstatusUpdate(id){
     $.ajax({
        url : "<?= base_url()?>employee_question/getstatusUpdate",
        type: "POST",
        data: {
            id:id
        },
        
        success: function(data)
        {
            alert("Question Approved Successfully");
            location.reload();
           //alert(data);
        },
        
    });
}

function getClassName(id)
{
    
   window.location.href = '<?= base_url()?>employee_question?class='+id;
}


function getSubject(id)
{
    window.location.href = '<?= base_url()?>employee_question?class=<?= @$_GET['class']?>&subject='+id;
}


function getCapter(id)
{
    window.location.href = '<?= base_url()?>employee_question?class=<?= @$_GET['class']?>&subject=<?= @$_GET['subject']?>&qtype='+id;
}

function getDate(id)
{
    window.location.href = '<?= base_url()?>employee_question?class=<?= @$_GET['class']?>&subject=<?= @$_GET['subject']?>&qtype=<?= @$_GET['qtype']?>&dates='+id;
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