<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\book_data;
use App\favorites_list;
use DB;
use Validator;
use Image;

class ProfileController extends Controller
{
    private $upload_dir;

    public function __construct()
    {
      $this->upload_dir = base_path() . '/public/assets\img\profile';
    }

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
      $post = $request->all();
      $profile = User::find($id);
      $rules = ['name' => 'required', 'img' => 'image|mimes:jpeg,jpg,png,bmp,gif,svg|max: 2048'];
      $validator = Validator::make($post, $rules)->setAttributeNames(['name' => 'Name', 'img' => '圖片']);

      if ($validator->fails()) {
        return redirect('profile/' . $id)
                ->withInput()
                ->withErrors($validator);
      }

      // 儲存使用者圖片
      if ($request->hasFile('img')) {
        // get file name
        $image = $request->file('img');
        $realName = $image->getClientOriginalName();
        // getClientOriginalExtension() 獲得照片副檔名
        $rename = md5($realName) . time() . '.' . $image->getClientOriginalExtension();

        // move file to server
        // 改變大小後儲存
        $destination = $this->upload_dir;
        $img_realPath = Image::make($image->getRealPath());
        $img_realPath->resize(152, 207, function($constraint) {
          $constraint->aspectRatio();
        })->save($destination . '/' . $rename);

        // 刪除原圖片
        $file_path = $this->upload_dir . '/' . $profile->img;
        if ( ($profile->img != 'default.png') && file_exists($file_path)) unlink($file_path);

        $post['img'] = $rename;
      }

      $profile->update($post);

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
      $title = '我的收藏';
      $active = 'myFavorites';

      $book_data = Favorites_list::where('user_id', $id)->with('book_data')->paginate(6);

      if (\Auth::user()->id == $id) {
        return view('myFavorites', compact('title', 'active', 'book_data'));
      }
      return view('errors.404');
    }
}
