<section class="pt-4 pb-8 md:py-8 px-4 border-t border-gray-100">
    <div class="container mx-auto max-w-2xl xl:max-w-3xl 2xl:max-w-4xl">

        <div class="flex items-center gap-3 mb-6">
            <div class="w-1 h-6 bg-amber-500 rounded-full flex-shrink-0"></div>
            <h2 class="text-lg font-bold text-gray-900">
                Komentarji
                <span class="text-sm font-normal text-gray-400">({{ $comments->total() }})</span>
            </h2>
        </div>

        {{-- Add comment form — top --}}
        @auth
            @if (auth()->user()->isApproved())
                <form method="POST" action="{{ $storeRoute }}"
                      class="bg-gray-50 border border-gray-200 rounded-xl p-5 mb-6">
                    @csrf
                    <label for="content" class="block text-xs font-semibold text-gray-700 mb-1.5">Vaš komentar</label>
                    <textarea name="content" id="content" rows="3"
                        class="border border-gray-200 rounded-lg w-full py-2.5 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 resize-none"
                        required maxlength="1000"
                        placeholder="Napišite komentar...">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <button type="submit"
                        class="mt-3 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                        Objavi komentar
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-400 mb-6">Vaša registracija še čaka na odobritev.</p>
            @endif
        @else
            <p class="text-sm text-gray-500 mb-6">
                <a href="{{ route('login_view') }}" class="text-amber-600 font-medium hover:underline">Prijavite se</a>,
                da komentirate.
            </p>
        @endauth

        {{-- Comment list --}}
        @forelse ($comments as $comment)
            @if ($comment->trashed())
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 mb-3 flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-400">{{ $comment->user->name ?? 'Neznan' }}</span>
                    <span class="text-gray-300">·</span>
                    <span class="text-xs text-gray-400">{{ $comment->created_at->format('d. m. Y') }}</span>
                    <span class="text-gray-300">·</span>
                    <p class="text-sm text-gray-400 italic">Komentar zbrisan.</p>
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-xl p-4 mb-3 shadow-sm">
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $comment->content }}</p>
                    <div class="flex items-center justify-between mt-3">
                        <div class="flex items-center gap-2">
                            @if ($comment->user?->player_id)
                                <a href="{{ route('player.show', $comment->user->player_id) }}" class="text-xs font-semibold text-gray-700 hover:text-amber-600 transition-colors">{{ $comment->user->name }}</a>
                            @else
                                <span class="text-xs font-semibold text-gray-700">{{ $comment->user->name ?? 'Neznan' }}</span>
                            @endif
                            <span class="text-gray-300">·</span>
                            <span class="text-xs text-gray-400">{{ $comment->created_at->format('d. m. Y') }}</span>
                        </div>
                        @auth
                            @if (auth()->id() === $comment->user_id || auth()->user()->is_admin)
                                <form method="POST"
                                      id="deleteCommentForm{{ $comment->id }}"
                                      action="{{ route($deleteRouteName, [$commentModel => $comment->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="showDeleteConfirmation('deleteCommentForm', {{ $comment->id }})"
                                        class="text-xs text-red-500 hover:text-red-700 transition-colors">
                                        Izbriši
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif
        @empty
            <p class="text-sm text-gray-400 mb-6">Še ni komentarjev. Bodite prvi!</p>
        @endforelse

        <div class="mb-4">{{ $comments->links('pagination::tailwind') }}</div>

    </div>
</section>
