<?php

namespace App\Traits;

use function PHPUnit\Framework\throwException;

trait WithActiveStatus {
    public function scopeActive($query){
        return $query->where('status',1);
    }

    public function scopeArchived($query){
        return $query->where('status',0);
    }
}
