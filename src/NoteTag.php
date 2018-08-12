<?php

namespace Eastwest\Larabear;

use Illuminate\Database\Eloquent\Model;

class NoteTag extends Model
{
    protected $table = 'ZSFNOTETAG';
    protected $primaryKey = 'Z_PK';

    public function notes()
    {
        return $this->belongsToMany('\Eastwest\Larabear\Note', 'Z_5NOTES', 'Z_5TAGS', 'Z_10TAGS');
    }

    public function getTitleAttribute()
    {
        return $this->ZTITLE;
    }

    public function scopeWhereTitleIs($query, $title)
    {
        return $query->where('ZTITLE', '=', $title);
    }
}
