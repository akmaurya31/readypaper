<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_contact extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->model('contact_model', 'contact');
	    $this->load->model('Admin_profile_model', 'admin');

    }
    
	

	public function index()
	{
	$data['title'] = "ReadyPaper";
		$data['description'] = "";
		$data['keyword'] = "";		
	    $data['include'] = 'web_frant/contact';
		$data['title'] = "Contact Us";
		
		if ($this->form_validation->run('contact_us')){
		   $emailId =  $this->input->post('email');
		 $data = array( 
                'massge' => $this->input->post('description'),
                'name'=>$this->input->post('username'),
                'mobile_no'=>$this->input->post('mobile_no'),
                'email'=>$this->input->post('email'),
               
              );
              
      
                    $insert = $this->contact->save($data);
         
				
				        if($insert){
				            $getFile = $this->contact->get_by_id($insert);
                $adminRow_Name = $this->admin->get_by_id(1);
                 $to =  $getFile->email.',readypaperldh@gmail.com'; 
                $subject = "Contcat Query For ReadyPepar";
                $from = 'info@readypaper.in';             // Pass here your mail id

                $emailContent = '<!DOCTYPE>
                <html>
                <head></head>
                <body>
                <p>Hello ' . $getFile->name . '</p>
                 <p></p>
               
                <p>Mobile ' . $getFile->mobile_no . '</p>
                 <p>Email Id ' . $getFile->email . '</p>
                  <p>Message ' . $getFile->massge . '</p>
               ';

               
                $emailContent .= "<p>Thank You.</p>
                </body>
                </html>";
 $config['protocol']    = 'smtp';
                $config['smtp_host']    = 'mail.readypaper.in';
                $config['smtp_port']    = '25';
                $config['smtp_timeout'] = '60';

                $config['smtp_user']    = 'info@readypaper.in';    //Important
                $config['smtp_pass']    = 'Paika@12#3';  //Important

                $config['charset']    = 'utf-8';
                $config['newline']    = "\r\n";
                $config['crlf'] = "\r\n";
                $config['mailtype'] = 'html'; // or html
                $config['validation'] = TRUE; // bool whether to validate email or not 


                $this->email->initialize($config);
                $this->email->set_mailtype("html");
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($emailContent);
                //echo $this->email->send();die;
 if ($this->email->send()) {
                     $this->session->set_flashdata('massege_contact', 'Your Query  Successfully Send');	
                    redirect("contact-us");
                } else {
                    show_error($this->email->print_debugger());
                }
                
				        }
		}
		
		
    	$data['getadmin'] = $this->admin->get_by_id(1);
       $this->load->view("web_frant/layout/main", $data);
	}
	
	
	
}
