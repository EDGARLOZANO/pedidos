<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property int $role
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     *
     *
     */


    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['role'], 'default', 'value' => null],
            [['role'], 'integer'],
            [['username', 'password', 'authKey'], 'string', 'max' => 255],
            [['accessToken'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'role' => 'Role',
        ];
    }
    public static function isUserAdmin($username)
    {
        if (static::findOne(['username' => $username,'role' => 1])){
            return true;
        } else {

            return false;
        }

    }

    public static function isUserSimple($username)
    {
        if (static::findOne(['username' => $username,'role' => 2])){
            return true;
        } else {

            return false;
        }
    }

}
