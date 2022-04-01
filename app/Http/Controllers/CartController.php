<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Product;
use DB;
use File;
use Auth;

class CartController extends Controller
{
    public function addCart(Request $req , $id){
        if(!Auth::check()){
            return redirect('login')->with('login','notYet');
        }
        if($req->buy_btn == 1){
            $buyNowCart = ['id' => $id, 'quantity' => $req->quantity];
            return view('buy', compact('buyNowCart'));
        }
        else{

            $product = DB::table('products')->where('id',$id)->first();
            $quantity = $req->quantity;

            if(session()->has('Cart')){
                $oldCart = session()->get('Cart');
            }
            else 
                $oldCart = array();

            $cart = new Cart($oldCart);
            $cart->addToCart($id, $product, $quantity);
            session()->put('Cart', $cart);

            return view('result',compact('product','quantity'));
        }
    
    }

    public function updateCart(Request $req){
        
        $id = $req->id;
        $quantity = $req->quantity;
        
        $product = DB::table('products')->where('id',$id)->first();
   
        $cart = new Cart(session()->get('Cart'));
        $cart->updateCart($id, $product, $quantity);
        
        session()->put('Cart', $cart);  
        $html  = "";
        $html .= "<h2>品数 : "  . $cart->quantities .  " 個</h2>
                    <h2>合計 : ￥" . number_format($cart->total) .  "</h2>
                    <input type='hidden' id='cart-quantity-update' value='" . $cart->quantities . "'>";

        return  $html;
    }

    public function deleteCart(Request $req){
        
        $id = $req->id;
   
        $product = DB::table('products')->where('id',$id)->first();
   
        $cart = new Cart(session()->get('Cart'));
        $cart->deleteCart($id, $product);

        $html = "";
        if(empty($cart->products)){
            session()->forget('Cart');  
            return $html .= "<div style='text-align:center' class='container'>
                                <h2>商品はありません</h2>
                                <a href='" . url('home') . "'>
                                    <button class='btn btn-primary'>ホームページㇸ
                                    </button>
                                </a>
                            </div>";
            
        }
        else {
            session()->put('Cart', $cart);  
        
            

            $html .= "<div class='container allCartPage'>            
                <br>
                <div class='row'>
                    <div class='col-sm-8 cart_list'>
                        <table class='table' class='update_cart_url'}}>
                            <tbody class='products_list'>";
            

            foreach($cart->products as $key => $c){
                $html .= "<tr class='up'>
                    <td>
                        <img class='productLogo' src='assets/images/" . $c['productInfo']->image . "'>
                        " . $c['productInfo']->name . " 
                    </td>
                    <td>
                        <input type='number' class='qty' value='" . $c['quantity'] . "' min='1' data-id='" . $key . "' style='width: 3em'> 個
                    </td>
                    <td> 
                        ¥" . number_format($c['productInfo']->price) . "(単価)
                    </td>
                    <td> 
                        <button type='button' class='btn btn-danger btn-sm del' data-id=" . $key . ">削除</button>
                    </td>
                </tr>";
            }
            


            $html .=        "</tbody>
                        </table>
                    </div>
                    <div class='col-sm-4 checkout'>
                        <div class='checkout-total'>
                            <h2>品数 : "  . $cart->quantities .  " 個</h2>
                            <h2>合計 : ￥" . number_format($cart->total) .  "</h2>
                            <input type='hidden' id='cart-quantity-update' value='" . $cart->quantities . "'>
                        </div>
                        <div class='buy-btn'>
                            <a class='res' href='" . url('buy') . "'>
                                <button type='button' class='btn btn-success btn-lg'>レジに進む</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>"  ;

            return $html;
        }
    }

    
}
