<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Mail;
use Validator;

class FeedbackController extends Controller
{
    public function index()
    {
      $title = '意見回饋';
      return view('feedback/feedback', compact('title'));
    }

    public function sendMail(Request $request)
    {
      $data = $request->all();
      $rules = [
        'name'    => 'required',
        'email'   => 'required|email',
        'content' => 'required'
      ];
      $attribute = [
        'name' => '稱謂',
        'email' => '聯絡信箱',
        'content' => '回櫃 / 意見'
      ];

      $validator = Validator::make($data, $rules)->setAttributeNames($attribute);
      if ($validator->fails()) {
        return redirect('feedback')
                ->withInput()
                ->withErrors($validator);
      }

      Mail::send('feedback.sendMail', $data, function($message) {
        $message->to('klj40702@gmail.com', 'Bot')
                ->subject('北護二手書交易平台-回饋信');
      });

      return redirect('feedback')->with('message', '已將您的訊息傳達，請等待回信，謝謝 !');
    }
}
