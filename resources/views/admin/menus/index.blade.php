<x-admin-layout title="Menu Builder - Admin">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Menu Builder</h1>
                <button onclick="openAddMenuModal()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <span class="material-symbols-outlined">add</span>
                    Add Menu Item
                </button>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Menu Structure -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Menu Structure</h3>
                        <p class="mt-1 text-sm text-gray-500">Drag and drop to reorder menu items</p>
                    </div>
                    <div class="p-6">
                        <div id="menu-list" class="space-y-2">
                            @foreach($menus as $menu)
                                <div class="menu-item" data-menu-id="{{ $menu->id }}">
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-move hover:bg-gray-100">
                                        <div class="flex items-center space-x-3">
                                            <span class="material-symbols-outlined text-gray-400">drag_indicator</span>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $menu->menu_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $menu->link_type }}: {{ $menu->getLinkLabel() }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button onclick="editMenu({{ $menu->id }})" class="text-blue-600 hover:text-blue-900">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>
                                            <button onclick="deleteMenu({{ $menu->id }})" class="text-red-600 hover:text-red-900">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Submenu items -->
                                    @if($menu->children->count() > 0)
                                        <div class="ml-8 mt-2 space-y-2">
                                            @foreach($menu->children as $child)
                                                <div class="menu-item" data-menu-id="{{ $child->id }}">
                                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-move hover:bg-gray-100">
                                                        <div class="flex items-center space-x-3">
                                                            <span class="material-symbols-outlined text-gray-400">drag_indicator</span>
                                                            <div>
                                                                <div class="font-medium text-gray-900">{{ $child->menu_name }}</div>
                                                                <div class="text-sm text-gray-500">{{ $child->link_type }}: {{ $child->getLinkLabel() }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            <button onclick="editMenu({{ $child->id }})" class="text-blue-600 hover:text-blue-900">
                                                                <span class="material-symbols-outlined">edit</span>
                                                            </button>
                                                            <button onclick="deleteMenu({{ $child->id }})" class="text-red-600 hover:text-red-900">
                                                                <span class="material-symbols-outlined">delete</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            
                            @if($menus->isEmpty())
                                <div class="text-center py-8 text-gray-500">
                                    No menu items found. Click "Add Menu Item" to create your first menu.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Available Content -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Available Content</h3>
                        <p class="mt-1 text-sm text-gray-500">Content you can link to</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Pages -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Pages</h4>
                                <div class="space-y-1">
                                    @foreach($pages as $page)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                            <span class="text-sm">{{ $page->title }}</span>
                                            <button onclick="quickAddMenu('page', {{ $page->id }}, '{{ $page->title }}')" class="flex items-center gap-1 text-blue-600 hover:text-blue-900 text-sm">
                                                <span class="material-symbols-outlined align-middle text-sm">add</span>
                                                Add to Menu
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Posts -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Articles</h4>
                                <div class="space-y-1">
                                    @foreach($posts->take(5) as $post)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                            <span class="text-sm">{{ $post->title }}</span>
                                            <button onclick="quickAddMenu('post', {{ $post->id }}, '{{ $post->title }}')" class="flex items-center gap-1 text-blue-600 hover:text-blue-900 text-sm">
                                                <span class="material-symbols-outlined align-middle text-sm">add</span>
                                                Add to Menu
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Products -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Products</h4>
                                <div class="space-y-1">
                                    @foreach($products->take(5) as $product)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                            <span class="text-sm">{{ $product->product_name }}</span>
                                            <button onclick="quickAddMenu('product', {{ $product->id }}, '{{ $product->product_name }}')" class="flex items-center gap-1 text-blue-600 hover:text-blue-900 text-sm">
                                                <span class="material-symbols-outlined align-middle text-sm">add</span>
                                                Add to Menu
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Categories -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Categories</h4>
                                <div class="space-y-1">
                                    @foreach($categories->take(5) as $category)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                            <span class="text-sm">{{ $category->category_name }}</span>
                                            <button onclick="quickAddMenu('category', {{ $category->id }}, '{{ $category->category_name }}')" class="flex items-center gap-1 text-blue-600 hover:text-blue-900 text-sm">
                                                <span class="material-symbols-outlined align-middle text-sm">add</span>
                                                Add to Menu
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Menu Modal -->
    <div id="menuModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modalTitle">Add Menu Item</h3>
                <form id="menuForm" onsubmit="saveMenu(event)">
                    @csrf
                    <input type="hidden" id="menu_id" name="menu_id">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Menu Name</label>
                        <input type="text" id="menu_name" name="menu_name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Type</label>
                        <select id="link_type" name="link_type" required onchange="updateLinkOptions()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="page">Page</option>
                            <option value="post">Article</option>
                            <option value="product">Product</option>
                            <option value="category">Category</option>
                            <option value="custom">Custom URL</option>
                        </select>
                    </div>

                    <div class="mb-4" id="link_id_container">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Item</label>
                        <select id="link_id" name="link_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select an item</option>
                        </select>
                    </div>

                    <div class="mb-4 hidden" id="custom_url_container">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Custom URL</label>
                        <input type="text" id="custom_url" name="custom_url"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Parent Menu</label>
                        <select id="parent_id" name="parent_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">None (Root Level)</option>
                            @foreach($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->menu_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeMenuModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sortable.js for drag and drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    
    <script>
        // Initialize sortable
        document.addEventListener('DOMContentLoaded', function() {
            const menuList = document.getElementById('menu-list');
            new Sortable(menuList, {
                animation: 150,
                handle: '.cursor-move',
                onEnd: function(evt) {
                    updateMenuOrder();
                }
            });

            // Initialize submenus
            document.querySelectorAll('.ml-8').forEach(submenu => {
                new Sortable(submenu, {
                    animation: 150,
                    handle: '.cursor-move',
                    onEnd: function(evt) {
                        updateMenuOrder();
                    }
                });
            });

            // Load initial link options
            updateLinkOptions();
        });

        function openAddMenuModal() {
            document.getElementById('modalTitle').textContent = 'Add Menu Item';
            document.getElementById('menuForm').reset();
            document.getElementById('menu_id').value = '';
            document.getElementById('menuModal').classList.remove('hidden');
            updateLinkOptions();
        }

        function closeMenuModal() {
            document.getElementById('menuModal').classList.add('hidden');
        }

        function editMenu(menuId) {
            fetch(`/admin/menus/${menuId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalTitle').textContent = 'Edit Menu Item';
                    document.getElementById('menu_id').value = data.id;
                    document.getElementById('menu_name').value = data.menu_name;
                    document.getElementById('link_type').value = data.link_type;
                    document.getElementById('parent_id').value = data.parent_id || '';
                    document.getElementById('custom_url').value = data.custom_url || '';
                    
                    updateLinkOptions();
                    
                    if (data.link_id) {
                        document.getElementById('link_id').value = data.link_id;
                    }
                    
                    document.getElementById('menuModal').classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }

        function deleteMenu(menuId) {
            if (confirm('Are you sure you want to delete this menu item?')) {
                fetch(`/admin/menus/${menuId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function quickAddMenu(linkType, linkId, name) {
            document.getElementById('modalTitle').textContent = 'Add Menu Item';
            document.getElementById('menuForm').reset();
            document.getElementById('menu_id').value = '';
            document.getElementById('menu_name').value = name;
            document.getElementById('link_type').value = linkType;
            document.getElementById('parent_id').value = '';
            
            updateLinkOptions();
            
            if (linkId) {
                document.getElementById('link_id').value = linkId;
            }
            
            document.getElementById('menuModal').classList.remove('hidden');
        }

        function updateLinkOptions() {
            const linkType = document.getElementById('link_type').value;
            const linkIdContainer = document.getElementById('link_id_container');
            const customUrlContainer = document.getElementById('custom_url_container');
            const linkIdSelect = document.getElementById('link_id');

            if (linkType === 'custom') {
                linkIdContainer.classList.add('hidden');
                customUrlContainer.classList.remove('hidden');
            } else {
                linkIdContainer.classList.remove('hidden');
                customUrlContainer.classList.add('hidden');
                
                // Load options for the selected link type
                fetch(`/admin/menus/link-items/${linkType}`)
                    .then(response => response.json())
                    .then(data => {
                        linkIdSelect.innerHTML = '<option value="">Select an item</option>';
                        data.forEach(item => {
                            linkIdSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        function saveMenu(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const menuId = formData.get('menu_id');
            
            // Create a regular form submission instead of fetch
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = menuId ? `/admin/menus/${menuId}` : '/admin/menus';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            // Add method override for PUT
            if (menuId) {
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PUT';
                form.appendChild(methodField);
            }
            
            // Add form fields
            const menuName = document.createElement('input');
            menuName.type = 'hidden';
            menuName.name = 'menu_name';
            menuName.value = formData.get('menu_name');
            form.appendChild(menuName);
            
            const linkType = document.createElement('input');
            linkType.type = 'hidden';
            linkType.name = 'link_type';
            linkType.value = formData.get('link_type');
            form.appendChild(linkType);
            
            const linkId = document.createElement('input');
            linkId.type = 'hidden';
            linkId.name = 'link_id';
            linkId.value = formData.get('link_id');
            form.appendChild(linkId);
            
            const customUrl = document.createElement('input');
            customUrl.type = 'hidden';
            customUrl.name = 'custom_url';
            customUrl.value = formData.get('custom_url');
            form.appendChild(customUrl);
            
            const parentId = document.createElement('input');
            parentId.type = 'hidden';
            parentId.name = 'parent_id';
            const parentValue = formData.get('parent_id');
            parentId.value = parentValue === '' ? null : parentValue;
            form.appendChild(parentId);
            
            // Submit form
            document.body.appendChild(form);
            form.submit();
        }

        function updateMenuOrder() {
            const menuItems = document.querySelectorAll('.menu-item');
            const menuOrder = Array.from(menuItems).map(item => item.dataset.menuId);
            
            console.log('Updating menu order:', menuOrder);
            
            fetch('/admin/menus/order', {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    menu_order: menuOrder
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Show success message
                    const successDiv = document.createElement('div');
                    successDiv.className = 'mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded';
                    successDiv.textContent = 'Menu order updated successfully!';
                    
                    const firstDiv = document.querySelector('.max-w-7xl');
                    firstDiv.parentNode.insertBefore(successDiv, firstDiv);
                    
                    // Remove success message after 3 seconds
                    setTimeout(() => {
                        successDiv.remove();
                    }, 3000);
                } else {
                    console.error('Error updating menu order');
                }
            })
            .catch(error => {
                console.error('Error updating menu order:', error);
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
                errorDiv.textContent = 'Error updating menu order. Please try again.';
                
                const firstDiv = document.querySelector('.max-w-7xl');
                firstDiv.parentNode.insertBefore(errorDiv, firstDiv);
                
                // Remove error message after 3 seconds
                setTimeout(() => {
                    errorDiv.remove();
                }, 3000);
            });
        }
    </script>
</x-admin-layout>