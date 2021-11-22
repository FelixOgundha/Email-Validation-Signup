<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function testMail(){
        $email = service('email');

        $email->setTo('felix.ogundha@gmail.com');

        $email->setSubject('A test email');

        $email->setMessage('<h1>Ozalaki Misato Maguu</h1>');

        if($email->send()){
            echo 'seccess';
        }else{
            echo $email->printDebugger();
        }
    }
}
