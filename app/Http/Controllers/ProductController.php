<?php

namespace App\Http\Controllers;

use App\Condition;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request) {
        $filters = $request->all(); // Retrieve all GET parameters

        $products = Product::latest()->filter(
            request([
                'current_min_bid', 'current_max_bid', 'auction_status', 'condition', 'search'
            ]))
            ->paginate(6);

        return view('products.index', [
            'products' => $products,
            'filters' => $filters
        ]);
    }

    public function show(Product $product) {
        return view('products.show', [
            'product' => $product
        ]);
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        // dd($request->file('photo'));
        $formFields = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => 'required',
            'min_bid' => ['required', 'integer'],
            'bid_step' => 'integer',
            'location' => ['required', 'max:255'],
            'condition' => ['required', Rule::enum(Condition::class)],
            'starting_datetime' => ['required', 'date', 'after_or_equal:now'],
            'ending_datetime' => ['required', 'date', 'after:starting_datetime'],
        ]);

        if ($request->hasFile('photo')) {
            $formFields['photo'] = $request->file('photo')->store('product-photos', 'public');
        }

        $formFields['seller_id'] = Auth::id();

        Product::create($formFields);

        return redirect('/')->with('message', 'Product created successfully');
    }

    public function edit(Product $product) {

        if ($product->seller_id != Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unathorized Action');
        }

        $current_datetime = Carbon::now();

        if ($current_datetime > $product->ending_datetime && $product->current_bid) {
            abort(403, 'Auction finished');
        }

        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product) {

        if ($product->seller_id != Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unathorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'min_bid' => ['required', 'integer'],
            'bid_step' => 'integer',
            'location' => 'required',
            'condition' => ['required', Rule::enum(Condition::class)],
            'starting_datetime' => ['required', 'date'],
            'ending_datetime' => ['required', 'date', 'after:starting_datetime', 'after_or_equal:now'],
        ]);


        if ($request->hasFile('photo')) {
            $formFields['photo'] = $request->file('photo')->store('product-photos', 'public');
        }

        $product->update($formFields);

        return back()->with('message', 'Product updated successfully');
    }

    public function delete(Product $product) {

        if ($product->seller_id != Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unathorized Action');
        }

        $current_datetime = Carbon::now();

        if ($current_datetime > $product->ending_datetime && $product->current_bid) {
            abort(403, 'Auction finished');
        }

        $product->delete();
        return back()->with('message', 'Product deleted successfully');
    }

    public function manage() {

        if (Auth::user()->is_admin) {
            return view('products.manage', [
                'products' => Product::latest()->get()
            ]);
        }
        else {
            return view('products.manage', [
                'products' => Auth::user()->products()->get()
            ]);
        }
        
    }

    public function bids() {

        if (Auth::user()->is_admin) {
            return view('products.bids', [
                'products' => Product::latest()
                    ->whereNotNull('current_bid')
                    ->get()
            ]);
        }
        else {
            return view('products.bids', [
                'products' => Auth::user()->bids()->get()
            ]);
        }
        
    }

    public function placeBid(Request $request, Product $product) {

        if ($product->seller_id == Auth::id()) {
            return back()->with("message", [
                "text" => "Sorry, you can't place bids on your products",
                "color" => "yellow"
            ]);
        }

        $current_datetime = Carbon::now();

        if ($current_datetime < $product->starting_datetime) {

            return back()->with('message', [
                "text" => "Sorry, the auction hasn't started",
                "color" => "yellow"
            ]);
        }

        if ($current_datetime > $product->ending_datetime) {
            return back()->with('message', [
                'text' => 'Sorry, the auction has ended',
                'color' => 'yellow'
            ]);
        }

        $min_possible_bid = $product->current_bid ? ($product->current_bid + $product->bid_step) : $product->min_bid;

        $request->validate([
            'bid' => ['required', 'integer', 'min:' . $min_possible_bid]
        ]);

        $product->update([
            'current_bid' => $request->bid,
            'bidder_id' => Auth::id()
        ]);

        return back()->with('message', 'Your bid has been placed successfully!');
    }

    public function pay(Request $request, Product $product) {

        // dd($product->bidder_id);

        if ($product->is_paid) {
            return back()->with("message", [
                "text" => "You have already paid for this product",
                "color" => "yellow"
            ]);
        }


        if ($product->bidder_id !== Auth::id()) {
            return back()->with("message", [
                "text" => "Sorry, it wasn't your bid",
                "color" => "yellow"
            ]);
        }

        $current_datetime = Carbon::now();

        if ($current_datetime < $product->ending_datetime) {

            return back()->with('message', [
                "text" => "Sorry, the auction hasn't finished yet",
                "color" => "yellow"
            ]);
        }

        $product->update([
            'is_paid' => 1
        ]);

        return back()->with('message', 'You have successfully paid for the product!');
    }

    public function received(Request $request, Product $product) {

        // dd($product->bidder_id);

        if (!$product->is_paid) {
            return back()->with("message", [
                "text" => "Error. You haven't paid for this product",
                "color" => "red"
            ]);
        }

        // if (!$product->is_sent) {
        //     return back()->with("message", [
        //         "text" => "Error. Product hasn't been sent yet",
        //         "color" => "red"
        //     ]);
        // }


        if ($product->bidder_id !== Auth::id() && !Auth::user()->is_admin) {
            return back()->with("message", [
                "text" => "Sorry, it wasn't your bid",
                "color" => "yellow"
            ]);
        }

        $current_datetime = Carbon::now();

        if ($current_datetime < $product->ending_datetime) {

            return back()->with('message', [
                "text" => "Sorry, the auction hasn't finished yet",
                "color" => "yellow"
            ]);
        }

        $product->update([
            'is_received' => 1
        ]);

        // Return payment to the seller

        return back()->with('message', 'You have successfully marked the product as received!');
    }
}
