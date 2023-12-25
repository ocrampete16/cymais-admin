<?php

namespace App\Enums;

enum Permission: string
{
    case APPROVE_USER_REGISTRATION = 'user-registration:approve';
    case ADD_USER = 'user:add';
    case REMOVE_USER = 'user:remove';
}
