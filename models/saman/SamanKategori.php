<?php

namespace app\models\saman;

use Yii;

/**
 * This is the model class for table "ekeselamatan.r_15_eks_kategorit".
 *
 * @property string $KATEGORIKOD
 * @property string $KATEGORI_DESC
 */
class SamanKategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    public static function tableName()
    {
        return 'ekeselamatan.r_15_eks_kategorit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['KATEGORIKOD'], 'required'],
            [['KATEGORIKOD'], 'string', 'max' => 2],
            [['KATEGORI_DESC'], 'string', 'max' => 20],
            [['KATEGORIKOD'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KATEGORIKOD' => 'Kategorikod',
            'KATEGORI_DESC' => 'Kategori Desc',
        ];
    }
}
