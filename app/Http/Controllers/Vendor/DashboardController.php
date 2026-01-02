<?php 
namespace App\Http\Controllers\Vendor;
use App\Http\Controllers\Controller ;
use Illuminate\Support\Facades\Auth;

class DashboardController extends
Controller
{
 public function index(){
  $vendor=Auth::user();
  
  $products = $vendor ->products;
  $location = $vendor ->location;

  return view('vendeur.dashboard',compact('products','location'));
 }
}