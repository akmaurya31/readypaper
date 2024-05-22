        <style>
        .mb-30 p{
            color:#ff0000;
        }
        </style> 
        
            <div class="other-page-area mt-100">
                <img src="<?= base_url()?>assets/frantweb/plan.jpeg" class="img-fluid"> 
            </div> 

<div class="facts-area about-page-fact position-relative over-hidden">
                <div class="about-page2-fact-bg position-absolute w-100 h-100 z-index-1 " style="background: #fff;"></div>
                <div class="container-fluid pt-60 pb-50">
                    <div class="row justify-content-center">
                        <div class="col-xl-7 col-lg-9 col-md-10 col-sm-12 col-12">
                            <div class="title text-center mb-30">
                                <h2 class=" mb-20"><span class="f-700">Select a Plan</span></h2>
                                   </div><!-- /title -->
                        </div><!-- /col -->
                    </div><!-- /row -->

                      <div class="row package-wrapper justify-content-center">
                          <div class="table-responsive">
                          <table class="table  table-striped- table-bordered ">
                      <?php $i=1;foreach($getPlan as $val){
                      if($i==1){ $color="danger";}elseif($i==2){ $color="info"; }else{ $color="success";}
                      ?>
                      <tr>
                      <td class="text-<?= $color?>"><?= $val->heading?></td>
                       <td>₹<?= $val->plan_price + $val->gst?></td>
                        <td><?= $val->validity?> Month</td>
                         <td><ul class="">
                                       <?php $list = subject_list_teacher($val->heading);
                                       foreach($list as $value){?>
                                        <li class="d-inline-block d-flex align-items-center">
                                            <span class="primary-color d-block pr-15">
                                                <span class="d-inline-block"><i class="fa fa-check-circle text-<?= $color?>"></i></span>
                                            </span>
                                            <p class="main-color mb-0"><?= subjectName($value->subject_id)?></p>
                                        </li>
                                        <?php } ?>
                                        <li class="d-inline-block d-flex align-items-center">
                                            <span class="primary-color d-block pr-15">
                                                <span class="d-inline-block"><i class="fa fa-check-circle text-<?= $color?>"></i></span>
                                            </span>
                                            <p class="main-color mb-0">Paper Quantity <?= $val->pepar_qty?></p>
                                        </li>
                                        <li class="d-inline-block d-flex align-items-center">
                                            <span class="primary-color d-block pr-15">
                                                <span class="d-inline-block"><i class="fa fa-check-circle text-<?= $color?>"></i></span>
                                            </span>
                                            <p class="main-color mb-0">Validity  <?= $val->validity?> Month</p>
                                        </li>
                                        <li class="d-inline-block d-flex align-items-center">
                                            <span class="primary-color d-block pr-15">
                                                <span class="d-inline-block"><i class="fa fa-check-circle text-<?= $color?>"></i></span>
                                            </span>
                                            <p class="main-color mb-0">Plan Expired   <?= date('d M, Y',strtotime($val->end_date))?></p>
                                        </li>
                                    </ul></td>
                                    
                                    <td>
                                         <?php $role = $this->session->userdata('role');
                                         
                                         if($role=='teacher'){?>
                                          <?php $attributes = array('class' => 'default-form', 'id' => 'myform');
                                   echo form_open_multipart("buynow", $attributes);?>
                                   
                                           <input name="plangst" id="plangst" type="hidden" value="<?= $val->gst?>" >
                                            <input name="planprice" id="planprice" type="hidden" value="<?= $val->plan_price?>" >
                                            
                                          <input name="amount" id="amount" type="hidden" value="<?= $val->price?>" >
                                          <input name="plan_name" id="plan_name" type="hidden" value="<?= $val->heading?>" >
                                          <input name="plan_id" id="plan_id" type="hidden" value="<?= $val->id?>" >
                                          
                                          <input name="plan_start_date" id="plan_start_date" type="hidden" value="<?= $val->start_date?>" >
                                          <input name="plan_end_date" id="plan_end_date" type="hidden" value="<?= $val->end_date?>" >
                                          <input name="plan_validity" id="plan_validity" type="hidden" value="<?= $val->validity?>" >
                                          <input name="plan_pepar_qty" id="plan_pepar_qty" type="hidden" value="<?= $val->pepar_qty?>" >
                                          
                                            <input name="subject_id" id="subject_id" type="hidden" value="<?= $val->subject_id?>" >
                                            
                                          
                                       <!-- <input type="button" class="btn btn-success" onclick="getpayment()" value="Buy">-->
                                       <input type="submit" class="btn btn-info btn-fill btn-wd"  name="submit_button" id="submit_button" value="BUY NOW"></input>
                                         </form>
                                        <?php } else{?>
                                        <a href="<?= base_url()?>teacherlogin" class="btn w-100 text-uppercase">Shop Now</a>
                                        <?php }?>
                                        
                                        
                                        </td>
                      
                      
                        
                        
                        </tr>
                        <?php $i++;} ?>
                        
                        </table>
                       </div>
                        
                         <div class="col-sm-4"></div>
                        <div class=" col-sm-8 bg-warning pt-10 pb-10" style="border-radius: 24px;">
                            <h5>Get 10% off <span class="text-white"> 3 Months Contact</span> Get 20% off  <span class="text-white"> 6 Months Contact</span></h5>
                        </div>
                    </div>
                   
                </div><!-- /container -->
            </div>

<script>
function getpayment(){
   // alert();
   
   
   var formData = {
     plangst:$("#plangst").val(),
                planprice:$("#planprice").val(),
                orderid:$("#amount").val(),
                plan_name:$("#plan_name").val(),
                plan_id:$("#plan_id").val(),
                plan_start_date:$("#plan_start_date").val(),
                plan_end_date:$("#plan_end_date").val(),
                plan_validity:$("#plan_validity").val(),
                plan_pepar_qty:$("#plan_pepar_qty").val(),
                subject_id:$("#subject_id").val(),
                
};

$.ajax({
    url: "<?php echo base_url()?>home/BuyNow",
    type: "POST",
    contentType: "application/json",  // Set content type to JSON
    data: JSON.stringify(formData),  // Convert data to JSON string
    success: function(data) {
        // Handle success
        alert(data);
    },
    error: function(error) {
        // Handle error
        console.error(error);
    }
});


}
</script>
