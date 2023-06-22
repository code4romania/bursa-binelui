<?php

namespace App\Enums;

enum VolunteerStatus: string
{
    case pending = 'pending';
    case active = 'active';
    case inactive = 'inactive';

}
