<!--**********************************
Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <?php $attributes = array('class' => '', 'id' => 'myform');
                        echo form_open_multipart("person/teacherprofile", $attributes); ?>

                        <div class="row">
 <div class="col-md-4">
                                <div class="form-group mb-3">
                                        <label class="control-label">Teacher Image</label>
                                    <img style="width:10%" src="<?php echo base_url()?>upload/<?php echo $proResult->logo; ?>">
                                   
									<input type="hidden" name="pichidden" value="<?php echo $proResult->logo; ?>"/>	
									<input type="file" name="pic" class="form-control border-input" value="<?php echo $proResult->logo; ?>">
                                </div>

                            </div>
                            <div class="col-md-4">

                                <div class="form-group mb-3">
                                      <label class="control-label">User Name</label>
                                    <input type="text" class="form-control form-control-user" name="username" id="exampleFirstName" value="<?= $proResult->username?>">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                      <label class="control-label">Password</label>
                                    <input name="password" placeholder="Password" class="form-control" type="text">
                                    <input type="hidden" name="passwordhide" value="<?= $proResult->password?>">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                           
                          
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                     <label class="control-label">Teacher Name</label>
                                    <input name="firstName" placeholder="Teacher Name" class="form-control" type="text" value="<?= $proResult->firstName?>">
                                    	<?php echo form_error('firstName'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="control-label">Mobile Number</label>
                                    <input type="text" class="form-control form-control-user" name="mobile_no" id="exampleInputEmail" value="<?= $proResult->mobile_no?>">
                                    <span class="help-block"></span>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="control-label">Email Id</label>
                                    <input name="emailId" placeholder="Email Id" class="form-control" type="text" value="<?= $proResult->email?>">
                                    <span class="help-block"></span>
                                </div>

                            </div>
                            <div class="col-md-4">


                                <div class="form-group mb-3">
                                    <label class="control-label">Gender</label>
                                    <input name="gender" placeholder="Gender" class="form-control" type="text" value="<?= $proResult->gender?>">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                             <div class="col-md-4">


                                <div class="form-group mb-3">
                                    <label class="control-label">DOB</label>
                                    <input name="dob" placeholder="Gender" class="form-control" type="date" value="<?= $proResult->dob?>">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">


                                <div class="form-group mb-3">
                                    <label class="control-label">State</label>
                                    <select class=" form-control wide mb-3" name="state" id="state" style="line-height: 33px;" onclick="getstate(this.value)">
                                        <?php foreach ($get_active_state as $val) { ?>
                                            <option value="<?= $val->id ?>"<?php if($proResult->state==$val->id){ echo "selected";}?>><?= $val->state_name ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>

                                <!-- <div class="form-group mb-3">
                    <input name="city" placeholder="City" class="form-control" type="text">
                                <span class="help-block"></span>                    
                    </div>-->
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="control-label">District </label>
                                    <select class=" form-control wide mb-3" name="district" id="district" style="line-height: 33px;">
                                     <?php foreach ($get_state_quota as $val) { ?>
                                            <option value="<?= $val->id ?>"<?php if($proResult->district==$val->id){ echo "selected";}?>><?= $val->state_quota_name ?></option>
                                        <?php } ?>
                                    </select> <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="control-label">Pincode </label>
                                    <input name="pincode" placeholder="pincode" class="form-control" type="text" value="<?= $proResult->pincode?>">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="control-label">Address </label>
                                    <textarea name="address" placeholder="Address" class="form-control"><?= $proResult->address?></textarea>

                                </div>
                            </div>

	<div class="">
							<button type="submit" class="btn btn-info btn-fill btn-wd">Submit </button>
						</div>

                            <script>
                                function getstate(id) {
                                    //alert(id);
                                    $.ajax({
                                        url: '<?= base_url() ?>authaccess/getstate',
                                        type: 'post',
                                        data: {
                                            id: id,
                                        },
                                        success: function(msg) {
                                            //console.log(data);
                                            $("#district").html(msg);

                                        }
                                    });
                                }
                            </script>


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