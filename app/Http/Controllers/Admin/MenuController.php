<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('children')
            ->whereNull('parent_id')
            ->orderBy('order_no')
            ->get();
        
        $pages = Page::all();
        $posts = Post::all();
        $products = Product::all();
        $categories = ProductCategory::all();
        
        return view('admin.menus.index', compact('menus', 'pages', 'posts', 'products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_name' => 'required|string|max:255',
            'link_type' => 'required|in:page,post,product,category,custom',
            'link_id' => 'nullable|integer',
            'custom_url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|integer|exists:menus,id',
        ]);

        // Convert empty parent_id to null
        if (isset($validated['parent_id']) && $validated['parent_id'] === '') {
            $validated['parent_id'] = null;
        }

        // Get the highest order_no for the parent
        $maxOrder = Menu::where('parent_id', $validated['parent_id'] ?? null)
            ->max('order_no') ?? 0;
        
        $validated['order_no'] = $maxOrder + 1;

        // If custom link type, ensure custom_url is provided
        if ($validated['link_type'] === 'custom') {
            $validated['custom_url'] = $validated['custom_url'] ?? '#';
        }

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu item created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return response()->json($menu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'menu_name' => 'required|string|max:255',
            'link_type' => 'required|in:page,post,product,category,custom',
            'link_id' => 'nullable|integer',
            'custom_url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|integer|exists:menus,id',
        ]);

        // Convert empty parent_id to null
        if (isset($validated['parent_id']) && $validated['parent_id'] === '') {
            $validated['parent_id'] = null;
        }

        // If custom link type, ensure custom_url is provided
        if ($validated['link_type'] === 'custom') {
            $validated['custom_url'] = $validated['custom_url'] ?? '#';
        }

        // Prevent a menu from being its own parent
        if (isset($validated['parent_id']) && $validated['parent_id'] == $menu->id) {
            return redirect()->route('admin.menus.index')
                ->with('error', 'A menu item cannot be its own parent.');
        }

        // Update order_no if parent_id changed
        if (isset($validated['parent_id']) && $validated['parent_id'] != $menu->parent_id) {
            // Get the highest order_no for the new parent
            $maxOrder = Menu::where('parent_id', $validated['parent_id'] ?? null)
                ->max('order_no') ?? 0;
            $validated['order_no'] = $maxOrder + 1;
        }

        $menu->update($validated);

        // Check if request is AJAX (for future use)
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Menu updated successfully.']);
        }

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Check if menu has children
        if ($menu->children()->count() > 0) {
            return response()->json([
                'success' => false, 
                'message' => 'Cannot delete menu item with submenus.'
            ], 400);
        }

        $menu->delete();

        return response()->json(['success' => true, 'message' => 'Menu deleted successfully.']);
    }

    /**
     * Update menu order.
     */
    public function updateOrder(Request $request)
    {
        $menuOrder = $request->input('menu_order');
        
        DB::beginTransaction();
        try {
            foreach ($menuOrder as $index => $menuId) {
                $menu = Menu::find($menuId);
                if ($menu) {
                    $menu->update(['order_no' => $index + 1]);
                }
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get available items for link type.
     */
    public function getLinkItems($linkType)
    {
        switch($linkType) {
            case 'page':
                $items = Page::select('id', 'title as name')->get();
                break;
            case 'post':
                $items = Post::select('id', 'title as name')->get();
                break;
            case 'product':
                $items = Product::select('id', 'product_name as name')->get();
                break;
            case 'category':
                $items = ProductCategory::select('id', 'category_name as name')->get();
                break;
            default:
                $items = collect([]);
        }
        
        return response()->json($items);
    }
}