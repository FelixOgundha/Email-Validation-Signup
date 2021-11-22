<?php

namespace App\Models;

class UserModel extends \CodeIgniter\Model{
        protected $table = 'user';

        protected $allowedFields = ['user_firstname','user_lastname','user_email','password','activation_hash'];

        protected $returnType = 'App\Entities\User';

        protected $useTimestamps = true;

        protected $beforeInsert = ['user_password'];
        protected $beforeUpdate = ['user_password']; 

        protected $validationRules    = [
            'user_firstname'     => 'required|alpha_numeric_space|min_length[3]',
            'user_lastname'     => 'required|alpha_numeric_space|min_length[3]',
            'user_email'        => 'required|valid_email|is_unique[user.user_email]',
            'password'     => 'required|min_length[8]',
            're_password' => 'required_with[password]|matches[password]',
        ];
    
        protected $validationMessages = [
            'user_email'        => [
                'is_unique' => 'Sorry. That email has already been taken. Please choose another.',
                'required' => ' Please enter your email address',
            ],
            'user_firstname'        => [
                'required' => ' Please enter your first name',
            ],
            'user_lastname'        => [
                'required' => ' Please enter your last name',
            ],
            're_password'        => [
                'matches' => ' The passwords you entered do not match',
            ],
        ];

        protected function user_password(array $data)
        {
            if (! isset($data['data']['password'])) return $data;

            $data['data']['user_password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);

            return $data;
        }

        public function activateByToken($token){
            $token_hash = hash_hmac('sha256', $token, $_ENV['HASH_SECRET_KEY']);

            $user=$this->where('activation_hash',$token_hash)
                       ->first();

           
            if ($user !== null){
                $user->activate();

                $this->protect(false)
                     ->save($user);
            }
        }

}