<?php

namespace app\components;

use app\models\rbac\RoleName;
use yii\filters\AccessControl as BaseAccessControl;
use yii\web\User;

class AccessControl extends BaseAccessControl
{
    public function init()
    {
        if ($this->user === null) {
            $this->user = \Yii::$app->getUser();
        }
        parent::init();
    }

    protected function isActive($action)
    {
        $user = $this->user;
        if ($user === null) {
            $user = \Yii::$app->getUser();
        }

        if ($user->isGuest) {
            \Yii::$app->authManager->assign(\Yii::$app->authManager->getRole(RoleName::GUEST->value), 'guest');
        }

        return parent::isActive($action);
    }
}