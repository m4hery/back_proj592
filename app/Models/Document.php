<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'path',
        'user_id',
        'parent_id',
        'type',
        'visibility',
        'status',
    ];

    public function parent()
    {
        return $this->belongsTo(Document::class, "parent_id");
    }

    public function enfants()
    {
        return $this->hasMany(Document::class, 'parent_id');
    }

    public function getinfoFolderAttribute()
    {
        $data = [];
        $data = $this;
        if($this->enfants)
        {
            foreach($this->enfants as $enfant)
            {
                $data["children"][] = $enfant;
            }
        }

        return $data;
    }
}
