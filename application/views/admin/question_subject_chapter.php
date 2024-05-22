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
			

			

		</div>
	</form>
</div>
                    <div class="card-body">
                         <button href="#" class="btn btn-warning"  style="width:100%" onclick="download_table_as_csv('my_id_table_to_export');">Download as CSV</button>
                          <?php if(@$_GET['qtype']){?>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered my_id_table_to_export" id="table">
                                <thead>
                                    <tr>
                                    <th>S.no</th>
                                    <th>Question</th>
                                    <th>Question Type</th>
                                    <th>Currect Answer</th>
                                     <th>Answer Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; 
                                         $countQuestion=0;
                                    foreach($getQuestion_list as $val){ ?>
                                    <tr>
                                       <td><?= $i?></td>
                                      <td><?= $val->question_name?></td>
                                       <td><?= $val->answer1?><br>
                                             <?= $val->answer1?><br>
                                             <?= $val->answer1?><br>
                                             <?= $val->answer1?></td>
                                       <td> <?= $val->currect_ans?></td>  
                                        <td> <?= $val->description_answer?></td>  
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

function getClassName(id)
{
    
   window.location.href = '<?= base_url()?>admin_question_list/question_subject_chapter?class='+id;
}


function getSubject(id)
{
    window.location.href = '<?= base_url()?>admin_question_list/question_subject_chapter?class=<?= @$_GET['class']?>&subject='+id;
}


function getCapter(id)
{
    window.location.href = '<?= base_url()?>admin_question_list/question_subject_chapter?class=<?= @$_GET['class']?>&subject=<?= @$_GET['subject']?>&qtype='+id;
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