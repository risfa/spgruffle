<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //load library validation
        $this->load->library('form_validation');
        //set rule validation
        $this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('paket', 'Paket', 'trim|required');
        $this->form_validation->set_rules('phone', 'Paket', 'trim|numeric');
        //jika tidak valid
        if ($this->form_validation->run() == FALSE)
        {
            //tampilkan status error
            $response['status']=false;
            $response['message']=strip_tags(validation_errors());
        }
        else
        {
            $data=array(
                'fullname'=>$this->input->post('fullname'),
                'email'=>$this->input->post('email'),
                'paket'=>$this->input->post('paket'),
                'phone'=>$this->input->post('phone')
            );
            $this->db->where('phone',$this->input->post('phone'));
            $check=$this->db->get('ms_customer');
            if($check->num_rows()>0){
                $response['status']=false;
                $response['message']="you have participated event";
            }else{
                $insert=$this->db->insert('ms_customer',$data);
                if($insert){
                    $response['status']=true;
                    $response['message']="login success";
                }else{
                    $response['status']=false;
                    $response['message']="invalid username/password";
                }
            }
        }
        echo json_encode($response);die;
    }
}
