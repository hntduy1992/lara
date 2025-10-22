<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class LoginController extends Controller
{

    public function getLogin(Request $request)
    {
        $callback = $request->input('callback');
        return Inertia::render('LoginPage', ['callback' => $callback]);
    }

    /**
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ], [
            'username.required' => 'Vui lòng không bỏ trống!',
            'password.required' => 'Vui lòng không bỏ trống!',
        ]);

        $user = User::query()->where('username', $credentials['username'])->first();
        if (!$user) {
            throw ValidationException::withMessages(['username' => 'Tài khoản không tồn tại!']);
        }

        if (Hash::check($credentials['password'], $user->password)) {

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $request->session()->put('flash', ['type' => 'success', 'message' => 'Đăng nhập thành công!']);
            } else {
                $request->session()->put('flash', ['type' => 'error', 'message' => 'Đăng nhập không thành công!']);
            }
            return redirect()->intended($request->input('callback'));
        } else {
            throw ValidationException::withMessages(['password' => 'Sai mật khẩu!']);
        }
    }

    // Đăng xuất
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate(); // Hủy session
        $request->session()->regenerateToken(); // Tạo lại CSRF token
        // Chuyển hướng về trang chủ
        return redirect()->intended('/');
    }
}
