<?php

namespace App\Traits;

use function PHPUnit\Framework\throwException;

trait WithLockedProperties {
    public function updating($propertyName)
    {
        if (method_exists(self::class,'lockedProps')){
            if(in_array($propertyName,$this->LockedProps())){
                throw new \Exception("You are not allowed to tamper with the protected property {$propertyName}");
            }
        }
    }
}