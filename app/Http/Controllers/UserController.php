<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Services;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $products = Products::all(); // Adjust to your logic for fetching featured products
        return view('users.user-dashboard', compact('products','user'));
    }

    public function products()
    {
        $products = Products::all(); // Adjust to your logic for fetching featured products
        return view('users.products', compact('products'));
    }

    public function services()
    {
        $services = services::all(); // Adjust to your logic for fetching featured services
        return view('users.services', compact('services'));
    }


    public function addToCart(Request $request, $id)
    {
        // Fetch the product by its ID
        $product = Products::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Get the cart from session, or create a new one if it doesn't exist
        $cart = session()->get('cart', []);

        // Check if the product already exists in the cart
        if (isset($cart[$id])) {
            // Increment the quantity if the product is already in the cart
            $cart[$id]['quantity']++;
        } else {
            // Add a new product to the cart
            $cart[$id] = [
                "id" => $product->id, // Ensure the product ID is saved
                "name" => $product->name,
                "image" => $product->image_path,
                "price" => $product->price,
                "quantity" => 1
            ];
        }

        // Save the updated cart back into the session
        session()->put('cart', $cart);

        // Provide feedback to the user
        return redirect()->back()->with('success', 'Product added to cart.');
    }


    public function updateQuantity(Request $request, $id)
    {
        $cart = session()->get('cart');

        if (!$cart || !isset($cart[$id])) {
            return response()->json(['message' => 'Product not found in cart'], 404);
        }

        // Update the quantity in the cart based on the change value (+1 or -1)
        $cart[$id]['quantity'] += $request->change;

        // Remove item if the quantity is less than 1
        if ($cart[$id]['quantity'] < 1) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return response()->json(['message' => 'Cart updated successfully']);
    }


    public function viewCart()
    {
        $cart = session()->get('cart');
        return view('users.cart', compact('cart'));
    }

    public function userProfile()
    {
        return view('users.profile.index');
    }
}

