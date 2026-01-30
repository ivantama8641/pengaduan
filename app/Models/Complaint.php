<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    // Generate a unique ticket ID before creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($complaint) {
            $complaint->ticket_id = 'T-' . date('Ymd') . '-' . strtoupper(uniqid());
        });
    }
}
