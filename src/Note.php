<?php

namespace Eastwest\Larabear;

use Illuminate\Database\Eloquent\Model;
use Eastwest\Larabear\Traits\CoreDataDate;
use Eastwest\Larabear\Scopes\TrashedScope;

class Note extends Model
{
    use CoreDataDate;

    protected $table = 'ZSFNOTE';
    protected $primaryKey = 'Z_PK';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TrashedScope);
    }

    public function getIdAttribute()
    {
        return $this->Z_PK;
    }

    public function getTitleAttribute()
    {
        return $this->ZTITLE;
    }

    public function getTextAttribute()
    {
        return $this->ZTEXT;
    }

    public function textWithoutHeadline()
    {
        if (mb_substr($this->text, 0, 1, 'utf-8') == '#') {
            return preg_replace('/^.+\n/', '', $this->text);
        }

        return $this->text;
    }

    public function getCreatedAtAttribute()
    {
        return $this->convertToCarbon($this->ZCREATIONDATE);
    }

    public function updatedAt()
    {
        return $this->convertToCarbon($this->ZMODIFICATIONDATE);
    }

    public function scopeWhereId($query, $id)
    {
        return $query->where('Z_PK', $id);
    }

    public function scopeWhereCreatedSince($query, $date)
    {
        return $query->where('ZCREATIONDATE', '>=', $this->convertToCoreData($date));
    }

    public function scopeWhereUpdatedSince($query, $date)
    {
        return $query->where('ZMODIFICATIONDATE', '>=', $this->convertToCoreData($date));
    }

    public function tags()
    {
        return $this->belongsToMany('\Eastwest\Larabear\NoteTag', 'Z_5TAGS', 'Z_5NOTES', 'Z_10TAGS');
    }

    public static function allWith($tag = null, $since = null)
    {
        if ($since == null) {
            $since = '2001-01-01 00:00:00';
        }

        if ($tag != null) {
            return Note::whereCreatedSince($since)
                ->with('tags')
                ->whereHas('tags', function ($query) use ($tag) {
                    $query->whereTitleIs($tag);
                })->get();
        }

        return Note::whereCreatedSince($since)->with('tags')->get();
    }
}
