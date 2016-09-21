<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Image;
use App\book_data;
use Validator;

class SellController extends Controller
{
    private $title = '銷售中的書籍';
    private $upload_dir;
    private $rules = [
      'book_ISBN'    => 'required',
      'book_name'    => 'required',
      'book_author'  => 'required',
      'book_publish' => 'required',
      'book_price'   => 'required|numeric',
      'book_price2'  => 'required|numeric',
      'book_status'  => 'required',
    ];
    private $attribute = [
      'book_ISBN'    => 'ISBN',
      'book_name'    => '書名',
      'book_author'  => '作者',
      'book_publish' => '出版商',
      'book_price'   => '原價',
      'book_price2'  => '售價',
      'book_status'  => '折舊狀態',
    ];

    public function __construct()
    {
      $this->upload_dir = base_path() . '/public/upload';
    }

    public function index(Request $request)
    {
      $title = $this->title;
      $book_data = Book_data::where(function($query) use ($request) {
        // Filter by selected department
        if ($department_id = $request->get('department')) {
          $query->where('department_id', $department_id);
        }

        // Filter by search
        if ($search = $request->get('search')) {
          $query->where(function($query) use ($search) {
            $query->orWhere('book_ISBN', 'like', '%' . $search . '%')
                  ->orWhere('book_name', 'like', '%' . $search . '%')
                  ->orWhere('book_author', 'like', '%' . $search . '%')
                  ->orWhere('book_publish', 'like', '%' . $search . '%');
          });
        }
      })->latest('updated_at')->paginate(6);

      $active = ($request->get('department')) ? 'department' : 'usedbook-home';

      return view('sell.index', compact('title', 'book_data', 'active'));
    }

    public function create()
    {
      $title = '書籍刊登';
      return view('sell.booksUpload', compact('title'));
    }

    public function store(Request $request)
    {
      $rules = array_merge(['book_img' => 'required|image|mimes:jpeg, jpg, png, bmp, gif, svg|max:2048'], $this->rules);
      $attribute = array_merge(['book_img' => '書籍封面'], $this->attribute);

      $validator = Validator::make($request->all(), $rules);
      $validator->setAttributeNames($attribute);

      if ($validator->fails()) {
        return redirect('sell/create')
                ->withInput()
                ->withErrors($validator);
      }

      $data = $this->get_request($request);
      Book_data::create(array_merge(['user_id' => \Auth::user()->id], $data));
      return redirect('/')->with('message', 'Create Success !');
    }

    public function show($id)
    {
      $book_data = Book_data::find($id);
      $title = $this->title;

      return view('sell.booksInformation', compact("book_data", 'title'));
    }

    public function edit($id)
    {
      $book_data = Book_data::find($id);
      $title = '編輯書籍';

      if (\Auth::user()->id == $book_data->user_id) {
        return view('sell.booksEdit', compact("book_data", 'title'));
      }

      return view('errors.404');
    }

    public function update(Request $request, $id)
    {
      $rules = $this->rules;
      $attribute = $this->attribute;

      $validator = Validator::make($request->all(), $rules);
      $validator->setAttributeNames($attribute);

      if ($validator->fails()) {
        return redirect('sell/' . $id . '/edit')
                ->withInput()
                ->withErrors($validator);
      }

      $books = Book_data::find($id);
      $data = $this->get_request($request, $books);

      // 找到舊檔名
      if (is_null($data['book_img'])) {
        $data['book_img'] = $books->book_img;
      } else {
        $this->delete_file($books);
      }

      $books->update($data);
      return redirect('/')->with('message', 'Update Success !');
    }

    public function destroy($id)
    {
      $books = Book_data::find($id);
      $this->delete_file($books);

      $books->delete();
      return redirect('/')->with('message', 'Delete Success !');
    }

    // 搬移照片 and 改名
    public function get_request($request)
    {
      $data = $request->all();

      if ($request->hasFile('book_img')) {
        // get file name
        $image = $request->file('book_img');
        $realName = $image->getClientOriginalName();
        // getClientOriginalExtension() 獲得照片副檔名
        $rename = md5($realName) . time() . '.' . $image->getClientOriginalExtension();

        // move file to server
        // 改變大小後儲存
        $destination = $this->upload_dir;
        $img_realPath = Image::make($image->getRealPath());
        $img_realPath->resize(160, 180, function($constraint) {
          $constraint->aspectRatio();
        })->save($destination . '/' . $rename);
        /* 儲存原大小
        $destination = $this->upload_dir;
        $image->move($destination, $rename);
        */

        $data['book_img'] = $rename;
      } else $data["book_img"] = null;

      return $data;
    }

    // 刪除照片流程
    public function delete_file($books)
    {
      $file_path = $this->upload_dir . '/' . $books->book_img;
      // \File::Delete($file_path);
      if (file_exists($file_path)) unlink($file_path);
    }


}
