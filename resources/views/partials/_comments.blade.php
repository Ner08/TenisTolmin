{{-- Comments Section --}}
<div class="mt-8">
    <h3 class="text-xl font-semibold mb-4">Comments</h3>
    {{-- Display comments --}}
    @foreach ($comments as $comment)
        <div class="bg-gray-100 rounded-lg shadow-md p-4 mb-4">
            <p class="text-gray-700 text-sm">{{ $comment['content'] }}</p>
            <div class="flex justify-between items-center mt-2">
                <p class="text-gray-500 text-xs">Commented by <span
                        class="font-semibold">{{ $comment['username'] ?? 'John Doe' }}</span> | <span
                        {{-- TODO remove john doe --}}
                        class="font-semibold">{{ $comment['created_at']->format('d.m.Y') }}</span></p>
                {{-- Add reply button if needed --}}
            </div>
        </div>
    @endforeach
    {{-- Add comment form --}}
    @auth
        <form method="POST" class="mt-8 bg-gray-200 rounded-lg shadow-md p-4">
            @csrf
            <div class="mb-4">
                <label for="content" class="block text-gray-700">Comment:</label>
                <textarea name="content" id="content" rows="4" class="form-textarea mt-1 block w-full" required></textarea>
            </div>
            <button type="submit" class="bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-800">Submit
                Comment</button>
        </form>
    @else
        <p class="text-gray-600">Log in to leave a comment.</p>
    @endauth
</div>
