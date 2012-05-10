<?php
	$this->load->view('site/header');
    !isset($content) ? '' : $this->load->view($content);
	$this->load->view('site/footer');
    !isset($js) ? '' : $this->load->view($js);
?>