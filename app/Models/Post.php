<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Deleted'
        ]);
    }

    protected $fillable = [
        'file_path',
        'caption',
        'user_id'
    ];
}
