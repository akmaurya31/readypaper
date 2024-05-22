<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->model('Slider_model', 'slider');
		$this->load->model('Testimonials_model', 'testimonial');
        $this->load->model('Teacher_ads_model', 'teacher_ads');
		$this->load->model('Menu_content_model', 'menu_content');
		$this->load->model('Menu_model', 'menu');
	    $this->load->model('Plan_model', 'plan');
	      $this->load->model('Order_model', 'order');
	   }
    
	

	public function index()
	{
		$data['title'] = "ReadyPaper";
		$data['description'] = "";
		$data['keyword'] = "";		
		$data['include'] = 'web_frant/home';
		$data['getSlider'] = $this->slider->getActiveSlider();
		$data['getSliderInactive'] = $this->slider->getInactiveSlider();
		$data['getSchool'] = $this->menu_content->getActivecontent(3);
        $data['getProduct'] = $this->menu_content->getActivecontent(12);
	    $data['getSchoolAds'] =  $this->teacher_ads->getActiveAds_limit();
		$data['getTestimonialsresult'] = $this->testimonial->getTestimonialsValue();
		$date = date('Y-m-d');
		$data['getPlan'] = $this->plan->getActivePlan_Date_limit($date);
		//echo $this->db->last_query();die;
        $this->load->view("web_frant/layout/main", $data);
	}
	
		public function About_us()
	{
				
		$data['getmenuRow'] = $this->menu->get_by_id(1);
		$data['title'] = $data['getmenuRow']->title;
		$data['description'] = $data['getmenuRow']->description;
		$data['keyword'] = $data['getmenuRow']->metakey;
		
		$data['getAbout'] = $this->menu_content->getActivecontent($data['getmenuRow']->id);
		$data['getTestimonialsresult'] = $this->testimonial->getTestimonialsValue();
		$data['include'] = 'web_frant/about';		
        $this->load->view("web_frant/layout/main", $data);
	}


		public function Price_product()
	{
	    $data['title'] = "Readypaper";
		$data['description'] = "";
		$data['keyword'] = "";		
	    $date = date('Y-m-d');
		$data['getPlan'] = $this->plan->getActivePlan_Date($date);
		//echo $this->db->last_query();
		
		$data['include'] = 'web_frant/price';		
        $this->load->view("web_frant/layout/main", $data);
	}
	
	
	 public function BuyNow() {
            //print_r($this->input->post()); die;
	    
            $merchantId = 'M22GVTI724034'; 
            $apiKey = "0142f178-dac0-4807-9f95-9cbfa8fa66f2";
           
           
            $redirectUrl = 'https://readypaper.in/paymentsuccess/';
             
            // Set transaction details
            $order_id = uniqid(); 
            $id = $this->session->userdata('id');
            $name = $this->session->userdata('firstName');
            $email=$this->session->userdata('email');
            $mobile=$this->session->userdata('mobile_no');
            $plangst=$this->input->post('plangst');
            $price = $this->input->post('planprice');
            
            $amount = $price+$plangst;
            
            $plan_name=$this->input->post('plan_name');
            $plan_id=$this->input->post('plan_id');
            $plan_start_date=$this->input->post('plan_start_date');
            $plan_end_date=$this->input->post('plan_end_date');
            $plan_validity=$this->input->post('plan_validity');
            $plan_pepar_qty=$this->input->post('plan_pepar_qty');
            
            $pepar_qty=$this->input->post('plan_pepar_qty');
            $subject_id=$this->input->post('subject_id');
            
            $description = 'Booking Payments For readypaper';
             
            $paymentData = array(
                'merchantId' => $merchantId,
                'merchantTransactionId' =>rand(10,100).uniqid(), // test transactionID
                "merchantUserId"=>uniqid(),
                'amount' => $amount*100,
                'redirectUrl'=>$redirectUrl,
                'redirectMode'=>"POST",
                'callbackUrl'=>$redirectUrl,
                "merchantOrderId"=>$order_id,
                "param3"=>$mobile,
                "message"=>$description,
                "param2"=>$email,
                "param1"=>$name,
                "param4"=>$id,
                "paymentInstrument"=> array(    
                "type"=> "PAY_PAGE",
              )
            );
            
            
            $paymentsavedata = array(
                    //'merchantId' => $merchantId,
                    'merchantTransactionId' =>rand(10,100)."-".$order_id, // test transactionID
                    "merchantUserId"=>$order_id,
                    "merchantOrderId"=>$order_id,
                    "mobileNumber"=>$mobile,
                    "name"=>$name,
                    "email"=>$email,
                    "plangst"=>$plangst,
                    "amount"=>$price,
                    "planprice"=>$price,
                    "plan_id"=>$plan_id,
                    "plan_name"=>$plan_name,
                    "plan_start_date"=>$plan_start_date,
                    "plan_end_date"=>$plan_end_date,
                    "plan_validity"=>$plan_validity,
                    "qty_less_plan"=>$plan_pepar_qty,
                    "plan_pepar_qty"=>$plan_pepar_qty,
                    "plan_subject_id"=>$subject_id,
                    "teacher_id"=>$id,
                    'total_amount'=>$amount,
                    );
                  $res = $this->order->save($paymentsavedata);
            
             $jsonencode = json_encode($paymentData);
             $payloadMain = base64_encode($jsonencode);
             
             $salt_index = 1; //key index 1
             $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
             $sha256 = hash("sha256", $payload);
             $final_x_header = $sha256 . '###' . $salt_index;
             $request = json_encode(array('request'=>$payloadMain));
                            
                $curl = curl_init();
                curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/pay",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $request,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                     "X-VERIFY: " . $final_x_header,
                     "accept: application/json"
                    ],
                ]);
                 
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                  echo "cURL Error #:" . $err;
                } else {
                   $res = json_decode($response);
                 
                if(isset($res->success) && $res->success=='1'){
                $paymentCode=$res->code;
                $paymentMsg=$res->message;
                $payUrl=$res->data->instrumentResponse->redirectInfo->url;
                header('Location:'.$payUrl) ;
                } }       
    }
	
	

	
	public function Policy($id)
	{
	    
		$parm = str_replace('-',' ',$id);
		$data['getmenuRow'] = $this->menu->getActivemenuRow($parm);
	
		$data['title'] = $data['getmenuRow']->title;
		$data['description'] = $data['getmenuRow']->description;
		$data['keyword'] = $data['getmenuRow']->metakey;
		$data['getActiveteResult'] = $this->menu_content->getActivecontent($data['getmenuRow']->id);
		
		$data['include'] = 'web_frant/policy';		
        $this->load->view("web_frant/layout/main", $data);
	}
	
	
	
	


	
}
