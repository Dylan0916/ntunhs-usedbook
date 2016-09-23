<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\book_data;
use DB;

class ProfileController extends Controller
{

    public function show($id)
    {
      $department = [
        '護理系所'              => '1',
        '資訊管理系所'          => '2',
        '長期照護系所'          => '3',
        '運動保健系所'          => '4',
        '嬰幼兒保育系所'        => '5',
        '健康事業管理系所'      => '6',
        '語言治療與聽力學系'    => '7',
        '休閒產業與健康促進系所' => '8',
        '生死與健康心理諮商系所' => '9'
      ];

      $title = 'Profile';
      $profile = User::find($id);
      $book_data = Book_data::where('department_id', $department[$profile->department])
                    ->orderByRaw("RAND()")->take(4)->get();

      if (\Auth::user()->id == $id) {
        return view('profile', compact('title', 'profile', 'book_data'));
      }
      return view('errors.404');
    }

    public function store(Request $request, $id)
    {
      $this->validate($request, ['name' => 'required'], ['name.required' => 'Name 不能為空。']);

      $profile = User::find($id)->update($request->all());

      return redirect('profile/' . $id)->with('message', 'Update Success !');
    }

    public function showMyBooks($id)
    {
      $title = '我的刊登';
      $active = 'myBooks';
      $book_data = Book_data::where('user_id', $id)->latest('updated_at')->paginate(6);

      if (\Auth::user()->id == $id) {
        return view('myBooks', compact('title', 'active', 'book_data'));
      }
      return view('errors.404');

    }

    public function showMyFavorites($id)
    {
      $title = '我的刊登';
      $active = 'myFavorites';
      $find_favorites = User::find($id);
      $explode = explode(', ', $find_favorites->favorites);
      $book_data = Book_data::where(function($query) use ($explode) {
        foreach ($explode as $value) {
          $query->orWhere('id', $value);
        }
      })->paginate(6);

      if (\Auth::user()->id == $id) {
        return view('myFavorites', compact('title', 'active', 'book_data'));
      }
      return view('errors.404');
    }
}
