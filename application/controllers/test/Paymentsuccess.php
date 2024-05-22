<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentsuccess extends MY_Controller {
    
     public function index() {
        
     //echo "<pre>"; print_r($_POST);die;

           $this->load->model('order_model', 'order');
           
            $merchantOrderId =  $this->input->post('merchantOrderId');
            $lastId = $this->order->get_by_transactionId($merchantOrderId);
            
           $method = $lastId->id;
           $teacher_id = $lastId->teacher_id;
           $plan_validity = $lastId->plan_validity;
           $perches_date =  date('Y-m-d', strtotime($teacher_id .'+'.$plan_validity.'month'));
          
           $update = array(
                    'code' =>$this->input->post('code'),
                    'total_amount' => $this->input->post('amount')/100,
                    "checksum"=>$this->input->post('checksum'),
                    'merchantTransactionId' =>$this->input->post('transactionId'),
                    'providerReferenceId' =>$this->input->post('providerReferenceId'),
                    'perches_date' =>$perches_date
                    );
                  $res = $this->order->update(array('merchantOrderId' => $this->input->post('merchantOrderId')), $update);
                  if($res){
                       if($this->input->post('code')=='PAYMENT_SUCCESS'){
                           mailSend_Pdf($method,$teacher_id);
                          }else{
                              return redirect('price');
                          }
                     }
         
     }
}

