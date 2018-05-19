<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id
 * @property string $rfc
 * @property string $razonsocial
 *
 * @property Pedido[] $pedidos
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rfc'], 'required'],
            [['rfc', 'razonsocial'], 'string', 'max' => 255],
            [['rfc'], 'unique'],
            ['rfc', 'match', 'pattern' => "^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})?$", 'message' => 'formato Invalido'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rfc' => 'Rfc',
            'razonsocial' => 'Razonsocial',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::className(), ['clienteid' => 'id']);
    }
    public static function clientExist($rfc)
    {
        if (static::findOne(['rfc' => $rfc])){
            return false;
        } else {

            return true;
        }

    }
}
