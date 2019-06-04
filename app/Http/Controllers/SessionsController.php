<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
                'only' => ['create']
            ]);
    }
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ]);

        if(Auth::attempt($credentials, $request->has('remember'))){
            session()->flash('success', 'welcome back!');
            $fallback = route('users.show',Auth::user());
            return redirect()->intended($fallback);
        }else{
            session()->flash('danger', '抱歉，邮箱账号密码不匹配');
            return redirect()->back()->withInput();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '成功退出');
        return redirect('login');
    }


}
// if (Auth::attempt($credentials)) {
//             session()->flash('success', 'welcome back!');
//             return redirect()->route('users.show', [Auth::user()]);
//         }else{
//             session()->flash('danger', 'sry, u email != psw');
//             return redirect()->back()->withInput();
//         }
