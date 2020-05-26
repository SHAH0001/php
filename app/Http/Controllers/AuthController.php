<?php

namespace App\Http\Controllers;

use Valitron\Validator;
use Core\View;
use App\User;
use Core\Str;

use Core\Middleware\Auth;

class AuthController
{
    protected $errors = [];

    protected $path = '/';

    public function showLoginForm()
    {
        if(Auth::check()) {
            return redirect($this->path);
        }
        return View::render('auth\\login');
    }

    public function showRegisterForm()
    {
        if(Auth::check()) {
            return redirect($this->path);
        }
        return View::render('auth\\register');
    }

    protected function checkRuleData($email, $password)
    {
        $user = User::getUser($email, md5($password));

        if($user) {
            $this->authUser($user);
        }

        $this->errors['error_auth'] = 'Неверные данные для авторизации';
        return View::render('auth\\login', ['errors' => $this->errors]);
    }

    protected function unique($email)
    {
        if(User::where('email', $email)) {
            $this->errors['email'] = ['Этот email адрес уже занят'];
            return false;
        }

        return true;
    }

    protected function authUser($user)
    {
        $_SESSION['auth_user'] = [
            'id' => $user->id,
            'email' => $user->email,
            'remember_token' => $user->remember_token,
        ];

        return redirect('/admin/home');
    }

    public function logout()
    {
        if(isset($_SESSION['auth_user'])) {
            session_destroy();
            redirect($this->path);
        }
    }

    public function login()
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $v = new Validator(['email' => $email, 'password' => $password]);

        $v->rule('required', ['email', 'password']);
        
        $v->rule('email', 'email');

        if(isset($_SESSION['auth_user'])) {
            session_unset($_SESSION['auth_user']);
        }

        if($v->validate()) {
            return $this->checkRuleData($email, $password);
        }
        
        $this->errors = $v->errors();
        return View::render('auth\\login', ['errors' => $this->errors]);
    }

    public function register()
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if(!$this->unique($email)) {
            return View::render('auth\\register', ['errors' => $this->errors]);
        }

        $v = new Validator(['email' => $email, 'password' => $password]);

        $v->rule('required', ['email', 'password']);
        
        $v->rule('email', 'email');

        $v->rule('lengthMin', 'password', 3);
        
        if($v->validate()) {
            User::createUser([
                'email' => $email,
                'password' => md5($password)
            ]);
            $user = User::where('email', $email);

            $this->authUser($user);
        } 
            
        $this->errors = $v->errors();
        return View::render('auth\\register', ['errors' => $this->errors]);
    }
}