<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiController extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('AuthModel');


    }


    public function login()
    {


        $JwtSecretKey = $this->config->item('JwtSecretKey');


        $email = $this->input->post('email');

        $password = $this->input->post('password');


        $result = $this->AuthModel->check_login($email, $password);

        if (count($result) > 0) {

            $jwt = new JWT();
            $token = $jwt->encode($result, $JwtSecretKey, 'HS256');

            $data['token'] = $token;

            $update_token = $this->AuthModel->updateRecord($data, $email);


            $response = array('status' => 200, 'message' => 'success login', 'token' => $token);

            echo json_encode($response);

        } else {

            $response = array('status' => 300, 'message' => 'user not found');

            echo json_encode($response);
        }

    }


    public function register()
    {


        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Password', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() !== FALSE) {

            $JwtSecretKey = $this->config->item('JwtSecretKey');

            $push['email'] = $this->input->post('email');
            $push['password'] = $this->input->post('password');


            $jwt = new JWT();


            $token = $jwt->encode($push, $JwtSecretKey, 'HS256');

            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['password'] = $this->input->post('password');
            $data['status'] = '1';
            $data['token'] = $token;

            $result = $this->AuthModel->insert($data);


            if (!empty($result)) {

                $response = array('status' => 200, 'message' => 'DATA INSERTED SUCCESSFULLY', 'token' => $token);

                echo json_encode($response);

            } else {

                $response = array('status' => 300, 'message' => 'Data Cant Submit');

                echo json_encode($response);
            }

        } else {

            $response = array('status' => 300, 'message' => 'Fields Not Found');

            echo json_encode($response);
        }

    }


    public function profile()
    {


        $JwtSecretKey = $this->config->item('JwtSecretKey');


        $email = $this->input->post('email');

        $token = $this->input->post('token');


        $result = $this->AuthModel->profile($email, $token);

        if (count($result) > 0) {

            $response = array('status' => 200, 'message' => 'Authenticated Profile', 'token' => $result);

            echo json_encode($response);

        } else {

            $response = array('status' => 300, 'message' => 'Profile Not Found');

            echo json_encode($response);
        }

    }





//    public function index()
//    {
//        $this->load->view('welcome_message');
//    }


    public
    function token()
    {
        $jwt = new JWT();

        $JwtSecretKey = "Mysecretwordshere";

        $data = array(
            'userId' => 145,
            'email' => 'aamir@gmail.com',
            'userType' => 'admin',

        );
        $token = $jwt->encode($data, $JwtSecretKey, 'HS256');
        ECHO $token;
    }

    public
    function decode_token($token)
    {

        $token = $this->uri->segment(3);
        $jwt = new JWT();


        $JwtSecretKey = "Mysecretwordshere";

        $decode_token = $jwt->decode($token, $JwtSecretKey, 'HS256');
//        echo '<pre>';
//        print_r($decode_token);

        $json = $jwt->jsonEncode($decode_token);
        echo $json;


    }


}
