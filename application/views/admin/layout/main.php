<?php

$this->load->view('admin/layout/common/header');
if (isset($this->session->userdata['role'])) {

    if ($this->session->userdata['role'] == 'admin' || 
        $this->session->userdata['role'] == 'employee' || 
        $this->session->userdata['role'] == 'super_employee') {
        $this->load->view('admin/layout/common/leftside');
    }elseif ($this->session->userdata['role'] == 'teacher') {
        $this->load->view('admin/layout/common/leftside');
    
    }
}
$this->load->view($include);
if (isset($model)) {
    $this->load->view($model);
}
$this->load->view('admin/layout/common/footer');

