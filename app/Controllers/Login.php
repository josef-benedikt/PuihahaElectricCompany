<?php
namespace App\Controllers;
use App\Models\User;

class Login extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login - Puihaha Electric',
            'page' => 'login'
        ];
        return view('login', $data);
    }

    public function authenticate()
    {
        $session = session();
        $userModel = new User();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->findByEmail($email);

        if ($user) {
            if ($userModel->verifyPassword($password, $user['password'])) {
                $ses_data = [
                    'id'         => $user['id'],
                    'first_name' => $user['first_name'],
                    'email'      => $user['email'],
                    'user_type'  => $user['user_type'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);

                return redirect()->to($user['user_type'] === 'admin' ? '/admin' : '/');
            } else {
                $session->setFlashdata('error', 'Incorrect password.');
                return redirect()->back();
            }
        } else {
            $session->setFlashdata('error', 'Email not found.');
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}