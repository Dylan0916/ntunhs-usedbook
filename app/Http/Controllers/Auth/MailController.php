<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use App\confirmation_code;
use App\User;

class MailController extends Controller
{
    public function showSendMailForm()
    {
      $title = '傳送驗證信';
      return view('auth.sendMail', compact('title'));
    }

    public function sendMail(Request $request)
    {
      $this->validate($request, ['email' => 'required|numeric'], [
        'email.required' => '學號 不能為空。',
        'email.numeric' => '學號 必須為數字。',
      ]);

      // 判斷有無註冊過
      $i = User::where('email', $request['email'] . '@ntunhs.edu.tw')->first();
      if ($i) {
          return redirect('register/sendMail')
            ->withInput()
            ->withErrors('此學號已註冊過。');
      }

      $data = [
        'code' => md5(time()),
        'email' => $request['email'] . '@ntunhs.edu.tw'
      ];

      Confirmation_code::create($data);

      Mail::send('emails.post', $data, function($message) use ($request) {
        $email = $request["email"] . '@ntunhs.edu.tw';
        $message->to($email)
                ->subject('Welcome! 北護二手書交易平台');
      });

      return redirect('register/sendMail')
              ->with('sendMessage', '已發送驗證信，請到北護信箱確認吧 !');
    }
}
