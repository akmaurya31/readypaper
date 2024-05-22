<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
	    $this->load->model('Admin_profile_model', 'admin');
    }
    
public function sendAutomaticEmails() {
    $date = date('m-d');
      $teacherDOB = $this->admin->get_TeacherDOB_role($date);
    if($teacherDOB){
//echo $this->db->last_query();die;
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

    // Load email library
    //$this->load->library('email');

    foreach ($teacherDOB as $teacher) {
        $to = $teacher->email;//'sejwal4anuj@gmail.com';
        $subject = "Happy Birthday from ReadyPepar";
        $from = 'info@readypaper.in';

        $emailContent = '<html>
<head>
<title>birthday</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bgcolor="#eec7b6" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- Save for Web Slices (birthday.psd) -->
<table id="Table_01" width="650" height="900" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td colspan="3" align="left" valign="top">
			<img src="https://readypaper.in/assets/bod_images/birthday_01.jpg" style="line-height: 0;  display: block;" width="650" height="163" alt="" border="0"></td>
	</tr>
	<tr>
		<td align="left" valign="top">
			<img src="https://readypaper.in/assets/bod_images/birthday_02.jpg" style="line-height: 0;  display: block;" width="123" height="38" alt="" border="0"></td>
		<td width="386" height="38" bgcolor="#eee4d8" align="center" valign="top">
			<font style=" font-size:20px;font-weight:bolder;color:#ee6764;background:#eee4d8; font-family: Gotham, Helvetica Neue, Helvetica, Arial, sans-serif">Dear '.ucwords($teacher->firstName).'</font>
		</td>
		<td align="left" valign="top">
			<img src="https://readypaper.in/assets/bod_images/birthday_04.jpg" style="line-height: 0;  display: block;" width="141" height="38" alt="" border="0"></td>
	</tr>
	<tr>
		<td colspan="3" align="left" valign="top">
			<img src="https://readypaper.in/assets/bod_images/birthday_05.jpg" style="line-height: 0;  display: block;" width="650" height="699" alt="" border="0"></td>
	</tr>
</table>
<!-- End Save for Web Slices -->
        
        
        
<h3>Regards & Thank you<br>
ReadyPaper<br>
Mo.No.- +91-9417467890<br>
Website:- www.readypaper.in<br>
Address:- Ludhiana, Punjab 141008 India</h3>

</body>
</html>';

        // Initialize email configuration
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        
        $this->email->message($emailContent);

        // Send email
        if ($this->email->send()) {
            // Success message
            $this->session->set_flashdata('message_contact', 'Your Query Successfully Sent');
        } else {
            // Error message
            show_error($this->email->print_debugger());
        }
    }

    // Redirect after the loop
    redirect('/');
    }else{
        echo "No Data Found";
    }
}



public function shell_exection(){
    //mysqldump -e --user=username --password='password' dbname | gzip | uuencode sql_backup.gz | sh /home/myuser/mail_alert.sh
    try {
         $current_datetime = date('Ymd'); 
    $shell_exec = shell_exec("/usr/bin/mysqldump -u readybgh_rajanreadpaper -p'=C*Se5J;]Ra5' readybgh_readpaper > /home4/readybgh/readypaper.in/sqlbackup/readpaperdb`date +$current_datetime`.txt");

//if($shell_exec){
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'mail.readypaper.in';
        $config['smtp_port']    = '25';
        $config['smtp_timeout'] = '60';
        $config['smtp_user']    = 'info@readypaper.in';
        $config['smtp_pass']    = 'Paika@12#3';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['crlf'] = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['wordwrap'] = TRUE; // bool whether to validate email or not 
       
        
       // Email content
        $to = 'prashantpatel2105@gmail.com';
        $subject = "ReadyPepar Sql Backup";
        $from = 'info@readypaper.in';
        $emailContent = '<!DOCTYPE>
            <html>
            <head></head>
            <body>
            <h2>Sir,</h2>
            <h2>Best regards,</h2>
            <h3>Readypaper</h3>
            </body>
            </html>';
        
         $folder_path = base_url().'/sqlbackup/';
         $file_path = $folder_path . 'readpaperdb' . $current_datetime . '.txt';
         // Initialize email configuration
         
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($emailContent);
        $this->email->attach($file_path);


        try{
        // Send email
       $res= $this->email->send();
       print_r($res);
        if ($res) {
             
        //unlink($file_path);
        echo "File deleted successfully";
    
            
        } else {
            // Error message
            show_error($this->email->print_debugger());
        }
        }catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
     }
        //redirect('/');
//}


} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
   }
}
