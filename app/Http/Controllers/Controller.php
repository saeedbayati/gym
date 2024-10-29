<?php

namespace App\Http\Controllers;

use App\Models\Class;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $class = Class::create([
        'title' => $validatedData['title'],
        'description' => $validatedData['description'],
    ]);

        return response()->json($class, 201);
    }
}
