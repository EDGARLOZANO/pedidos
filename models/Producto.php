<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property int $id
 * @property string $nombre
 * @property string $preciosugerido
 * @property int $stock
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
            [['nombre', 'preciosugerido','stock'], 'required'],
            [['preciosugerido','stock'], 'number'],
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
            'stock' => 'Stock'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallepedidos()
    {
        return $this->hasMany(Detallepedido::className(), ['productoid' => 'id']);
    }

    public static function stock($id,$cant)
    {
        $sql = 'SELECT stock FROM Producto WHERE id='.$id;

        if (Producto::findBySql($sql)->all()<$cant){

            console.log('hola');
            return true;
        } else {

            return false;
        }
    }

}
