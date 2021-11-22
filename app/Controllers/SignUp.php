<?php

namespace App\Controllers;

class SignUp extends BaseController
{
    public function new()
    {
        return view('SignUp/new.php');
    }

    public function create(){
        $userDetails = $this->request->getPost();

        $user = new \App\Entities\User($userDetails);
       
        $UserModel = new \App\Models\UserModel();

        $user->startActivation();

        if($UserModel->insert($user)){
            $this->sendActivationEmail($user);
            echo 'Signup Success';
        }else{
            return redirect()->back()
                             ->with('errors',$UserModel->errors())
                             ->withInput();
        }
        
    }


    public function activate($token){
        $UserModel = new \App\Models\UserModel();
        $UserModel->activateByToken($token);

        return view('SignUp/activated.php');
    }

    private function sendActivationEmail($user){
        $email = service('email');

        $email->setTo($user->user_email);

        $email->setSubject('Account Validation');

        $message=view('Signup/activation_email',['token'=>$user->token]);

        $email->setMessage($message);

        $email->send();
    }
}
