<?php

namespace App\Filters;

use App\Models\MemberModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FilterRole implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        // Do something here
        $session = session();
        $user = new MemberModel();
        $sesi_nis = $session->get('member_nim_nis');
        $userRole = $user->where('nim_nis', $sesi_nis)->first();
        if ($session->get('logged_in')) {
            if ($userRole['level'] == '3' && $session->get('redirected') != 'user') {
                $session->set('redirected', 'user');
                return redirect()->to('user/my-profile');
            } else if ($userRole['level'] == '2' && $session->get('redirected') != 'admin') {
                $session->set('redirected', 'admin');
                return redirect()->to('admin/dashboard');
            } else if ($userRole['level'] == '1  ' && $session->get('redirected') != 'superadmin') {
                $session->set('redirected', 'superadmin');
                return redirect()->to('admin/dashboard');
            }
        } else {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}