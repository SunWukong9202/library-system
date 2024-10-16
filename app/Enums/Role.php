<?php

namespace App\Enums;

enum Role: string {
    case Admin = 'admin';
    case Librarian = 'librarian';
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