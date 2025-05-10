<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Userモデル追加
use App\Models\User;

// ログイン・ログアウト機能の追加
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

// 会員登録画面のバリデーションとセッションの追加
use App\Http\Requests\RegisterRequest;

// ログイン画面のバリデーションとセッションの追加
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    // 会員登録画面の表示
    public function register()
    {
        return view('auth.register');
    }

    //  登録処理(登録フォームのデータ処理・バリデーション適用)
    public function store(RegisterRequest $request)
    {
        // ユーザーを作成して保存
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 認証メール送信
        $user->sendEmailVerificationNotification();

        Auth::login($user); // 認証ページを見るにはログインが必要
        return redirect()->route('verification.notice');
    }

    // ログイン画面の表示
    public function login()
    {
        return view('auth.login');
    }

    public function loginStore(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()
            ->with('error', 'ログイン情報が登録されていません。');
        }

        return redirect()->route('items.index')->with('success', 'ログイン成功！');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'ログアウトしました。');
    }
}
