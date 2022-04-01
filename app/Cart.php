<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Cart extends Model
{
    public $products = array();
    public $quantities = 0;
    public $total = 0;

    public function __construct($oldCart){
        if($oldCart){
            $this->products = $oldCart->products;
            $this->quantities = $oldCart->quantities;
            $this->total = $oldCart->total;
        }     
    }
    
    public function addToCart($id,$new, $quantity){
        $unitTotalPrice = $new->price * $quantity;
        $newProduct = ['productInfo' => $new, 
                      'quantity' => $quantity,
                      'unitTotalPrice' => $unitTotalPrice];

        if(array_key_exists($id, $this->products)){
            $this->products[$id]['quantity'] += $quantity;
            $this->products[$id]['unitTotalPrice'] = $this->products[$id]['quantity'] * $new->price;
        }
        else {
            $this->products[$id] = $newProduct;
        }
        $this->quantities += $quantity;
        $this->total += $unitTotalPrice;
    }
    
    public function updateCart($id, $updateProduct, $newQuantity){
        // get old 
        $oldQuantity = $this->products[$id]['quantity'];  // 1
        $oldUnitTotal = $this->products[$id]['unitTotalPrice']; //

        // xu ly san pham 
        $unitTotalPrice = $updateProduct->price * $newQuantity; 
        $this->products[$id]['unitTotalPrice'] = $unitTotalPrice; // product.price * newQty

        $this->products[$id]['quantity'] = $newQuantity; // update newQty
         
        // total 
        $this->quantities -= $oldQuantity;
        $this->quantities += $newQuantity;
        $this->total -= $oldUnitTotal;
        $this->total +=  $unitTotalPrice;
    }

    public function deleteCart($id, $product){

        $oldQuantity = $this->products[$id]['quantity'];
        $oldUnitTotal = $this->products[$id]['unitTotalPrice'];

        $this->quantities -= $oldQuantity;
        $this->total -= $oldUnitTotal;

       unset($this->products[$id]);
    }
}
