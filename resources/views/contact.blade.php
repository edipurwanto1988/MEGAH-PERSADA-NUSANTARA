<x-web-layout title="Kontak - {{ $companyProfile->company_name ?? 'Megah Persada Nusantara' }}" :metaDescription="Hubungi kami untuk informasi lebih lanjut tentang produk dan layanan kami">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary to-primary/80 text-white py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Hubungi Kami</h1>
                <p class="text-xl md:text-2xl">Kami siap membantu Anda dengan produk dan layanan terbaik</p>
            </div>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="bg-background-light dark:bg-background-dark py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12">
                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8">Informasi Kontak</h2>
                        <p class="text-lg text-slate-600 dark:text-slate-400 mb-8">Hubungi kami untuk pertanyaan atau dukungan apa pun. Kami siap membantu Anda dengan produk dan layanan kami.</p>
                        
                        <div class="space-y-6">
                            <!-- Address -->
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-xl">location_on</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-2">Alamat</h3>
                                    <p class="text-slate-600 dark:text-slate-400">Jl. Sudirman No. 123, Pekanbaru Pusat, Indonesia</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-xl">phone</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-2">Telepon</h3>
                                    <p class="text-slate-600 dark:text-slate-400">+62 21 1234 5678</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-xl">email</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-2">Email</h3>
                                    <p class="text-slate-600 dark:text-slate-400">admin@megahpersadanusantara.com</p>
                                </div>
                            </div>

                            <!-- Business Hours -->
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-xl">schedule</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-2">Jam Operasional</h3>
                                    <p class="text-slate-600 dark:text-slate-400">Senin - Jumat: 08:00 - 17:00</p>
                                    <p class="text-slate-600 dark:text-slate-400">Sabtu: 08:00 - 12:00</p>
                                    <p class="text-slate-600 dark:text-slate-400">Minggu: Tutup</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8">Kirim Pesan</h2>
                        
                        @if(session('success'))
                            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap</label>
                                <input type="text" id="name" name="name" required
                                       class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-background-dark-alt text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-slate-400 dark:placeholder:text-slate-500"
                                       placeholder="Masukkan nama lengkap Anda">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email</label>
                                <input type="email" id="email" name="email" required
                                       class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-background-dark-alt text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-slate-400 dark:placeholder:text-slate-500"
                                       placeholder="email@example.com">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nomor Telepon</label>
                                <input type="tel" id="phone" name="phone"
                                       class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-background-dark-alt text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-slate-400 dark:placeholder:text-slate-500"
                                       placeholder="+62 812-3456-7890">
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Subjek</label>
                                <input type="text" id="subject" name="subject" required
                                       class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-background-dark-alt text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-slate-400 dark:placeholder:text-slate-500"
                                       placeholder="Subjek pesan Anda">
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Pesan</label>
                                <textarea id="message" name="message" rows="5" required
                                          class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-background-dark-alt text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-slate-400 dark:placeholder:text-slate-500"
                                          placeholder="Tulis pesan Anda di sini..."></textarea>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="px-8 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary/90 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Kirim Pesan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="bg-white dark:bg-background-dark-alt py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white text-center mb-12">Lokasi Kami</h2>
                <div class="rounded-xl overflow-hidden shadow-xl">
                    <div class="w-full h-96 bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-6xl text-slate-400 dark:text-slate-500 mb-4">map</span>
                            <p class="text-slate-600 dark:text-slate-400">Peta akan ditampilkan di sini</p>
                            <p class="text-sm text-slate-500 dark:text-slate-500 mt-2">Jl. Sudirman No. 123, Pekanbaru Pusat, Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-web-layout>