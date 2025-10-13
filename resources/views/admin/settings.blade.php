<x-admin-layout>
    <x-slot name="header">
        Pengaturan
    </x-slot>

    <!-- Settings Tabs -->
    <div class="bg-white dark:bg-background-dark rounded-xl border border-primary/20 dark:border-primary/30">
        <!-- Tab Navigation -->
        <div class="border-b border-primary/20 dark:border-primary/30">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button class="py-4 px-1 border-b-2 border-primary text-sm font-medium text-primary" data-tab="general">
                    Pengaturan Umum
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300" data-tab="seo">
                    SEO Meta
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300" data-tab="company">
                    Profil Perusahaan
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- General Settings Tab -->
            <div id="general-tab" class="tab-content">
                <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nama Situs
                        </label>
                        <input type="text" id="site_name" name="site_name" value="{{ setting('site_name', config('app.name')) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Deskripsi Situs
                        </label>
                        <textarea id="site_description" name="site_description" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">{{ setting('site_description') }}</textarea>
                    </div>

                    <div>
                        <label for="site_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email Situs
                        </label>
                        <input type="email" id="site_email" name="site_email" value="{{ setting('site_email') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="site_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Telepon Situs
                        </label>
                        <input type="tel" id="site_phone" name="site_phone" value="{{ setting('site_phone') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nomor WhatsApp
                        </label>
                        <input type="text" id="whatsapp" name="whatsapp" value="{{ setting('whatshapp') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white"
                               placeholder="Contoh: 628123456789">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Nomor WhatsApp dengan kode negara (tanpa + atau 00)</p>
                    </div>

                    <div>
                        <label for="site_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Alamat Situs
                        </label>
                        <textarea id="site_address" name="site_address" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">{{ setting('site_address') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>

            <!-- SEO Settings Tab -->
            <div id="seo-tab" class="tab-content hidden">
                <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Meta Title
                        </label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ setting('meta_title') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Meta Description
                        </label>
                        <textarea id="meta_description" name="meta_description" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">{{ setting('meta_description') }}</textarea>
                    </div>

                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Meta Keywords
                        </label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="{{ setting('meta_keywords') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pisahkan dengan koma</p>
                    </div>

                    <div>
                        <label for="google_analytics" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Google Analytics ID
                        </label>
                        <input type="text" id="google_analytics" name="google_analytics" value="{{ setting('google_analytics') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition">
                            Simpan Pengaturan SEO
                        </button>
                    </div>
                </form>
            </div>

            <!-- Company Profile Tab -->
            <div id="company-tab" class="tab-content hidden">
                <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nama Perusahaan
                        </label>
                        <input type="text" id="company_name" name="company_name" value="{{ setting('company_name') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="company_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Deskripsi Perusahaan
                        </label>
                        <textarea id="company_description" name="company_description" rows="4" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">{{ setting('company_description') }}</textarea>
                    </div>

                    <div>
                        <label for="company_logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Logo Perusahaan
                        </label>
                        <input type="file" id="company_logo" name="company_logo" accept="image/*"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">
                        <div id="company-logo-preview" class="mt-2">
                            @if(setting('company_logo'))
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Logo saat ini: <img src="{{ asset(setting('company_logo')) }}" alt="Company Logo" class="h-8 inline-block">
                                </p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label for="company_vision" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Visi Perusahaan
                        </label>
                        <textarea id="company_vision" name="company_vision" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">{{ setting('company_vision') }}</textarea>
                    </div>

                    <div>
                        <label for="company_mission" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Misi Perusahaan
                        </label>
                        <textarea id="company_mission" name="company_mission" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm dark:bg-background-dark dark:border-gray-600 dark:text-white">{{ setting('company_mission') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition">
                            Simpan Profil Perusahaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tab Switching Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('[data-tab]');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabName = button.getAttribute('data-tab');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    
                    // Remove active state from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-primary', 'text-primary');
                        btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    });
                    
                    // Show selected tab content
                    document.getElementById(tabName + '-tab').classList.remove('hidden');
                    
                    // Add active state to clicked button
                    button.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    button.classList.add('border-primary', 'text-primary');
                });
            });
            
            // Handle file input change for company logo
            const companyLogoInput = document.getElementById('company_logo');
            if (companyLogoInput) {
                companyLogoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const previewDiv = document.getElementById('company-logo-preview');
                            previewDiv.innerHTML = `
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Logo baru: <img src="${e.target.result}" alt="Company Logo" class="h-8 inline-block">
                                </p>
                            `;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
            
            // Check for success message and update logo preview if needed
            const successMessage = document.querySelector('.bg-green-100');
            if (successMessage && successMessage.textContent.includes('Settings updated successfully')) {
                // If there's a success message and we're on the company tab, refresh the logo
                const companyTab = document.getElementById('company-tab');
                if (companyTab && !companyTab.classList.contains('hidden')) {
                    // Make an AJAX request to get the updated company logo
                    fetch('{{ route('admin.settings') }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        // Create a temporary DOM element to parse the response
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;
                        
                        // Find the logo preview in the response
                        const newLogoPreview = tempDiv.querySelector('#company-logo-preview');
                        if (newLogoPreview) {
                            // Update the current logo preview
                            document.getElementById('company-logo-preview').innerHTML = newLogoPreview.innerHTML;
                        }
                    })
                    .catch(error => console.error('Error fetching updated logo:', error));
                }
            }
        });
    </script>
</x-admin-layout>