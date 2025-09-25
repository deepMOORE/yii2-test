<?php

namespace app\components;

use app\models\rbac\PermissionName;
use app\models\rbac\RoleName;
use Yii;

class RbacHelper
{
    public static function assignGuestRoleIfNeeded()
    {
        if (Yii::$app->user->isGuest) {
            $auth = Yii::$app->authManager;
            $guestRole = $auth->getRole(RoleName::GUEST->value);

            if ($guestRole && !$auth->getAssignment(RoleName::GUEST->value, 'guest')) {
                $auth->assign($guestRole, RoleName::GUEST->value);
            }
        }
    }

    public static function canViewCatalog()
    {
        self::assignGuestRoleIfNeeded();

        if (Yii::$app->user->isGuest) {
            return true;
        }

        self::assignUserRoleIfNeeded();
        return Yii::$app->user->can(PermissionName::VIEW_CATALOG->value);
    }

    public static function canManageBooks()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        self::assignUserRoleIfNeeded();
        return Yii::$app->user->can(PermissionName::MANAGE_BOOKS->value);
    }

    public static function assignUserRoleIfNeeded()
    {
        if (!Yii::$app->user->isGuest) {
            $auth = Yii::$app->authManager;
            $userId = Yii::$app->user->getId();
            $userRole = $auth->getRole(RoleName::USER->value);

            if ($userRole && !$auth->getAssignment(RoleName::USER->value, $userId)) {
                $auth->assign($userRole, $userId);
            }
        }
    }

    public static function canSubscribe()
    {
        self::assignGuestRoleIfNeeded();

        if (Yii::$app->user->isGuest) {
            return true;
        }

        self::assignUserRoleIfNeeded();
        return Yii::$app->user->can(PermissionName::SUBSCRIBE_AUTHOR->value);
    }
}