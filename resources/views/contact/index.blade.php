<x-layout :message="$message ?? null">
    @title('Kontaktne informacije - Tenis Tolmin')
    <x-title title="Kontaktne informacije" />

    <section class="py-10 px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Info + map --}}
                <div class="space-y-4">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <h2 class="text-base font-semibold text-gray-900 mb-4">Informacije</h2>
                        <div class="space-y-2.5 text-sm">
                            <div class="flex gap-3">
                                <span class="text-gray-400 w-32 flex-shrink-0">Naslov</span>
                                <span class="text-gray-700">Dijaška ulica 12c, 5220 Tolmin</span>
                            </div>
                            <div class="flex gap-3">
                                <span class="text-gray-400 w-32 flex-shrink-0">Email</span>
                                <a href="mailto:info@tenis-tolmin.si" class="text-amber-600 hover:underline font-medium">info@tenis-tolmin.si</a>
                            </div>
                            <div class="flex gap-3">
                                <span class="text-gray-400 w-32 flex-shrink-0">TRR</span>
                                <span class="text-gray-700">SI56 0475 3000 0388 292 NOVA KBM d.d.</span>
                            </div>
                            <div class="flex gap-3">
                                <span class="text-gray-400 w-32 flex-shrink-0">Matična št.</span>
                                <span class="text-gray-700">5214955000</span>
                            </div>
                            <div class="flex gap-3">
                                <span class="text-gray-400 w-32 flex-shrink-0">Predsednik</span>
                                <span class="text-gray-700">Aleš Hvala</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="h-64">
                            <iframe src="https://maps.google.com/maps?q=46.180976, 13.731363&z=15&output=embed"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                class="w-full h-full"></iframe>
                        </div>
                    </div>
                </div>

                {{-- Contact form --}}
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="bg-gray-900 px-5 py-3.5">
                        <h2 class="text-base font-semibold text-white">Kontaktirajte nas</h2>
                    </div>
                    <form action="{{ route('contact_send_email') }}" method="POST" class="p-5 space-y-4">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Elektronski naslov *</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1.5">Sporočilo *</label>
                            <textarea name="content" id="content"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm h-36 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent resize-none"
                                required></textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="bg-amber-50 border border-amber-100 rounded-lg px-4 py-3">
                            <p class="text-sm text-amber-800">Odgovorili vam bomo v najkrajšem možnem času.</p>
                        </div>
                        <button type="submit"
                            class="w-full py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold rounded-lg transition-colors duration-150">
                            Pošlji sporočilo
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

</x-layout>
