<?php

namespace App\Enums;

enum Transaction: int {
    case Borrow = 0;
    case Return = 1;
    case Delayed = 2;
}