


<x-filament::page>

 <div class="container mx-auto ">
        @if($record)
            <div class="w-full">
                <!-- Task Details -->

           <div class="bg-white shadow-lg rounded-lg p-6 w-full flex justify-between">


                    <div class="text-md font-semibold text-gray-900 m-2 ">
                        Team
                        <p class="mt-2 text-gray-400 text-xs font-thin">{{ $record->team->name }}</p>
                    </div>
                    <div class="text-md font-semibold text-gray-900 m-2">
                        Task Name
                        <p class="mt-2 text-gray-400 text-xs font-thin capitalize">{{ $record->title }}</p>
                    </div>
                    <div class="text-md font-semibold text-gray-900 m-2">
                        Description
                        <p class="mt-2 text-gray-400 text-xs font-thin capitalize">{{ $record->description }}</p>
                    </div>

                </div>

                <!-- Comments Section -->
                 <div class="w-full mt-6 bg-white shadow-lg rounded-lg p-6">
                    <p class="text-md font-semibold text-gray-900 mb-4">Comments</p>
                    <div id="comments-list" class="space-y-4">
                        @foreach($record->comments ?? [] as $index => $comment)
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg shadow-sm capitalize">
                                <p class="text-gray-700">{{ $comment['comment'] }}</p>
                                <button
                                    class="bg-gray-300 text-black text-xs py-1 px-2 rounded hover:bg-red-700"
                                    onclick="deleteComment({{ $index }})"
                                >
                                    Delete
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add Comment Form -->
                 <form id="comment-form" class="mt-4">
                        <textarea name="comment" class="form-field w-full p-3 mt-2 border border-gray-300 rounded-lg" placeholder="Enter your comment..."></textarea>
                        <button type="submit" class="form-button border mt-4 p-2 text-xs bg-gray-200 text-black rounded-lg ">Add Comment</button>
                    </form>
                </div>

                <!-- File Upload Section -->
                <div class="w-full mt-6 bg-white shadow-lg rounded-lg p-6 flex justify-evenly flex-col gap-3">
                    <p class="text-md font-semibold text-gray-900 p-2">Attachments</p>
                    <div id="attachments-list" class="space-y-4 ">
                        @foreach($record->attachments ?? [] as $index => $attachment)
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg shadow-sm">
                                <a href="{{ Storage::url($attachment['path']) }}" class="text-blue-600 hover:underline" target="_blank">attachment <span class="text-xs px-2 py-1 bg-gray-300 rounded-full">{{ $index+1}}</span> </a>

                                <button
                                    class="text-red-600 text-xs py-1 px-2 rounded bg-gray-300"
                                    onclick="deleteAttachment({{ $index }})"
                                >
                                    Delete
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <form id="attachment-form" enctype="multipart/form-data" class="flex flex-col gap-3">
                        <input type="file" name="attachments[]" multiple class="form-field w-full p-3 border border-gray-300 rounded-lg">

                        <button type="submit" class="form-button border bg-gray-300 text-xs m-4 px-6 py-2  text-black rounded-lg hover:bg-blue-700">Upload</button>
                    </form>
                </div>
     @else
            <p class="text-gray-600">No task details available.</p>
        @endif
    </div>

   <script>
        document.getElementById('comment-form').addEventListener('submit', function (e) {
            e.preventDefault();
            let comment = e.target.comment.value;
            console.log('Submitting comment:', comment);
            fetch("{{ route('teamtask.storeComment', $record->id) }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({ comment: comment })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Server response:', data);
                    let commentsList = document.getElementById('comments-list');
                    let newComment = document.createElement('div');
                    newComment.classList.add('flex', 'justify-between', 'items-center', 'p-4', 'bg-gray-50', 'rounded-lg', 'shadow-sm');

                    let commentText = document.createElement('p');
                    commentText.classList.add('text-gray-700');
                    commentText.textContent = comment;

                    let deleteButton = document.createElement('button');
                    deleteButton.classList.add('bg-red-600', 'text-white', 'text-xs', 'py-1', 'px-2', 'rounded', 'hover:bg-red-700');
                    deleteButton.textContent = 'Delete';
                    deleteButton.onclick = () => deleteComment(data.comments.length - 1);

                    newComment.appendChild(commentText);
                    newComment.appendChild(deleteButton);
                    commentsList.appendChild(newComment);

                    e.target.comment.value = '';
                }
            });
        });


        function deleteComment(index) {
            fetch("{{ route('teamtask.deleteComment', $record->id) }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({ comment_index: index })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let commentsList = document.getElementById('comments-list');
                    commentsList.innerHTML = '';
                    data.comments.forEach((comment, idx) => {
                        let commentDiv = document.createElement('div');
                        commentDiv.classList.add('flex', 'justify-between', 'items-center', 'p-4', 'bg-gray-50', 'rounded-lg', 'shadow-sm');

                        let commentText = document.createElement('p');
                        commentText.classList.add('text-gray-700');
                        commentText.textContent = comment.comment;

                        let deleteButton = document.createElement('button');
                        deleteButton.classList.add('bg-red-600', 'text-white', 'text-xs', 'py-1', 'px-2', 'rounded', 'hover:bg-red-700');
                        deleteButton.textContent = 'Delete';
                        deleteButton.onclick = () => deleteComment(idx);

                        commentDiv.appendChild(commentText);
                        commentDiv.appendChild(deleteButton);
                        commentsList.appendChild(commentDiv);
                    });
                }
            });
        }

        // Handle Uploading Attachments
        document.getElementById('attachment-form').addEventListener('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(e.target);

            fetch("{{ route('teamtask.uploadAttachment', $record->id) }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let attachmentsList = document.getElementById('comments-list');
                    data.attachments.forEach(attachment => {
                        let attachmentLink = document.createElement('a');
                        attachmentLink.classList.add('text-blue-600', 'hover:underline');
                        attachmentLink.href = "{{ Storage::url('') }}" + attachment.path;
                        attachmentLink.target = "_blank";
                        attachmentLink.textContent = attachment.original_name;
                        attachmentsList.appendChild(attachmentLink);
                        attachmentsList.appendChild(document.createElement('br'));
                    });
                }
            });
        });

        // Handle Deleting Attachments
        function deleteAttachment(index) {
            fetch("{{ route('teamtask.deleteAttachment', $record->id) }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({ attachment_index: index }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let attachmentsList = document.getElementById('attachments-list');
                    attachmentsList.innerHTML = '';
                    data.attachments.forEach((attachment, idx) => {
                        let attachmentDiv = document.createElement('div');
                        attachmentDiv.classList.add('flex', 'justify-between', 'items-center', 'p-4', 'bg-gray-50', 'rounded-lg', 'shadow-sm');

                        let attachmentLink = document.createElement('a');
                        attachmentLink.href = "{{ Storage::url('') }}" + attachment;
                        attachmentLink.target = '_blank';
                        attachmentLink.classList.add('text-blue-600', 'hover:underline');
                        attachmentLink.textContent = 'View Attachment';

                        let deleteButton = document.createElement('button');
                        deleteButton.classList.add('text-red-600', 'text-xs', 'py-1', 'px-2', 'rounded', 'hover:bg-red-100');
                        deleteButton.textContent = 'Delete';
                        deleteButton.onclick = () => deleteAttachment(idx);

                        attachmentDiv.appendChild(attachmentLink);
                        attachmentDiv.appendChild(deleteButton);
                        attachmentsList.appendChild(attachmentDiv);
                    });
                }
            });
        }
    </script>



 </x-filament::page>
