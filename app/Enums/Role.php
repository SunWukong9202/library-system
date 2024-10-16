<?php

namespace App\Enums;

enum Role: string {
    case Admin = 'admin';
    case Teacher = 'teacher';
    case Student = 'student';

    public function description(): string
    {
        return "messages" . $this->name ;
    }

    public function permissions(): array 
    {
        return [
            
        ];
    }
}