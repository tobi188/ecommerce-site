<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Brand;
use App\Product;
use App\Customer;
use App\Bill;
use App\BillDetail;
use App\Navbar;
use Session;
use DB;
use Hash;
use Mail;
use App\User;


class PageController extends Controller
{
    public function getIndex(){
       
        return view('home');
    }

    public function getProductDetail($id){
        $product = Product::find($id);
        return view('product_detail', compact('product'));
    }

    public function checkCart(){
        return view('cart');
    }

    public function test(){
        $cate = Category::all();
        $brand = Brand::all();
        $product = Product::all();
        $nav = Navbar::all();
        return view('test', compact('nav'));
    }


    public function login(){
        return view('login');
    }

    public function register(){
        return view('register');
    }

    public function product_list($id){
        $brandID = $id;
        $brand = DB::table('brands')->where('id', $brandID)->first();
        $brandName =  $brand->name;
        $pdtList = DB::table('products')->where('brand_id', $brandID)->get();
        return view('productList',compact('brandName', 'pdtList'));
    }
    public function postRegister(Request $req){
        $this->validate($req,
            [   
                'name' => 'required',
                'email' => 'required|email|unique:user,email',
                'pwd' => 'required|min:6|max:15',
                're-pwd' => 'same:pwd'
            ],
            [
                'name.required' => '名前を入力してください。',
                'email.required' => 'Eメールを入力してください。',
                'email.email' => 'Eメールの形式で入力してください。',
                'email.unique' => $req->email . 'は、すでに使用されています。',
                'pwd.required' => 'パスワードを入力してください。',
                'pwd.min' => "パスワードの長さは最低６文字です。",
                'pwd.max' => "パスワードの長さは最大１５文字です。",
                're-pwd.same' => 'パスワードが一致しません'
            ]
        );
        
        $user = new User();
        $user->fullname = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->pwd);
        $user->code = 0;
        $user->save();

        $id = $user->id;
        $email = $user->email;

        $code = $this->randomString(5);
        $this->sendMailReg($code,$req->email,$user->fullname);
        
        session()->put('code', $code);

        return view('secure', compact('id','email'));
    }
    public function postLogin(Request $req){
        $this->validate($req,
            [   
                
                'pwd' => 'min:6|max:15',
    
            ],
            [
                'pwd.min' => "パスワードの長さは最低６文字です。",
                'pwd.max' => "パスワードの長さは最大１５文字です。",
            ]
        );
        
        if(Auth::attempt(['email' => $req->email, 'password' => $req->pwd])){
            if(Auth::user()->code == 0){
                $notSecureYet = true;
                $id = Auth::user()->id;
                $email = Auth::user()->email;
                $code = $this->randomString(5);
                $this->sendMailReg($code,$email);
                session()->put('code', $code);

                return view('secure' , compact('id' , 'email', 'notSecureYet'));

            }else {

                return view('home');
            } 
                
        }
        return redirect('login')->with('login', 'fail');   

    }

    public function gotoBuy(){
        if(!Auth::check()){
            return redirect('login')->with('login','notYet');
        }
        return view('buy');
    }

    public function paymentHandler(Request $req){
        $this->validate($req,
            [   
                
                'customer_name' => 'required',
                'post' => 'required',
                'address' => 'required',
                'customer_tel' => 'required',
                'customer_email' => 'required',
    
            ],
            [
                
                'customer_name.required' => "名前を入力してください。",
                'post.required' => "郵便番号を入力してください。",
                'address.required' => "住所を入力してください。",
                'customer_tel.required' => "電話番号を入力してください。",
                'customer_email.required' => "メールを入力してください。",
            ]
        );
 
        if(Session::has('Cart')){
            $cart = Session::get('Cart');
            Session::forget('Cart');
        }
        else {
            return view('home');
        }

        $customer = new Customer;
        $bill = new Bill;
        
        
    
        $customer->name = $req->customer_name;
        $customer->post = $req->post;
        $customer->address = $req->address;
        $customer->tel = $req->customer_tel;
        $customer->email = $req->customer_email;
        
        $customer->user_id = Auth::user()->id;
        $customer->save();

        date_default_timezone_set("Japan");
        $bill->order_date = date("Y-m-d");
        $bill->total = $cart->total;
        $bill->quantities = $cart->quantities;
        $bill->customer_id = $customer->id;

        if($req->payMethod == "cvn"){
            $bill->payment_method = "コンビニ決済";
        }
        else if($req->payMethod == "cod"){
            $bill->payment_method = "C.O.D(代金引換)";
        }
        else {;}
         
        $bill->save();

     
        foreach($cart->products as $key => $value){
            $bill_detail = new BillDetail;
            $bill_detail->bill_id = $bill->id;
            $bill_detail->product_id = $key;
            $bill_detail->quantity = $value['quantity'];
            $bill_detail->unit_price = $value['productInfo']->price;
            $bill_detail->save();

        }
        $bill_detail = DB::table('bill_details')->where('bill_id', $bill->id)->get();

        $products = Product::all();

        $this->sendMailOrder($customer, $bill, $bill_detail ,$products);

        return view('buyingDone');
    }

    public function buyNow_paymentHandler(Request $req, $id, $quantity){
        $this->validate($req,
            [   
                
                'customer_name' => 'required',
                'post' => 'required',
                'address' => 'required',
                'customer_tel' => 'required',
                'customer_email' => 'required',
    
            ],
            [
                
                'post.required' => "全て入力してください。",
            ]
        );
        
        $product = Product::find($id);
        $total = $product->price * $quantity;

        $customer = new Customer;
        $bill = new Bill;
        
        
    
        $customer->name = $req->customer_name;
        $customer->post = $req->post;
        $customer->address = $req->address;
        $customer->tel = $req->customer_tel;
        $customer->email = $req->customer_email;
        
        $customer->user_id = Auth::user()->id;
        $customer->save();

        date_default_timezone_set("Japan");
        $bill->order_date = date("Y-m-d");
        $bill->total = $total;
        $bill->quantities = $quantity;
        $bill->customer_id = $customer->id;

        if($req->payMethod == "cvn"){
            $bill->payment_method = "コンビニ決済";
        }
        else if($req->payMethod == "cod"){
            $bill->payment_method = "C.O.D(代金引換)";
        }
        else {;}
         
        $bill->save();

     
        $bill_detail = new BillDetail;
        $bill_detail->bill_id = $bill->id;
        $bill_detail->product_id = $id;
        $bill_detail->quantity = $quantity;
        $bill_detail->unit_price = $product->price;
        $bill_detail->save();

        $bill_detail = DB::table('bill_details')->where('bill_id', $bill->id)->get();

        $products = Product::all();

        $this->sendMailOrder($customer, $bill, $bill_detail ,$products);

        return view('buyingDone');
    }
    public function sendMailOrder($customer, $bill, $bill_detail, $products){
        $mail = $customer->email;
        $data = [
            'customer' => $customer,
            'bill' => $bill,
            'bill_detail' => $bill_detail,
            'products' => $products,
        ];

        Mail::send('orderMail',$data,function($messenger) use($mail) {
            $messenger->from('quockhanhto93@gmail.com', 'Kamazon');
            $messenger->to($mail,'Customer');
            $messenger->subject('Kamazonでご注文のお知らせ');
        });
    }
    public function sendMailReg($code , $mail, $name){
        $data = [
            'code' => $code,
            'name' => $name,
        ]; 

        Mail::send('email',$data,function($messenger) use ($mail) {
            $messenger->from('quockhanhto93@gmail.com', 'Kamazon');
            $messenger->to($mail,'Customer');
            $messenger->subject('Kamazonアカウントを確認します');
        });
    }

    public function randomString($length){
        $allChars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $code_num = "";
        for($i = 0; $i < $length; $i++){
            $code_num .= $allChars[rand(0, strlen($allChars) - 1)];
        }
        return $code_num;
    }
    public function secure(Request $req){
        $code = session()->get('code');
        $user_id = $req->user_id;
        $user = User::find($user_id);
        if($code == $req->secure_code){
            session()->forget('code');  
            $user->code = 1;
            $user->save();
            return view('secure_done');
        }
        $id = $user_id;
        $fail = true;
        $email = $user->email;
        return view('secure', compact('id', 'email', 'fail'));
        
    }

    public function logout(Request $req){
        
        Auth::logout();

        $req->session()->invalidate();

        $req->session()->regenerateToken();

        return redirect('home');
    }

    public function search(Request $req){
        $word = $req->words;
        $products = Product::where('name', 'like', '%' . $word . '%')->get();
        
        return view('search',compact('products' , 'word'));
        
    }

    // User Page 
    public function viewUserInfo(){
        if(!Auth::user()){
            return view('login');
        }
        return view('user-page');
    }

    public function changeUserInfo(Request $req){
        $this->validate($req,
            [ 
                'mail' => 'unique:user,email',
                'pwd' => 'min:6|max:15',
            ],
            [ 
                'mail.unique' => 'このメールアドレスは他のアカウントに使用されています。',
                'pwd.min' => "パスワードの長さは最低６文字です。",
                'pwd.max' => "パスワードの長さは最大１５文字です。",
            ]
        );
        if($req->name){
            Auth::user()->fullname = $req->name;
        }
        else if($req->mail){
            Auth::user()->email = $req->mail;
        }
        else if($req->pwd){
            Auth::user()->password = Hash::make($req->pwd);
        }
        else if($req->address){
            Auth::user()->address = $req->address;
        }
        else if($req->tel){
            Auth::user()->tel = $req->tel;
        }
        else {;}

        Auth::user()->save();
        return redirect()->back();
    }
}

