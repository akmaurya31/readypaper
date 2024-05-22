<!--**********************************
Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href=""><?= $title ?></a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Plan</a></li>
			</ol>
		</div>
		<!-- row -->

		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow ">
					<div class="card-body">
						<?php $attributes = array('class' => '', 'id' => 'myform');
						echo form_open_multipart("admin_service_plan/menusAdd", $attributes); ?>

						<div class="row">
<div class="col-md-12">
        								<div class="form-group">
        									<label>Subject</label><br>
        								<?php foreach($getSubject as $val){?>
        								          <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="checkbox" id="subject_id" name="subject_id[]" value="<?= $val->id ?>">
                                                  <label class="form-check-label" for="inlineCheckbox1"><?= $val->subject_name ?></label>
                                                </div>
        								<?php }?>
        								</div>
        							</div>
        							</div>	
        							<div class="row">	
        							
							<div class="col-md-3 pt-3">
								<div class="form-group">
									<label>Plan Images</label>
									<input type="file" name="pic" class="form-control border-input" value="">
								</div>
							</div>
							
								
							
							<div class="col-md-4 pt-3">
								<div class="form-group">
									<label>Plan Name</label>
									<input type="text" name="heading" class="form-control border-input" value="<?php echo set_value('heading') ?>">
									<?php echo form_error('heading'); ?>
								</div>

							</div>

								<div class="col-md-3 pt-3">
								<div class="form-group">
									<label>Paper Quantity</label>
									<input type="text" name="pepar_qty" class="form-control border-input" value="<?php echo set_value('pepar_qty') ?>">
								</div>
							</div>
						</div>
						
						
							<div class="row">
        							
        						
							
								<div class="col-md-3 pt-3">
								<div class="form-group">
									<label>Start Date</label>
									<input type="date" name="start_date" class="form-control border-input" value="<?php echo set_value('start_date') ?>">
								</div>
							</div>
							
								<div class="col-md-3 pt-3">
								<div class="form-group">
									<label>End Date</label>
									<input type="date" name="end_date" class="form-control border-input" value="<?php echo set_value('end_date') ?>">
								</div>
							</div>
							
								<div class="col-md-3 pt-3">
								<div class="form-group">
									<label>Plan validity (In Month)</label>
									<select name="validity" class="form-control">
                                            
                                                    <option value="3">3 Month</option>
                                                    <option value="6">6 Month</option>
                                                    <option value="12">12 Month</option>
                                                    <option value="24">24 Month</option>
                                                     <option value="36">26 Month</option>
                                                      <option value="48">48 Month</option>
                                            </select>
								
								</div>
							</div>
							
							<div class="col-md-3 pt-3">
								<div class="form-group">
									<label>Plan Price</label>
									<input type="text" name="plan_price" class="form-control border-input" value="<?php echo set_value('plan_price') ?>">
								</div>
							</div>
							
								<div class="col-md-3 pt-3">
								<div class="form-group">
									<label>GST</label>
									<input type="text" name="gst" class="form-control border-input" value="<?php echo set_value('gst') ?>">
								</div>
							</div>
							
								<div class="col-md-3 pt-3">
								<div class="form-group">
									<label>Total Amount</label>
									<input type="text" name="price" class="form-control border-input" value="<?php echo set_value('price') ?>">
								</div>
							</div>
        						
        							<div class="col-md-3 pt-3">
								<div class="form-group">
									<label>Teacher Free Plan</label>
									<select name="free_plan" class="form-control">
                                            
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                            </select>
								
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
