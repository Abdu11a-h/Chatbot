<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public $loggedInUser;
    public $data;
    public $site_title = SITE_TITLE;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('common');
        $method                     = $this->router->fetch_method();
        $class                      = $this->router->fetch_class();
        $this->loggedInUser         = $this->session->userdata('admin');
        $this->data['page_method']  = $method;
        $this->data['class']        = $class;
        $this->data['is_404']       = FALSE;
        $this->data['site_title']   = $this->site_title;
        $this->data['session_data'] = $this->loggedInUser;
        if (isset($this->loggedInUser['name'])) {
            $this->data['username'] = $this->loggedInUser['name'];
        }
    }
    public function index()
    {
        $this->data['page_title'] = "Chatbot";
        $this->data['all_messages']=$this->common_model->getTableData('messages', "*");
        $this->load->view('WebsiteViewFiles/index', $this->data);
    }
    public function admin_side()
    {
        $this->data['page_title'] = "Chatbot";
        $this->data['all_messages']=$this->common_model->getTableData('messages', "*");
        $this->load->view('WebsiteViewFiles/admin_side', $this->data);
    }


   

    
}
