<?php

class m130713_214908_create_admin_user_and_base_auth_items extends CDbMigration
{

    public function safeUp()
    {
        $this->createAuthItems();
        $this->createUser(array(
            'username' => 'admin',
            'password' => 'admin',
            'email' => 'admin@localhost',
            'role' => 'admin',
        ));
    }

    private function createAuthItems()
    {
        $auth = Yii::app()->authManager;
        $admin = $auth->createRole('admin', Yii::t('wiro', 'Administrator'));
        $user = $auth->createRole('user', Yii::t('wiro', 'User'), 'return !Yii::app()->user->isGuest');
        $guest = $auth->createRole('guest', Yii::t('wiro', 'Guest'), 'return Yii::app()->user->isGuest');
        $admin->addChild('user');
        $user->addChild('guest');
    }

    private function createUser($attributes)
    {
        $attributes['password'] = Yii::app()->hash->pass->make($attributes['password']);
        $attributes['active'] = 1;
        $this->insert('{{users}}', $attributes);
        $id = $this->getDbConnection()->commandBuilder->getLastInsertID('{{users}}');
        Yii::app()->authManager->assign($attributes['role'], $id);
    }
}