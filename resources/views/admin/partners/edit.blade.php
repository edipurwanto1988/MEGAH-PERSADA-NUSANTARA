<x-admin-layout title="Edit Partner - Admin">
    <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Edit Partner</h2>
        </div>

        <div class="bg-white dark:bg-background-dark shadow rounded-lg">
            <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Partner Name</label>
                        <input type="text" name="partner_name" required
                               value="{{ old('partner_name', $partner->partner_name) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-background-dark dark:text-white"
                               placeholder="Enter partner name">
                        @error('partner_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Website</label>
                        <input type="url" name="website"
                               value="{{ old('website', $partner->website) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-background-dark dark:text-white"
                               placeholder="https://example.com">
                        @error('website')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Order</label>
                        <input type="number" name="order_no" min="0"
                               value="{{ old('order_no', $partner->order_no) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-background-dark dark:text-white"
                               placeholder="0">
                        @error('order_no')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="status" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-background-dark dark:text-white">
                            <option value="active" {{ old('status', $partner->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $partner->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Logo</label>
                        @if($partner->logo)
                            <div class="mb-4">
                                <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->partner_name }}" class="h-20 w-20 object-cover rounded">
                            </div>
                        @endif
                        
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Logo (Leave empty to keep current)</label>
                        <input type="file" name="logo"
                               accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-background-dark dark:text-white">
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Accepted formats: jpeg, png, jpg, gif. Max size: 2MB.</p>
                        @error('logo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('admin.partners.index') }}" 
                       class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 mr-4">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/90">
                        Update Partner
                    </button>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>