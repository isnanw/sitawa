<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Template
{
    protected $_ci;

    function __construct()
    {
        $this->_ci = &get_instance();
    }

    function render_page($content, $data = NULL)
    {
        $this->_ci->load->view('app/header', $data);
        $this->_ci->load->view($content, $data);
        $this->_ci->load->view('app/topmenu', $data);
        $this->_ci->load->view('app/sidemenu', $data);
        $this->_ci->load->view('app/footer', $data);
    }
}
