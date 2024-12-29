<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use App\Events\TaskCreated;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'status',
        'due_date',
        'priority',
        'created_by',
        'team_id',
        'comments',
        'attachments',
        'name',
    ];

    protected $casts = [
        'attachments' => 'array',
        'comments' => 'array',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function addComment(string $comment, int $userId): void
    {
        $comments = $this->comments ?? [];
        $comments[] = [
            'user_id' => $userId,
            'comment' => $comment,
            'created_at' => now(),
        ];

        $this->update(['comments' => $comments]);
    }

    public function addAttachment(array $attachment): void
    {
        $attachments = $this->attachments ?? [];

        $path = $attachment['file']->store('team_tasks', 'public');
        $attachments[] = [
            'file' => $path,
            'original_name' => $attachment['file']->getClientOriginalName(),
            'created_at' => now(),
        ];

        $this->update(['attachments' => $attachments]);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($task) {

            event(new TaskCreated($task));
        });
    }
}
