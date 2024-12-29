<?php
namespace App\Filament\Resources\TeamTaskResource\Pages;

use App\Filament\Resources\TeamTaskResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use App\Events\CommentAdded;

class ViewTeamTask extends ViewRecord
{
    protected static string $resource = TeamTaskResource::class;



    public function getTitle(): string
    {
        return ' Team: ' . $this->record->team->name;
    }

    public function getView(): string
    {
        return 'filament.resources.team-task-resource.pages.view-team-task';

    }



    public function showTeamTasks($teamId)
    {
        $tasks = Task::where('team_id', $teamId)->get();

        // Pass the tasks to the view
        return view('team-tasks.index', ['tasks' => $tasks]);
    }


    public function storeComment(Request $request, Task $record)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $currentComments = $record->comments ?? [];

        $newComment = [
            'user_id' => auth()->id(),
            'username' => auth()->user()->name,
            'comment' => $request->input('comment'),
            'timestamp' => now()->toDateTimeString(),
        ];

        $currentComments[] = $newComment;

        $record->comments = $currentComments;
        $record->save();

        event(new CommentAdded($record));
        
        return response()->json([
            'success' => true,
            'comments' => $record->comments,
        ]);
    }


    public function deleteComment(Request $request, Task $record)
    {
        $request->validate([
            'comment_index' => 'required|integer',
        ]);

        $comments = $record->comments ?? [];
        $commentIndex = $request->input('comment_index');

        if (isset($comments[$commentIndex])) {
            unset($comments[$commentIndex]);
            $comments = array_values($comments);
            $record->update(['comments' => $comments]);

            return response()->json([
                'success' => true,
                'comments' => $comments,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Comment not found'], 404);
    }

    public function uploadAttachment(Request $request, Task $record)
    {

        $request->validate([
            'attachments' => 'required|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx,csv|max:2048',
        ]);

        $newAttachments = [];


        foreach ($request->file('attachments') as $file) {

            $path = $file->store('attachments', 'public');


            $originalName = $file->getClientOriginalName();


            $newAttachments[] = [
                'path' => $path,
                'original_name' => $originalName
            ];
        }


        $currentAttachments = $record->attachments ?? [];


        $record->attachments = array_merge($currentAttachments, $newAttachments);
        $record->save();
        return response()->json([
            'success' => true,
            'attachments' => $newAttachments
        ]);
    }




    public function deleteAttachment(Request $request, Task $record)
    {
        $request->validate([
            'attachment_index' => 'required|integer',
        ]);

        $attachments = $record->attachments ?? [];
        $attachmentIndex = $request->input('attachment_index');

        if (isset($attachments[$attachmentIndex])) {

            Storage::delete($attachments[$attachmentIndex]);
            unset($attachments[$attachmentIndex]);
            $attachments = array_values($attachments);
            $record->update(['attachments' => $attachments]);

            return response()->json([
                'success' => true,
                'attachments' => $attachments,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Attachment not found'], 404);
    }


}
