<x-web-layout title="Kontak - {{ setting('company_name', $companyProfile->company_name ?? 'Megah Persada Nusantara') }}" :metaDescription="Hubungi kami untuk informasi lebih lanjut tentang produk dan layanan kami">
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
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8">Hubungi Kami</h2>
                        <p class="text-lg text-slate-600 dark:text-slate-400 mb-8">Hubungi kami untuk pertanyaan atau dukungan apa pun. Kami siap membantu Anda dengan produk dan layanan kami.</p>
                        
                        <div class="space-y-6">
                            <!-- Address -->
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-xl">location_on</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-2">Alamat</h3>
                                    <p class="text-slate-600 dark:text-slate-400">Duren Mekar, Bojongsari, Depok City, West Java</p>
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
                        </div>
                    </div>

                    <!-- Map -->
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8">Lokasi Kami</h2>
                        <div class="rounded-xl overflow-hidden shadow-xl">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.817458712904!2d106.737262874992!3d-6.417495893573383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e900ffa5e3f3%3A0xf3ec7ffdeff4c2f0!2sWorkshop%20Megah%20Persada%20Nusantara!5e0!3m2!1sen!2sid!4v1760979045287!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-web-layout>