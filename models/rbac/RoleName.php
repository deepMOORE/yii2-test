<?php declare(strict_types=1);

namespace app\models\rbac;

enum RoleName: string
{
    case USER = 'user';
    case GUEST = 'guest';
}