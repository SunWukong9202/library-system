<?php

namespace App\Enums;

enum InscriptionStatus: string {
    case Pending = 'pending';
    case InProgress = 'in progress';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';

    public function description(?Role $role = null): string
    {
        return "messages" . $this->name . ($role ? '-by-'.$role->name : '');
    }
}