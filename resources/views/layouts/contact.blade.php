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
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d387.59617860389795!2d13.730989976794332!3d46.1811735555879!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x477af7c8316a5295%3A0xb9771109e916f079!2s5220%20Tolmin!5e0!3m2!1ssl!2ssi!4v1712075902095!5m2!1ssl!2ssi" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
