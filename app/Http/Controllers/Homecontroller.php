<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\cart;
use App\Models\Discount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class Homecontroller extends Controller
{
    public function index()
    {
        $cartItem = array();
        $products = Product::all();
        $cartData = Cart::with('product')->get();
        $toPay = $originalPrice = 0;
        foreach ($cartData as $value) {
            $cartItem[] = $value['product_id'];
            if($value['quantity'] > 1){
                for ($i=1; $i < $value['quantity']; $i++) { 
                    $cartItem[] = $value['product_id'];
                }
            }
        }
        if (sizeof($cartItem)) {
            $toPay = $this->calculateValue($cartItem);
            $originalPrice = (count($cartItem) * 8);
        }
        return view('welcome',compact('products','cartData','toPay','originalPrice'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $request->all();
        unset($data['_token']);
        $productExist = Cart::where('product_id', $request->product_id)->first();
        if (isset($productExist)) {
            $productExist->quantity = $productExist->quantity + $request->quantity;
            $productExist->save();
            $msg = 'Updated product count';
        }else{
            Cart::create($data);
            $msg = 'Added product to cart';
        }
        Session::flash('success', $msg);
        return redirect(route('show.products'));
    }

   
    public function destroy(Request $request)
    {
        Cart::truncate();
        Session::flash('success', 'Cleared Cart');
        return redirect(route('show.products'));
    }

    public function remove(string $id)
    {
        $cartData = Cart::findOrFail($id);
        $cartData->delete();
        Session::flash('success', 'Product removed from Cart');
        return redirect(route('show.products'));
    }

    public function update($id)
    {
        $cartData = Cart::find($id);
        // dd($cartData);
        if ($cartData->quantity > 1) {
            $cartData->quantity = $cartData->quantity - 1;
            $cartData->save();
            $msg = 'Product count deducted in cart';
        }else{
            $cartData->delete();
            $msg = 'Product count too low, removed from cart';
        }
        Session::flash('success', $msg);
        return redirect(route('show.products'));
    }

    function calculateValue($array){
        $uniqueArray = array_unique($array);
        $uniqueCount = $this->checkUniqCount($uniqueArray);
        $checkedResult = $this->checkArray($uniqueArray,$uniqueCount,$array);
        $maxOccuranceOrder = array_count_values($array);
        arsort($maxOccuranceOrder);
        $sliceOn = max($maxOccuranceOrder);

        if ($sliceOn > 0) {
            $arrayFive = array();
            $arrayFour = array();
            $foundZero = false;
    
            foreach ($checkedResult as $value) {
                if ($value === 0) {
                    $foundZero = true;
                }
    
                if (!$foundZero) {
                    $arrayFive[] = $value;
                } else {
                    $arrayFour[] = $value;
                }
            }
            $totalFive = $this->calculateDiscount($arrayFive);
            $totalFour = $this->calculateDiscount($arrayFour);
    
            if (($totalFive > $totalFour && $totalFour != 0)||($totalFour > $totalFive && $totalFive == 0)) {
                $total = $totalFour;
            }elseif (($totalFive > $totalFour && $totalFour == 0)||($totalFour > $totalFive && $totalFive != 0 )) {
                $total = $totalFive;
            }
    
        }else{
           $total = $this->calculateDiscount($checkedResult);
        }
    
         return $total;
    }
    
    function calculateDiscount($array){
        $price = $discount = $discountPercentage = 0;
        $totalPrice = array();
        foreach($array as $value){
            $discountPercentage = $this->getDiscount($value);
            $sellingPrice = (8 * $value);
            $discount = ($sellingPrice / 100) * $discountPercentage;
            $price = ($sellingPrice - $discount);
            $totalPrice[] = $price;
        }
        return array_sum($totalPrice);
    }
    
    function checkArray($uArray,$unique,$array){
        $arrayFive = array();
        $arrayFour = array();
        $arrayOther = array();
        $finalArray = array();
        $borderArray = [0];
    
        if($unique > 3){
            if($unique == 5){
                $comboFive = $this->checkOther($array);
                $arrayFive = array_merge($arrayFive, $comboFive);
                $finalArray = array_merge($finalArray, $arrayFive);
                $finalArray = array_merge($finalArray, $borderArray);
            }
            $comboFour = $this->checkFour($array);
            $arrayFour = array_merge($arrayFour, $comboFour);
            $finalArray = array_merge($finalArray, $arrayFour);
            $finalArray = array_merge($finalArray, $borderArray);
            return  $finalArray;
        }else{
            $comboother = $this->checkOther($array);
            $arrayOther = array_merge($arrayFour, $comboother);
            $finalArray = array_merge($finalArray, $arrayOther);
            $finalArray = array_merge($finalArray, $borderArray);
            return  $finalArray;
        }
    }
    
    
    function checkOther($array){
       
        $result = array();
        $checked = array();
        $uniqueArray = array_unique($array);
        $array = array_diff_assoc($array,$uniqueArray);
    
        $result[] = count($uniqueArray);
    
        if(count($array) > 0){
          $checked = $this->checkArray(array_unique($array),count(array_unique($array)),$array);
        }
        if ($checked !== null) {
            $result = array_merge($result, $checked);
        } 
        return $result;
    }
    
    function checkFour($array){
         $result = array();
         $checked = array();
         $occurrences = array_count_values($array);
         arsort($occurrences);
         $uniqueArray = array_slice(array_keys($occurrences), 0, 4);
    
        foreach ($array as $value) {
            if (($key = array_search($value, $uniqueArray)) !== false) {
                unset($array[$key]);
            }
        }
    
         $result[] = 4;
         if(count($array) > 0){
            $checked = $this->checkArray(array_unique($array),count(array_unique($array)),$array);
        }
        
        if ($checked !== null) {
            $result = array_merge($result, $checked);
        } 
         return $result;
    }
    
    function checkUniqCount($array){
         $uniqueArray = count($array);
         return $uniqueArray;
    }

    function getDiscount($unique){
        $discountPercentage = Discount::where('unique_count',$unique)->first();
        return $discountPercentage->discount_percentage??0;
    }
}
