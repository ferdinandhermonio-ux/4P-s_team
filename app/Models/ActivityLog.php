<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'model_type', 'model_id', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent record model (Book or Borrowing).
     */
    public function record()
    {
        return $this->morphTo();
    }
}
