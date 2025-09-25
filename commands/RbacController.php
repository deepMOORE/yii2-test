<?php

namespace app\commands;

use app\models\rbac\PermissionName;
use app\models\rbac\RoleName;
use Yii;

class RbacController extends BaseCommandController
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $viewCatalog = $auth->createPermission(PermissionName::VIEW_CATALOG->value);
        $viewCatalog->description = 'Просмотр каталога книг';
        $auth->add($viewCatalog);

        $manageBooks = $auth->createPermission(PermissionName::MANAGE_BOOKS->value);
        $manageBooks->description = 'Управление книгами (добавление, редактирование, удаление)';
        $auth->add($manageBooks);

        $subscribeAuthor = $auth->createPermission(PermissionName::SUBSCRIBE_AUTHOR->value);
        $subscribeAuthor->description = 'Подписка на авторов';
        $auth->add($subscribeAuthor);

        $guest = $auth->createRole(RoleName::GUEST->value);
        $guest->description = 'Гость - только просмотр и подписка';
        $auth->add($guest);
        $auth->addChild($guest, $viewCatalog);
        $auth->addChild($guest, $subscribeAuthor);

        $user = $auth->createRole(RoleName::USER->value);
        $user->description = 'Авторизованный пользователь - полный доступ';
        $auth->add($user);
        $auth->addChild($user, $viewCatalog);
        $auth->addChild($user, $subscribeAuthor);
        $auth->addChild($user, $manageBooks);

        $auth->assign($user, '100');
    }
}