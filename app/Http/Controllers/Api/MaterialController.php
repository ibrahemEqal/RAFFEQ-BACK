<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::where('is_available', true); 

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('subject_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('department') && $request->department != 'الكل') {
            $query->where('department', $request->department);
        }

        $materials = $query->latest()->get();
        return response()->json($materials);
    }

    public function markAsSold(Request $request, $id)
    {
        $material = Material::where('id', $id)
                            ->where('user_id', $request->user()->id)
                            ->firstOrFail();

        $material->update(['is_available' => false]);

        return response()->json(['message' => 'تم تحديث حالة المادة بنجاح']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
            'type' => 'required|in:pdf,book,exam',
            'file' => 'nullable|file|mimes:pdf,jpg,png,zip|max:10240', 
            'whatsapp_number' => 'nullable|string',
            'department' => 'nullable|string', 
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materials', 'public');
        }

        $material = Material::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'subject_name' => $request->subject_name,
            'type' => $request->type,
            'file_path' => $filePath, 
            'whatsapp_number' => $request->whatsapp_number,
            'department' => $request->department ?? 'أخرى',
            'is_free' => true,
            'is_available' => true, 
        ]);

        return response()->json($material, 201);
    }

    public function myMaterials(Request $request)
    {
        $materials = Material::where('user_id', $request->user()->id)->latest()->get();
        return response()->json($materials);
    }

    public function destroy(Request $request, $id)
    {
        $material = Material::where('id', $id)->where('user_id', $request->user()->id)->first();
        
        if(!$material) {
            return response()->json(['message' => 'المادة غير موجودة أو لا تملك صلاحية حذفها'], 403);
        }

        $material->delete();
        return response()->json(['message' => 'تم الحذف بنجاح']);
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);
        return response()->json($material);
    }

    public function update(Request $request, $id)
    {
        $material = Material::where('id', $id)
                            ->where('user_id', $request->user()->id)
                            ->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
            'department' => 'required|string',
            'whatsapp_number' => 'nullable|string',
        ]);

        $material->update([
            'title' => $request->title,
            'subject_name' => $request->subject_name,
            'department' => $request->department,
            'whatsapp_number' => $request->whatsapp_number,
        ]);

        return response()->json(['message' => 'تم التحديث بنجاح', 'material' => $material]);
    }
}