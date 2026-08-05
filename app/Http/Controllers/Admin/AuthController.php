<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    // Simple hardcoded credentials — change these!
    private string $adminUser     = 'cb_admin_5ggx77';
    private string $adminPassword = '8P%yVyQ*8ADMt4X7VpYf';

    public function loginForm()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($request->username === $this->adminUser && $request->password === $this->adminPassword) {
            session(['admin_logged_in' => true, 'admin_user' => $request->username]);
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back!');
        }

        return back()->with('error', 'Invalid username or password.')->withInput(['username' => $request->username]);
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_user']);
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
