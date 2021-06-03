<?php

class AuthModel extends CI_Model{


    function check_login($email,$password){



        $query = $this->db
            ->select('email,password')
            ->from('user')
            ->where('email',$email)
            ->where('password',$password);

        // return $query->result();

        $query = $this->db->get();

        if ($query->num_rows())
        {
            return $query->result();
        }else{
            return [];
        }


    }

    function profile($email,$token){



        $query = $this->db
            ->select('email,token')
            ->from('user')
            ->where('email',$email)
            ->where('token',$token);

        // return $query->result();

        $query = $this->db->get();

        if ($query->num_rows())
        {
            return $query->result();
        }else{
            return [];
        }


    }


    function insert($data){

        $this->db->insert('user',$data);
        if($this->db->affected_rows() > 0) {
            return '1';
        }else{
            return '';
        }

    }

    public function updateRecord($data,$email)
    {
        $this->db->where('email', $email);
        $this->db->update('user',$data);
        if($this->db->affected_rows() > 0) {
            return '1';
        }else{
            return '';
        }
    }

}

