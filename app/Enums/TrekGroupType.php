<?php

namespace App\Enums;

enum TrekGroupType: string
{
    case Solo = 'solo';

    case Private = 'private';

    case Group = 'group';
}
