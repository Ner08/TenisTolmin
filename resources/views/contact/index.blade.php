<x-layout>
    @title('Kontaktne informacije - Tenis Tolmin')
    <x-title title="Kontaktne informacije" />

    {{-- Informacije za stik --}}
    <section class="py-6">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mx-2">
                <div>
                    <h2 class="text-2xl text-center font-bold bg-gray-500 p-2 rounded-t-xl text-gray-100">Informacije
                    </h2>
                    <div class="bg-gray-100  p-6 pb-1 rounded-t-lg shadow-md md:order-2">

                        <p class="text-gray-700"> <b>Naslov:</b> Dijaška ulica 12c</p>
                        <p class="text-gray-700"><b>Mesto:</b> Tolmin, Slovenija, 5220</p>
                        <p class="text-gray-700"><b>Email:</b> <a href="mailto:damijan.zarli@gmail.com"
                                class="text-blue-600">info@tenis-tolmin.si</a></p>
                        {{-- <p class="text-gray-700"><b>Telefon:</b> <a href="tel:123-456-7890" class="text-blue-600">123-456-7890</a></p> --}}
                        <p class="text-gray-700"><b>TRR:</b> SI56 0475 3000 0388 292 NOVA KBM d.d.</p>
                        <p class="text-gray-700"><b>Matična številka:</b> 5214955000</p>
                        <p class="text-gray-700"><b>Predsednik:</b> Damijan Zarli</p>
                    </div>
                    <div class="bg-gray-100 p-6 pb-2 rounded-b-lg shadow-md">
                        <div class="aspect-w-1 aspect-h-1 mb-4">
                            <iframe src="https://maps.google.com/maps?q=46.180976, 13.731363&z=15&output=embed"
                                width="100%" height="100%" style="border:0;" allowfullscreen=""
                                loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div>

            </div>
        </div>
    </section>

    {{-- Dodatne Informacije za Stik --}}
    <section class="bg-gray-200 py-6">
        <div class="container mx-auto ">
            <h2 class="text-3xl mx-2 font-bold mb-4">Kontaktirajte nas</h2>
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
