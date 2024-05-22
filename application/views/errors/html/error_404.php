<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">
.full-height {
    height: 100vh;
}
.code {
    border-right: 2px solid;
    font-size: 26px;
    padding: 0 15px 0 15px;
    text-align: center;
}
.message {
    font-size: 18px;
    text-align: center;
}
</style>
</head>
<body>
	<div id="container">
	    
	    <div class="flex-center position-ref full-height">
            <div class="code">
                <?php echo $heading; ?>            </div>

            <div class="message" style="padding: 10px;">
                  <?php echo $message; ?>          </div>
        </div>
	
	</div>
</body>
</html>