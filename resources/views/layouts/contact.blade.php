@extends('layouts.master')

@section('title', 'Kontakt')

@section('content')

{{-- Informacije za stik --}}
<section class="py-6">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-whites mx-2 p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Informacije</h2>
                <p class="text-gray-700">Dijaška ulica 12</p>
                <p class="text-gray-700">Tolmin, Slovenija, 5220</p>
                <p class="text-gray-700">Email: info@example.com</p>
                <p class="text-gray-700">Telefon: 123-456-7890</p>
                <p class="text-gray-700">TRR: SI56 0475 3000 0388 292 NOVA KBM d.d.</p>
                <p class="text-gray-700">Matična številka: 5214955000</p>
                <p class="text-gray-700">Delovni Čas: Predsednik: Damijan Zarli</p>
            </div>
            <div class="bg-white mx-2 p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Lokacija</h2>
                <div class="aspect-w-1 aspect-h-1 mb-4">
                    <iframe src="https://maps.google.com/maps?q=46.180976, 13.731363&z=15&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <p class="text-gray-700">Obiščite nas za več informacij!</p>
            </div>
        </div>
    </div>
</section>

{{-- Dodatne Informacije za Stik --}}
<section class="bg-gray-100 py-6">
    <div class="container mx-auto">
        <h2 class="text-3xl mx-2 font-bold mb-4">Kontaktirajte nas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mx-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-2">Email</h3>
                <p class="text-gray-700">Pošljite nam e-sporočilo na <a href="mailto:info@example.com">info@example.com</a>.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-2">Telefon</h3>
                <p class="text-gray-700">Pokličite nas na <a href="tel:123-456-7890">123-456-7890</a>.</p>
            </div>
        </div>
    </div>
</section>

@endsection
