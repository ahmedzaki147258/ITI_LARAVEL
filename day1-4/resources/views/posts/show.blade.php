@php use Carbon\Carbon; @endphp
<x-layout>
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Post Info Card -->
        <div class="bg-white rounded border border-gray-200">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h2 class="text-base font-medium text-gray-700">Post Info</h2>
            </div>
            <div class="px-4 py-4">
                <div class="mb-2">
                    <h3 class="text-lg font-medium text-gray-800">Title :- <span
                            class="font-normal">{{ $post['title'] }}</span></h3>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-800">Description :-</h3>
                    <p class="text-gray-600">{{ $post['description'] }}.</p>
                </div>
            </div>
        </div>

        <!-- Post Creator Info Card -->
        <div class="bg-white rounded border border-gray-200">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h2 class="text-base font-medium text-gray-700">Post Creator Info</h2>
            </div>
            <div class="px-4 py-4">
                <div class="mb-2">
                    <h3 class="text-lg font-medium text-gray-800">Name :- <span
                            class="font-normal">{{$post['user']['name']}}</span></h3>
                </div>
                <div class="mb-2">
                    <h3 class="text-lg font-medium text-gray-800">Email :- <span
                            class="font-normal">{{$post['user']['email']}}</span></h3>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-800">Created At :-
                        <span class="font-normal">{{ Carbon::parse($post['created_at'])->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</span>
                    </h3>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="flex justify-end">
            <a href="{{ route('posts.index') }}"
               class="px-4 py-2 bg-gray-600 text-white font-medium rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Back to All Posts
            </a>
        </div>

        <!-- Comments Section -->
        <div class="bg-white rounded border border-gray-200">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-base font-medium text-gray-700">Comments</h2>
            </div>
            <div class="px-4 py-4 space-y-4">
                @forelse($post->comments as $comment)
                    <div class="border rounded p-3 bg-gray-50 flex justify-between items-start">
                        <div>
                            <p class="text-gray-800">{{ $comment->body }}</p>
                            <small class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this comment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:text-red-800 font-medium text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500">No comments yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Add Comment -->
        <div class="bg-white rounded border border-gray-200">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h2 class="text-base font-medium text-gray-700">Add Comment</h2>
            </div>
            <div class="px-4 py-4">
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <textarea name="body" rows="3" class="w-full border-gray-300 rounded px-3 py-2 shadow-sm" placeholder="Write your comment here..." required></textarea>
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit Comment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
