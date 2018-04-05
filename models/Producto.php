<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property int $id
 * @property string $nombre
 * @property string $preciosugerido
 *
 * @property Detallepedido[] $detallepedidos
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'preciosugerido'], 'required'],
            [['preciosugerido'], 'number'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'preciosugerido' => 'Preciosugerido',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallepedidos()
    {
        return $this->hasMany(Detallepedido::className(), ['productoid' => 'id']);
    }
}
