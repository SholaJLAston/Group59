<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // View all categories
    public function index()
    {
        //
    }

    // Show form to create new category
    public function create()
    {
        //
    }

    // Store new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:categories,name'],
        ]);

        Category::create([
            'name' => trim($validated['name']),
        ]);

        return redirect()->route('admin.products.index')->with('status', 'Category added successfully.');
    }

    // Show category details
    public function show(Category $category)
    {
        //
    }

    // Show form to edit category
    public function edit(Category $category)
    {
        //
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        //
    }

    // Delete category
    public function destroy(Category $category)
    {
        $categoryName = $category->name;
        $movedProducts = 0;

        DB::transaction(function () use ($category, &$movedProducts) {
            $fallbackName = strcasecmp((string) $category->name, 'Uncategorized') === 0
                ? 'General'
                : 'Uncategorized';

            $fallbackCategory = Category::firstOrCreate([
                'name' => $fallbackName,
            ]);

            if ((int) $fallbackCategory->id === (int) $category->id) {
                $fallbackCategory = Category::whereKeyNot($category->id)->first();

                if (!$fallbackCategory) {
                    $fallbackCategory = Category::create(['name' => 'General']);
                }
            }

            $movedProducts = $category->products()->update([
                'category_id' => $fallbackCategory->id,
            ]);

            $category->delete();
        });

        $status = 'Category "' . $categoryName . '" removed successfully.';
        if ($movedProducts > 0) {
            $status .= ' ' . $movedProducts . ' product(s) moved to another category.';
        }

        return redirect()
            ->route('admin.products.index')
            ->with('status', $status);
    }
}
