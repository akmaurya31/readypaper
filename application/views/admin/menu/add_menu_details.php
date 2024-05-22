<!--**********************************
Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href=""><?= $title ?></a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">
			<?php menu($_GET['menu_id'])?></a></li>
			</ol>
		</div>
		<!-- row -->

		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow ">
					<div class="card-body">
						<?php $attributes = array('class' => '', 'id' => 'myform');
						echo form_open_multipart("admin_menu_details/menusAdd?menu_id={$_GET['menu_id']}", $attributes); ?>

						<div class="row">

							<div class="col-md-3">
								<div class="form-group">
									<label>Menu Images</label>
									<input type="file" name="pic" class="form-control border-input" value="">
								</div>
							</div>
							
								<div class="col-md-3">
								<div class="form-group">
									<label>Bg Images</label>
									<input type="file" name="bg_image" class="form-control border-input" value="">
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group">
									<label>Heading</label>
									<input type="text" name="heading" class="form-control border-input" value="<?php echo set_value('heading') ?>">
									<?php echo form_error('heading'); ?>
								</div>

							</div>
						</div>

						<div class="row pt-2">
							<div class="col-md-12">
								<div class="form-group ">
									<label>Content</label>
									<textarea id="editor1" name="content" rows="10" cols="80"> <?php echo set_value('content') ?></textarea>
								</div>
							</div>
						</div>


						<div class="">
							<button type="submit" class="btn btn-info btn-fill btn-wd">Submit </button>
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
