<x-layout :message="$message ?? null">
    @title('Kontaktne informacije - Tenis Tolmin')
    <x-title title="Kontaktne informacije" />

    {{-- Informacije za stik --}}
    <section class="py-6">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mx-4">
                <div>
                    <h2 class="text-2xl text-center font-bold bg-gray-700 p-2 rounded-t-xl text-gray-100">Informacije
                    </h2>
                    <div class="bg-gray-100  p-6 pb-1 shadow-md md:order-2">

                        <p class="text-gray-800"> <b class="text-gray-900">Naslov:</b> Dijaška ulica 12c</p>
                        <p class="text-gray-800"><b class="text-gray-900">Mesto:</b> Tolmin, Slovenija, 5220</p>
                        <p class="text-gray-800"><b class="text-gray-900">Email:</b> <a
                                href="mailto:damijan.zarli@gmail.com" class="text-blue-600">info@tenis-tolmin.si</a></p>
                        {{-- <p class="text-gray-700"><b>Telefon:</b> <a href="tel:123-456-7890" class="text-blue-600">123-456-7890</a></p> --}}
                        <p class="text-gray-800"><b class="text-gray-900">TRR:</b> SI56 0475 3000 0388 292 NOVA KBM d.d.
                        </p>
                        <p class="text-gray-800"><b class="text-gray-900">Matična številka:</b> 5214955000</p>
                        <p class="text-gray-800"><b class="text-gray-900">Predsednik:</b> Damijan Zarli</p>
                    </div>
                    <div class="bg-gray-100 p-6 pb-2 rounded-b-lg shadow-md">
                        <div class="aspect-w-1 aspect-h-1 mb-4">
                            <iframe src="https://maps.google.com/maps?q=46.180976, 13.731363&z=15&output=embed"
                                width="100%" height="100%" style="border:0;" allowfullscreen=""
                                loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl text-center font-bold bg-amber-600 p-2 rounded-t-xl text-gray-100">Kontaktirajte
                        nas
                    </h2>
                    <form action="{{ route('contact_send_email') }}" method="POST"
                        class="bg-amber-100 p-6 rounded-b-xl shadow-md mb-6">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Elektronski
                                naslov*</label>
                            <input type="email" id="email" name="email"
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50"
                                required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Sporočilo*</label>
                            <textarea name="content" id="content"
                                class="form-textarea mt-1 p-2 rounded-lg w-full h-28 focus:outline-none  border-gray-300 py-3 px-4" required></textarea>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <p> <b class="text-amber-600">Pošljite nam sporočilo </b> in odgovorili vam bomo v
                                najkrajšem možnem času.</p>
                        </div>

                        <div class="">
                            <button type="submit"
                                class="w-full px-4 py-2 bg-amber-600 text-white font-semibold rounded-md shadow-sm hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Pošlji</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Dodatne Informacije za Stik --}}
    <section class="bg-gray-200 py-6">
        <div class="container mx-auto ">
            <h2 class="text-3xl mx-2 font-bold mb-4">Drugi načini kontakta</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mx-2">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-2">Email</h3>
                    <p class="text-gray-700">Pošljite nam e-sporočilo na <a href="mailto:info@example.com"
                            class="text-blue-600">info@tenis-tolmin.si</a>.</p>
                </div>
                {{-- <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-2">Telefon</h3>
                    <p class="text-gray-700">Pokličite nas na <a href="tel:123-456-7890" class="text-blue-600">123-456-7890</a>.</p>
                </div> --}}
            </div>
        </div>
    </section>
</x-layout>
