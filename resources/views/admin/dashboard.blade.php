<x-admin-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Statistics Cards - Matching templateadmin.md exactly -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
        <div class="p-6 rounded-xl bg-white dark:bg-background-dark border border-primary/20 dark:border-primary/30">
            <p class="text-base font-medium text-gray-600 dark:text-gray-400">Jumlah Produk</p>
            <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalProducts ?? 75 }}</p>
        </div>
        <div class="p-6 rounded-xl bg-white dark:bg-background-dark border border-primary/20 dark:border-primary/30">
            <p class="text-base font-medium text-gray-600 dark:text-gray-400">Jumlah Artikel</p>
            <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalPosts ?? 120 }}</p>
        </div>
        <div class="p-6 rounded-xl bg-white dark:bg-background-dark border border-primary/20 dark:border-primary/30">
            <p class="text-base font-medium text-gray-600 dark:text-gray-400">Produk Populer</p>
            <p class="text-3xl font-bold text-gray-800 dark:text-white">Produk A</p>
        </div>
    </div>

    <!-- Latest Products Table -->
    <div class="mt-8">
        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Produk Terbaru</h3>
        <div class="overflow-x-auto bg-white dark:bg-background-dark rounded-xl border border-primary/20 dark:border-primary/30">
            <table class="min-w-full text-sm divide-y divide-primary/20 dark:divide-primary/30">
                <thead class="bg-gray-50 dark:bg-black/20">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Tanggal Dibuat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary/20 dark:divide-primary/30">
                    @forelse($latestProducts as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}" class="h-10 w-10 rounded object-cover mr-3">
                                    @else
                                        <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center mr-3">
                                            <span class="text-gray-500 text-xs">No Img</span>
                                        </div>
                                    @endif
                                    <div class="text-sm font-medium text-gray-800 dark:text-white">
                                        {{ $product->product_name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $product->category->category_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-white">
                                ${{ number_format($product->price, 2) }}
                                @if($product->final_price && $product->final_price != $product->price)
                                    <span class="ml-1 text-green-600 font-semibold">
                                        ${{ number_format($product->final_price, 2) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $product->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Belum ada produk yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-right">
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
                <i class="fas fa-eye mr-2"></i>Lihat Semua Produk
            </a>
        </div>
    </div>
</x-admin-layout>