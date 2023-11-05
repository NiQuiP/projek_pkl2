<?php

namespace App\Filters;

use App\Models\MemberModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class NoAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        $session = session();
        // if (session()->get('member_username')) {
        //     return redirect()->to('user/my-profile');
        // }
        $user = new MemberModel();
        $sesi_nis = $session->get("member_nim_nis");
        $userRole = $user->where('nim_nis', $sesi_nis)->first();

        if ($session->get("logged_in")) {
            if ($userRole['level'] == '1' or $userRole['level'] == '2') {
                return redirect()->to('admin/dashboard');
            } else if ($userRole['level'] == '3') {
                return redirect()->to('user/my-profile');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}