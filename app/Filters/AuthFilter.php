<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // print_r(session()->get('is_logged_in'));
        if (session()->get('is_logged_in') !== true) {
            // return redirect()->to('/login');
        }
        if (session()->get('is_logged_in') === true) {
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
