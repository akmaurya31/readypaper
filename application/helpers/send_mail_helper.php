<?php

function print_dir($in,$depth)
{
    foreach ($in as $k => $v)
    {
        if (!is_array($v))
            echo "<p>",str_repeat("&nbsp;&nbsp;&nbsp;",$depth)," ",$v," [file]</p>";
        else
            echo "<p>",str_repeat("&nbsp;&nbsp;&nbsp;",$depth)," <b>",$k,"</b> [directory]</p>",print_dir($v,$depth+1);
    }
}

print_dir($map,0);


function send_emails(){
$CI =& get_instance();
$CI->load->library('email');
$CI->load->controller('EmailController');
$CI->EmailController->sendAutomaticEmails();
}


