<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthRegister implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        // if (!session()->get('member_username')) {
        //     return redirect()->to('member/login');
        // }
        if (!session()->get('akun_username')) {
            return redirect()->to('register');
        }
        // if (!session()->get('akun_username')) {
        //     return redirect()->to('admin/login');
        // }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}