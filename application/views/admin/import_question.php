<!--**********************************
Content body start
***********************************-->
<div class="content-body">
<div class="container-fluid">
    <div class="row page-titles">
       
        <a href="javascript:void(0)"> <small style="color:red">Note: CSV Formate (Question Type,
Exercise,
Currect Answer,
Currect Answer 2,
Question,
Question A,
Question B,
Question c,
Question D,
Answer Description)</small></a> 
<a href="<?= base_url()?>assets/Book 2.csv" download class="btn btn-warning btn-fill btn-wd">Download File Formate</a>
    </div>
    <!-- row -->

    <div class="row">
    <div class="col-lg-12">
    <!-- DataTales Example -->
	<div class="card shadow mb-4">
                     
                     <div class="card-body">
                         <?php $attributes = array('class' => 'form-horizontal', 'id' => 'myform');
                      echo form_open_multipart("admin_import_question/insert?chapter_id={$_GET['chapter_id']}&clas_sub_id={$_GET['clas_sub_id']}", $attributes);?>
                      
                        <div class="box-body">
                              <div class="row"> 
   <div class="col-md-3">
			<div class="form-group">
			<label>Import Question File ( CSV )</label>
			<input type="file" name="file" id="file" size="150">
			</div>
		</div>
                           
   <div class="col-md-2">
	<label class="pb-4"></label>
                                <input type="submit" class="btn btn-info btn-fill btn-wd" name="sunmit" value="Submit" >
                            </div>
  
   </div>
                                    </div>
                                </div>


                            </div>
                            <!-- /.box-body -->
                           
                            <!-- /.box-footer -->
                    </form>
                     </div>
                 </div>
        </div>
    </div>
</div>
</div>
<!--**********************************
Content body end
***********************************-->


    