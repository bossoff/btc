<!DOCTYPE HTML PUBLIC "<?=base_url();?>">
<html lang="en" class="js">
<head>
	 <?php        
        $this->load->view('front/inc/meta'); 
        $this->load->view('front/inc/css');  	
	 ?>
    <script>const BASE_URL = <?='"'.base_url().'"';?></script>
	<title><?=settings('system_name'). ' - ' .$page_title;?></title>
</head>
<body>
    <!-- <div id="loading">
        <img src="<?=base_url();?>assets/images/other/loader.svg" class="loader-img" alt="Loader">
    </div> -->

 	<?php
 		$this->load->view('front/inc/header'); 
        include $page_name.".php";
        $this->load->view('front/inc/footer'); 
        $this->load->view('front/inc/js');
        // $this->load->view('alerts/sweetalert');
     ?>
  
</body>
</html>