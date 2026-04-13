<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WantedItem;
use Illuminate\Http\Request;

class WantedItemController extends Controller
{
    public function index()
    {
        $items = WantedItem::with('user:id,name')
                            ->orderBy('is_fulfilled', 'asc')
                            ->latest()
                            ->get();
                            
        return response()->json($items);
    }

public function offer(Request $request, $id)
{
    $request->validate([
        'offer_type' => 'required|string|in:pdf,book,explain',
        'contact_phone' => 'required_unless:offer_type,pdf|nullable|string',
        'offer_file' => 'required_if:offer_type,pdf|file|mimes:pdf,zip,jpg,png|max:10240|nullable',
    ]);

    $item = WantedItem::findOrFail($id);
    $filePath = null;

    if ($request->hasFile('offer_file')) {
        $filePath = $request->file('offer_file')->store('wanted_items', 'public');
    }
    
    $item->update([
        'contact_phone' => $request->contact_phone,
        'offer_type' => $request->offer_type,
        'offer_file_path' => $filePath, 
        'is_fulfilled' => true
    ]);

    return response()->json(['message' => 'شكرا يا رفيق.']);
}

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string', 
        ]);

        $wantedItem = WantedItem::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'is_fulfilled' => false, 
        ]);

        return response()->json([
            'message' => 'تم نشر طلبك بنجاح!', 
            'wanted_item' => $wantedItem
        ], 201);
    }
}