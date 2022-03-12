<?php 

namespace App\Traits;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\ModelNotFoundException;


trait Uuid
{
    /**
    * Boot function from Laravel
    */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            
            if(!$model->uuid){
                $model->uuid = Str::uuid()->toString();
            }
            
        });
    }

    public function scopeUuid($query, $uuid, $first = true)
    {
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            throw (new ModelNotFoundException)->setModel(get_class($this));
        }
    
        $search = $query->where('uuid', $uuid);
    
        return $first ? $search->first() : $search;
    }
}
