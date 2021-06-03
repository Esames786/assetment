<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {



    public function __construct()
    {
        parent::__construct();
        $this->load->model('AuthModel');

    }


    public function login(){


        $JwtSecretKey =  $this->config->item('JwtSecretKey');



         $email = $this->input->post('email');

         $password = $this->input->post('password');



        $result =  $this->AuthModel->check_login($email,$password);

        $jwt = new JWT();

//        $JwtSecretKey  = ;

        $token = $jwt->encode($result,$JwtSecretKey,'HS256');

        ECHO $token;

    }



//    public function index()
//    {
//        $this->load->view('welcome_message');
//    }





    public  function token(){
        $jwt = new JWT();

        $JwtSecretKey = "Mysecretwordshere";

        $data = array(
            'userId'=>145,
            'email'=>'aamir@gmail.com',
            'userType'=>'admin',

        );
        $token = $jwt->encode($data,$JwtSecretKey,'HS256');
        ECHO $token;
    }

    public  function decode_token($token){

        $token = $this->uri->segment(3);
        $jwt = new JWT();



        $JwtSecretKey = "Mysecretwordshere";

        $decode_token = $jwt->decode($token,$JwtSecretKey,'HS256');
//        echo '<pre>';
//        print_r($decode_token);

        $json = $jwt->jsonEncode($decode_token);
        echo $json;





    }


}
