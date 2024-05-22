<!--**********************************
Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url()?>admin_service_plan"><?= $title ?></a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">
		Edit Plan</a></li>
			</ol>
		</div>
		<!-- row -->

		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow ">
					<div class="card-body">
						<?php $attributes = array('class' => '', 'id' => 'myform');
						echo form_open_multipart("admin_service_plan/menusEdit?editId={$_GET['editId']}", $attributes); ?>

						<div class="row">

							<div class="col-md-3">
			
								<div class="form-group">
									<label>Plan Images</label>
									<img style="width:20%" src="<?php echo base_url()?>upload/teacher/<?php echo $proResult->logo; ?>">
                                   
									<input type="hidden" name="pichidden" value="<?php echo $proResult->logo; ?>"/>	
									<input type="file" name="pic" class="form-control border-input" value="<?php echo $proResult->logo; ?>">
									
								</div>
							</div>
							
					
							
							
							<div class="col-md-6">
								<div class="form-group">
									<label>Plan Name</label>
									<input type="text" name="heading" class="form-control border-input" value="<?php echo $proResult->heading?>">
									<?php echo form_error('heading'); ?>
								</div>

							</div>

									
							<div class="col-md-3">
								<div class="form-group">
									<label>Plan Price</label>
									<input type="text" name="price" class="form-control border-input" value="<?php echo $proResult->price?>">
									<?php echo form_error('price'); ?>
								</div>

							</div>
						</div>

						<div class="row pt-2">
							<div class="col-md-12">
								<div class="form-group ">
									<label>Content</label>
									<textarea id="editor1" name="content" rows="10" cols="80"> <?php echo $proResult->content?></textarea>
								</div>
							</div>
						</div>


						<div class="">
							<button type="submit" class="btn btn-info btn-fill btn-wd">Update </button>
						</div>
						<div class="clearfix"></div>
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
