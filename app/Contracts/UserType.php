<?php

namespace App\Contracts;

use ValueError;

enum UserType: string {
    case mento = "mento";
    case mentee = "mentee";

    public static function fromName(string $name): self {
        foreach(self::cases() as $status) {
            if(strtolower($name) === strtolower($status->name)){
                return $status;
            }
        }
        
        throw new ValueError("잘못된 값입니다.");
    }
}