<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::withCount('coupons');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('popular')) {
            $query->where('is_popular', $request->popular);
        }

        if ($request->filled('company_type')) {
            $query->where('company_type', $request->company_type);
        }

        $stores = $query->orderBy('position')->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        $categories = Category::orderBy('position')->orderBy('name')->get();
        return view('admin.stores.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:stores,slug',
            'company_type'     => 'required|in:propfirm,broker',
            'position'         => 'nullable|integer|min:0',
            'website'          => 'nullable|url|max:255',
            'description'      => 'nullable|string',
            'details'          => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_popular'       => 'nullable|boolean',
            'is_trusted'       => 'nullable|boolean',
            'logo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'category_ids'     => 'nullable|array',
            'category_ids.*'   => 'exists:categories,id',
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        $base = $slug; $count = 1;
        while (Store::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $count++;
        }

        $store = Store::create([
            'name'             => $request->name,
            'slug'             => $slug,
            'company_type'     => $request->company_type,
            'position'         => $request->input('position', 0),
            'website'          => $request->website,
            'description'      => $request->description,
            'details'          => $request->details,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_popular'       => $request->boolean('is_popular'),
            'is_trusted'       => $request->boolean('is_trusted'),
            'logo'             => $request->hasFile('logo') ? $this->uploadLogo($request->file('logo')) : null,
        ]);

        $store->categories()->sync($request->input('category_ids', []));

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store "' . $store->name . '" created successfully.');
    }

    public function show(Store $store)
    {
        $store->loadCount('coupons');
        $coupons = $store->coupons()->latest()->paginate(10);
        return view('admin.stores.show', compact('store', 'coupons'));
    }

    public function edit(Store $store)
    {
        $categories = Category::orderBy('position')->orderBy('name')->get();
        $store->load('categories');
        return view('admin.stores.edit', compact('store', 'categories'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:stores,slug,' . $store->id,
            'company_type'     => 'required|in:propfirm,broker',
            'position'         => 'nullable|integer|min:0',
            'website'          => 'nullable|url|max:255',
            'description'      => 'nullable|string',
            'details'          => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_popular'       => 'nullable|boolean',
            'is_trusted'       => 'nullable|boolean',
            'logo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'category_ids'     => 'nullable|array',
            'category_ids.*'   => 'exists:categories,id',
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        $logoPath = $store->logo;

        if ($request->boolean('remove_logo')) {
            $this->deleteLogo($store->logo);
            $logoPath = null;
        }

        if ($request->hasFile('logo')) {
            $this->deleteLogo($store->logo);
            $logoPath = $this->uploadLogo($request->file('logo'));
        }

        $store->update([
            'name'             => $request->name,
            'slug'             => $slug,
            'company_type'     => $request->company_type,
            'position'         => $request->input('position', 0),
            'website'          => $request->website,
            'description'      => $request->description,
            'details'          => $request->details,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_popular'       => $request->boolean('is_popular'),
            'is_trusted'       => $request->boolean('is_trusted'),
            'logo'             => $logoPath,
        ]);

        $store->categories()->sync($request->input('category_ids', []));

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store "' . $store->name . '" updated successfully.');
    }

    public function destroy(Store $store)
    {
        $name = $store->name;
        $this->deleteLogo($store->logo);
        $store->delete();
        return redirect()->route('admin.stores.index')
            ->with('success', 'Store "' . $name . '" deleted.');
    }

    private function uploadLogo($file): string
    {
        $dir = public_path('uploads/logos');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $filename = 'store_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);
        return 'uploads/logos/' . $filename;
    }

    private function deleteLogo(?string $logo): void
    {
        if ($logo && file_exists(public_path($logo))) {
            @unlink(public_path($logo));
        }
    }
}
