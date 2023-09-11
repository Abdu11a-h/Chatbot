<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminFunctions extends CI_Controller
{

    public $loggedInUser;
    public $data;
    public $site_title = SITE_TITLE;


    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->library('session');
        //$this->load->library('database');
        $this->load->helper('url');
        $this->load->helper('common');

        $this->load->library('form_validation');
        $this->form_validation->set_message('is_natural', 'Only numeric values are allowed in %s.');
        $this->form_validation->set_message('required', 'Please enter %s.');
        $this->form_validation->set_message('valid_email', 'Please enter a valid %s.');

        $method                     = $this->router->fetch_method();
        $class                      = $this->router->fetch_class();
        $this->loggedInUser         = $this->session->userdata('admin');
        $this->data['page_method']  = $method;
        $this->data['class']        = $class;
        $this->data['is_404']       = FALSE;
        $this->data['site_title']   = $this->site_title;
        $this->data['session_data'] = $this->loggedInUser;

    }



    public function index() {
    }

    protected function cleanPostValue($value)
    {
        return trim($value);
    }

    public function add_message_user()
    {
        // pre($_POST);die();
        $message=$_POST['message'];
        $name=$_POST['name'];

        $info['message'] = (string) $message;
        $info['name'] = (string) $name;
        $info['role'] = 'user';
        $info['timestamp'] = date("Y-m-d",time());


        $this->common_model->insert_data($info, 'messages');
        $data['success'] = TRUE;
        $this->output->set_output(json_encode($data));
    }

    public function add_message_admin()
    {
        // pre($_POST);die();
        $message=$_POST['message'];
        $name=$_POST['name'];

        $info['message'] = (string) $message;
        $info['name'] = (string) $name;
        $info['role'] = 'admin';
        $info['timestamp'] = date("Y-m-d",time());


        $this->common_model->insert_data($info, 'messages');
        $data['success'] = TRUE;
        $this->output->set_output(json_encode($data));
    }
    public function get_data()
    {
       
        $data['messages']= $this->common_model->getTableData('messages', "*");

        // pre($this->data['all_messages']);die();

        $data['success'] = TRUE;
        // $data['message'] = '12';
        // $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($data));
    }



   


}