<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Image;
use App\User;
use App\book_data;
use App\message_board;
use App\favorites_list;
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

      // 判斷是否有上傳新封面圖
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
        $img_realPath->resize(152, 207, function($constraint) {
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

    // show favorites btn
    public function show_favoritesBtn(Request $request)
    {
      $favorites = Favorites_list::where('user_id', $request['user_id'])->where('book_data_id', $request["book_data_id"])->first();

      if (!is_null($favorites)) {
        return 'Y';
      }
      return 'N';
    }

    // add or remove favorites
    public function add_favorites(Request $request)
    {
      $i = Favorites_list::where('user_id', $request['user_id'])->where('book_data_id', $request["book_data_id"]);
      if (is_null($i->first())) {
        Favorites_list::create($request->all());
        return 'add';
      }
      $i->delete();
      return 'remove';
    }

    // 顯示書籍留言
    public function show_messageBoard(Request $request)
    {
      $replyClass = (\Auth::check()) ? 'reply' : '' ;
      $replyLink = (\Auth::check()) ? '' : 'href="' . url('login') . '"';
      $replyText = (\Auth::check()) ? '回覆' : '登入後回覆';

      $dataNum = Message_board::where('book_data_id', $request["book_data_id"])->select('area')->distinct()->get();
      $area = count($dataNum);

      // 印出不同區塊的留言
      for ($i = $area; $i >= 1; $i--) {
        ?>
          <div class="col-md-12" style="margin-top: 20px; border: solid 1px #888; background-color: #fff;">
            <div class="content">
        <?php
              $data = Message_board::where('book_data_id', $request["book_data_id"])->where('area', $i)->get();
              // 印出每一區塊的留言
              foreach ($data as $key => $value) {
                if ($key >= 1)  echo '<hr style="border-color: #888;" />';
                $nextMessage = ($key >= 1) ? 'nextMessage' : '' ;
                $userData = User::find($value->user_id);
                $create_date = explode(' ', $value->created_at);

                $bookdata = Book_data::find($request["book_data_id"]);
                $isSeller = ($value->user_id == $bookdata->user_id) ? '<span class="isSeller">賣家</span> ' : '';
              ?>
                <div class="<?= $nextMessage; ?>">
                  <h4><?= $isSeller . $userData->name ?></h4>
                  <p><?= $value->content; ?></p>
                  <p style="font-size: 14px; color: #777;">in <?= $create_date[0]; ?></p>
                </div>
              <?php
              }
        ?>
                <a class="<?= $replyClass ?>" style="cursor: pointer;" <?= $replyLink ?>>
                  <i class="fa fa-hand-o-right"></i>
                  <?= $replyText ?>
                </a>
                <div class="reply-form">
                  <textarea name="content" data-area="<?= $i; ?>" rows="4" class="form-control"></textarea>
                  <input type="button" value="送出" class="btn btn-primary message">
                  <input type="button" value="取消" class="btn btn-primary cancel">
                </div>
             </div>
          </div>
        <?php
      }
      exit();
    }

    // 新增書籍留言
    public function create_messageBoard(Request $request)
    {
      $dataNum = Message_board::where('book_data_id', $request["book_data_id"])->select('area')->distinct()->get();
      $area = (isset($request['area'])) ? $request["area"] : count($dataNum) + 1;

      $this->validate($request, ['content' => 'required'], ['content.required' => '留言內容 不能留空。']);

      $i = Message_board::create( array_merge(['area' => $area], $request->all()) );

      return ($i) ? '留言完成 !' : '留言失敗';
    }
}
