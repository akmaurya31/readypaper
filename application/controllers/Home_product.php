<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_product extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->model('Menu_content_model', 'menu_content');
		$this->load->model('Menu_model', 'menu');
	$this->load->model('Testimonials_model', 'testimonial');
        $this->load->model('Teacher_ads_model', 'teacher_ads');
    }
    
	

	public function index($id)
	{
	    $data['title'] = "ReadyPaper";
		$data['description'] = "";
		$data['keyword'] = "";		
	    $data['include'] = 'web_frant/product_details';
	    $name = str_replace('-',' ',$id);
		$data['getmenuRow'] = $this->menu->get_by_id(12);
		$data['getProduct'] = $this->menu_content->getblogsHeadingRes($name);
	    $data['getProductRow'] = $this->menu_content->getblogsHeading($name);
	    $data['getSchoolAds'] =  $this->teacher_ads->getActiveAds_limit();
		$data['getTestimonialsresult'] = $this->testimonial->getTestimonialsValue();
       $this->load->view("web_frant/layout/main", $data);
	}
	
	
	
}
