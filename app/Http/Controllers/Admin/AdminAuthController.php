<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/**
 * 管理者の認証
 */
class AdminAuthController extends AdminController
{
    /**
     * ログイン画面
     *
     * @return void
     */
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return Inertia::render('Admin/Login');
    }

    /**
     * 認証処理
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * ログアウト
     *
     * @return void
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
