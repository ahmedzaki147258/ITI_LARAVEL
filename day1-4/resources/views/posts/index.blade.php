@php use Carbon\Carbon; @endphp
<x-layout>
    <div class="text-center">
        <a href="{{ route('posts.create') }}"
           class="create-post-btn mt-4 px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Create Post
        </a>
    </div>

    <!-- Table Component -->
    <div class="mt-6 rounded-lg border border-gray-200">
        <div class="overflow-x-auto rounded-t-lg">
            <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                <thead class="text-left">
                <tr>
                    <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">#</th>
                    <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Image</th>
                    <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Title</th>
                    <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Slug</th>
                    <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Posted By</th>
                    <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Created At</th>
                    <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach ($posts as $post)
                    <tr>
                        <td class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">{{ $post['id'] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-700"><img src="{{ asset('storage/' . $post['image']) }}" alt="Image" class="w-12 h-12 rounded-full"></td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{ $post['title'] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{ $post['slug'] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{ $post['user']['name']}}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{ Carbon::parse($post['created_at'])->isoFormat('MMM Do YY') }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-700 space-x-2">
                            <button type="button" 
                                    data-post-id="{{ $post['id'] }}"
                                    class="view-post-btn inline-block px-4 py-1 text-xs font-medium text-white bg-blue-400 rounded hover:bg-blue-500">
                                View
                            </button>
                            <button type="button" 
                                    data-post-id="{{ $post['id'] }}"
                                    class="edit-post-btn inline-block px-4 py-1 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                                Edit
                            </button>
                            <button type="button" 
                                    data-post-id="{{ $post['id'] }}"
                                    data-post-title="{{ $post['title'] }}"
                                    class="delete-post-btn inline-block px-4 py-1 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>


        <!-- Pagination -->
        <div class="rounded-b-lg border-t border-gray-200 px-4 py-2">
            <ol class="flex justify-end gap-1 text-xs font-medium">
                <li>
                    <a href="{{ route('posts.index', ['page' => $currentPage > 1 ? $currentPage - 1 : 1]) }}"
                       class="inline-flex size-8 items-center justify-center rounded-sm border border-gray-100 bg-white text-gray-900">
                        <span class="sr-only">Prev Page</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                </li>

                @for($i = 1; $i <= $totalPages; $i++)
                    <li>
                        <a href="{{ route('posts.index', ['page' => $i]) }}"
                           class="block size-8 rounded-sm border text-center leading-8
                            {{ $i === $currentPage ? 'bg-blue-600 border-blue-600 text-white' : 'border-gray-100 bg-white text-gray-900 hover:bg-gray-50' }}">
                            {{ $i }}</a>
                    </li>
                @endfor

                <li>
                    <a href="{{ route('posts.index', ['page' => $currentPage < $totalPages ? $currentPage + 1 : $totalPages]) }}"
                       class="inline-flex size-8 items-center justify-center rounded-sm border border-gray-100 bg-white text-gray-900">
                        <span class="sr-only">Next Page</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                </li>
            </ol>
        </div>
    </div>
</x-layout>

<!-- View/Edit/Create Dialog -->
<div id="actionModal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full">
                            <iframe id="actionFrame" class="w-full h-[600px] border-0"></iframe>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" onclick="closeActionModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                            <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="modal-title">Delete post</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to delete "<span id="postTitle"
                                                                                                        class="font-medium"></span>"?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">
                            Delete
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openActionModal(url) {
        document.getElementById('actionFrame').src = url;
        document.getElementById('actionModal').classList.remove('hidden');
    }

    function closeActionModal() {
        document.getElementById('actionModal').classList.add('hidden');
        document.getElementById('actionFrame').src = '';
    }

    function openDeleteModal(id, title) {
        document.getElementById('postTitle').innerText = title;
        document.getElementById('deleteForm').action = `/posts/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Event Listeners
    document.querySelectorAll('.view-post-btn').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.dataset.postId;
            openActionModal(`/posts/${postId}`);
        });
    });

    document.querySelectorAll('.edit-post-btn').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.dataset.postId;
            openActionModal(`/posts/${postId}/edit`);
        });
    });

    document.querySelectorAll('.delete-post-btn').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.dataset.postId;
            const postTitle = this.dataset.postTitle;
            openDeleteModal(postId, postTitle);
        });
    });

    // Create button event listener
    document.querySelector('.create-post-btn').addEventListener('click', function(e) {
        e.preventDefault();
        openActionModal(this.href);
    });
</script>
