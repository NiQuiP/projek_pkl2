<?php 
 
 namespace App\Validations;

 class CustomRules 
 {
    function check_old_password (string $str, string &$error = null ):bool
    {
        $member = new \App\Models\MemberModel();
        if (empty($str)){
            return true;
        }

        $email = session()->get('member_email');
        $dataMember = $member->where('email', $email)->first();

        $password = $dataMember['password'];

        if ($str == $password){
            return true;
        } else {
            return false;
        }
    }
 }