<?php
    $this->load->view('app/header');
    echo $body;
    $this->load->view('app/topmenu');
    $this->load->view('app/sidemenu');
    $this->load->view('app/footer');
?>