<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // View all categories
    public function index(Request $request): View
    {
        $query = Category::query()->withCount('products');

        if ($search = trim((string) $request->input('q'))) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $categories = $query->orderBy('name')->paginate(20)->withQueryString();

        return view('admin.categories.categories-list', compact('categories'));
    }

    // Show form to create new category
    public function create(): View
    {
        return view('admin.categories.category-form-create');
    }

    // Store new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $storedPath = $request->file('image_file')->store('categories', 'public');
            $imagePath = 'storage/' . $storedPath;
        }

        Category::create([
            'name' => trim($validated['name']),
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')->with('status', 'Category added successfully.');
    }

    // Show category details
    public function show(Category $category)
    {
        return redirect()->route('admin.categories.edit', $category);
    }

    // Show form to edit category
    public function edit(Category $category): View
    {
        return view('admin.categories.category-form-edit', compact('category'));
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
        ]);

        $imagePath = $category->image;
        if ($request->hasFile('image_file')) {
            if (is_string($category->image) && str_starts_with($category->image, 'storage/categories/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $category->image));
            }

            $storedPath = $request->file('image_file')->store('categories', 'public');
            $imagePath = 'storage/' . $storedPath;
        }

        $category->update([
            'name' => trim($validated['name']),
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')->with('status', 'Category updated successfully.');
    }

    // Delete category
    public function destroy(Category $category)
    {
        $categoryName = $category->name;
        $movedProducts = 0;
        $oldImage = $category->image;

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

        if (is_string($oldImage) && str_starts_with($oldImage, 'storage/categories/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $oldImage));
        }

        $status = 'Category "' . $categoryName . '" removed successfully.';
        if ($movedProducts > 0) {
            $status .= ' ' . $movedProducts . ' product(s) moved to another category.';
        }

        return redirect()->route('admin.categories.index')->with('status', $status);
    }
}
