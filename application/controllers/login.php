<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
        //load library validation
        $this->load->library('form_validation');
        //set rule validation
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash');
        $this->form_validation->set_rules('password', 'Password', 'required');
        //jika tidak valid
        if ($this->form_validation->run() == FALSE)
        {
            //tampilkan status error
            $response['status']=false;
            $response['message']=strip_tags(validation_errors());
        }
        else
        {
            $username=$this->input->post('username');
            $password=$this->input->post('password');
            $this->db->where('username',$username);
            $this->db->where('password',md5($password));
            $users=$this->db->get('ms_spg');
            if($users->num_rows()>0){
                $this->session->set_userdata('login',true);
                $response['status']=true;
                $response['message']="login success";
            }else{
                $response['status']=false;
                $response['message']="invalid username/password";
            }
        }
        echo json_encode($response);die;
    }
}
