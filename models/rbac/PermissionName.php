<?php declare(strict_types=1);

namespace app\models\rbac;

enum PermissionName: string
{
    case VIEW_CATALOG = 'viewCatalog';
    case MANAGE_BOOKS = 'manageBooks';
    case SUBSCRIBE_AUTHOR = 'subscribeAuthor';
}