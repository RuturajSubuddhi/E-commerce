<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
  // ✅ Get all active products
  public function index()
  {
    $products = Product::with(['productCategory', 'productSubcategory', 'productImage'])
      ->where('deleted', 0)
      ->where('status', 1)
      ->get();

    return response()->json($products);
  }

  // ✅ Get products by subcategory (e.g. Demon Slayer)
  // public function getBySubcategory($subcategoryId)
  // {
  //     $subcategory = ProductSubCategory::find($subcategoryId);

  //     if (!$subcategory) {
  //         return response()->json(['message' => 'Subcategory not found'], 404);
  //     }

  //     $products = Product::with(['productCategory', 'productSubcategory', 'productImage'])
  //         ->where('subcategory_id', $subcategoryId)
  //         ->where('deleted', 0)
  //         ->where('status', 1)
  //         ->get();

  //     return response()->json([
  //         'subcategory' => $subcategory->name,
  //         'products' => $products,
  //     ]);
  // }

  public function getSubcategoriesByCategory($categoryId)
  {
    $subcategories = \App\Models\ProductSubCategory::where('category_id', $categoryId)
      ->where('deleted', 0)
      ->get(['id', 'subcategory_name']);

    return response()->json($subcategories);
  }
  public function getByCategory($categoryId)
  {
    $products = Product::with(['productCategory', 'productSubcategory', 'productImage'])
      ->where('category_id', $categoryId)
      ->where('deleted', 0)
      ->where('status', 1)
      ->get();

    return response()->json($products);
  }

  public function getBySubcategory($subcategoryId)
  {
    $subcategory = ProductSubCategory::find($subcategoryId);

    if (!$subcategory) {
      return response()->json(['message' => 'Subcategory not found'], 404);
    }

    $products = Product::with(['productCategory', 'productSubcategory', 'productImage'])
      ->where('subcategory_id', $subcategoryId)
      ->where('deleted', 0)
      ->where('status', 1)
      ->get();

    return response()->json([
      'subcategory' => $subcategory->subcategory_name,
      'products' => $products,
    ]);
  }
  public function getProductDetails($id)
  {
    $product = Product::with(['productCategory', 'productSubcategory', 'productImage'])
      ->where('id', $id)
      ->where('deleted', 0)
      ->where('status', 1)
      ->first();

    if (!$product) {
      return response()->json(['message' => 'Product not found'], 404);
    }

    return response()->json([
      'product' => $product
    ]);
  }

  public function latestProducts()
  {
    $products = Product::where('deleted', 0)
      ->where('status', 1)
      ->orderBy('created_at', 'desc')
      ->take(10)
      ->get();

    return response()->json(['products' => $products]);
  }
}
