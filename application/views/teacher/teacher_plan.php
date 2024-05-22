<style>
.new-arrival-content .item {
    font-size: 0.90rem;
}
.content-body .container-fluid, .content-body .container-sm, .content-body .container-md, .content-body .container-lg, .content-body .container-xl, .content-body .container-xxl {
    padding-top: 1.5rem;
    
}
</style>
<div class="content-body">
<div class="container-fluid">
<div class="row">
    <?php 
    $empId = $this->session->userdata('id');
    foreach($getPlan as $val){?>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="new-arrival-product">
                                    <!--<div class="new-arrivals-img-contnent">
                                        <img class="img-fluid" src="<?= base_url()?>uploads/<?= $val->pic?>" alt="<?= ucwords($val->heading)?>">
                                    </div>-->
                                    <div class="new-arrival-content text-center mt-3">
                                          <?php $attributes = array('class' => 'default-form', 'id' => 'myform');
                                   echo form_open_multipart("teacher_plan/teacher_payment", $attributes);?>
                                   
                                        <h4><a href=""><?= ucwords($val->heading)?></a></h4>
                                        <!--<p>Availability: <span class="item text-primary"><?= $val->start_date.' / '.$val->end_date?> </span></p>-->
                                         <p>Availability: <span class="item text-primary"><?= $val->validity?> Month </span></p>
                                        <span class="price">RS <?= $val->price?></span>
                                        <p>Subject:&nbsp;&nbsp;
                                        <?php 
                                            $planRes = subject_list_teacher($val->heading);
                                                foreach($planRes as $value){?>
                                                    <span class="badge badge-primary light"><?= subjectName($value->subject_id)?></span>
                                                    <?php } ?>
                                                </p>
                                                 <p>Paper Quantity: <span class="item text-primary"><?= $val->pepar_qty?> </span></p>
                                               <p><?= $val->content?> </p>
                                            <input name="plangst" id="plangst" type="hidden" value="<?= $val->gst?>" >
                                            <input name="planprice" id="planprice" type="hidden" value="<?= $val->plan_price?>" >
                                            
                                          <input name="amount" id="amount" type="hidden" value="<?= $val->price?>" >
                                          <input name="plan_name" id="plan_name" type="hidden" value="<?= $val->heading?>" >
                                          <input name="plan_id" id="plan_id" type="hidden" value="<?= $val->id?>" >
                                          
                                          <input name="plan_start_date" id="plan_start_date" type="hidden" value="<?= $val->start_date?>" >
                                          <input name="plan_end_date" id="plan_end_date" type="hidden" value="<?= $val->end_date?>" >
                                          <input name="plan_validity" id="plan_validity" type="hidden" value="<?= $val->validity?>" >
                                          <input name="plan_pepar_qty" id="plan_pepar_qty" type="hidden" value="<?= $val->pepar_qty?>" >
                                         <?php $checkPlan = checkActive_TeacherPlan($val->id,$empId);
                                         if($checkPlan){ ?>
                                         <input type="button" class="btn btn-primary btn-block"   name="submit_button" id="submit_button" value="Active Plan"></input>
                                       
                                        <?php } else{?>
                                          <a href="<?= base_url()?>price" class="btn btn-primary btn-block" style="background:#145650" >Buy Now</a>
                                        
                                        <?php }?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   <?php } ?>
                </div>
</div>
</div>
        


