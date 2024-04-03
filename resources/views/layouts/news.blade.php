@extends('layouts.master')

@section('title', 'Novice')

@section('content')

    {{-- News --}}
    <section class="py-12">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold mb-8">Novice</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- News items -->
                @foreach ($newsItems as $newsItem)
                    <div>
                        <a href="{{ route('news_detail', $newsItem['id']) }}">
                            <div class="bg-gray-100 hover:bg-gray-200 rounded-lg shadow-md cursor-pointer">
                                @if (isset($newsItem['image']))
                                    <div class="relative overflow-hidden rounded-t-lg">
                                        <img src="{{ $newsItem['image'] }}" alt="{{ $newsItem['title'] }}"
                                            class="w-full h-64 object-cover">
                                        <div class="absolute inset-0 bg-gray-900 opacity-25"></div>
                                    </div>
                                    <div class="p-6 flex flex-col justify-between">
                                        <div>
                                            <h2 class="text-xl font-semibold mb-2">{{ $newsItem['title'] }}</h2>
                                            <p class="text-gray-700 line-clamp-3">{!! $newsItem['content'] !!}</p>
                                        </div>
                                        <p class="text-gray-600 mt-2 text-right">{{ $newsItem['created_at']->format('d.m.Y') }}</p>
                                    </div>
                                @else
                                    <div class="p-6 flex flex-col justify-between">
                                        <div>
                                            <h2 class="text-xl font-semibold mb-2">{{ $newsItem['title'] }}</h2>
                                            <p class="text-gray-700">{{ Str::limit($newsItem['content'], 650) }}</p>
                                        </div>
                                        <p class="text-gray-600 mt-2 text-right">{{ $newsItem['created_at']->format('d.m.Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
