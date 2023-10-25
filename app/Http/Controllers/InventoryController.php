<?php

namespace App\Http\Controllers;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class InventoryController extends Controller{
    public function index()
    {
        $products = Inventory::all(); 
        return view('inventory.products', compact('products'));
    }

    public function admin(Request $request)
    {
        $query = Inventory::query();
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('product', 'like', '%' . $search . '%');
        }
    
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            switch ($filter) {
                case 'price_low_high':
                    $query->orderBy('price');
                    break;
                case 'price_high_low':
                    $query->orderByDesc('price');
                    break;
                case 'stock_low_high':
                    $query->orderBy('stock');
                    break;
                case 'stock_high_low':
                    $query->orderByDesc('stock');
                    break;
            }
        }
    
        $inventory = $query->get();
    
        return view('inventory.admin', compact('inventory'));
    }
    public function admin2(){
        return view('inventory.newProduct');
    }


    public function store(Request $request)
    {
         $data = $request->validate([
            'product' => 'required',
             'description' => 'required',
             'price' => 'required',
             'stock' => 'required',
             'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $existingProduct = Inventory::where('product', $data['product'])->first();
    
        if ($existingProduct) {
            return redirect(route('inventory.newProduct'))
                ->with('error', 'Product already exist.');
        }

         if ($request->hasFile('image')) {
             $imagePath = $request->file('image')->store('product_images', 'public');
             $data['image'] = $imagePath;       
          }
          
         Inventory::create($data);
    
         return redirect(route('inventory.admin'))->with('success', 'Product added successfully');
            
    }

    public function edit(Inventory $inventory)
    {
        return view('inventory.edit', compact('inventory'));
    }
    
    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'product' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        if ($request->hasFile('image')) {
    
            if ($inventory->image) {
                \Storage::disk('public')->delete($inventory->image);
            }
    
            $imagePath = $request->file('image')->store('product_images', 'public');
            $data['image'] = $imagePath;
        }
    
        $inventory->update($data);
    
        return redirect(route('inventory.admin'))->with('success', 'Product updated successfully');
    }
    
    public function destroy(Inventory $inventory)
    {
        if ($inventory->image) {
            \Storage::disk('public')->delete($inventory->image);
        }
    
        $inventory->delete();
    
        return redirect(route('inventory.admin'))->with('success', 'Product deleted successfully');
    }
}