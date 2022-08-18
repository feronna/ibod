<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_tajaan".
 *
 * @property int $id
 * @property string $jenisTajaan
 */
class TblTajaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_tajaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jenisTajaan'], 'required'],
            [['id'], 'integer'],
            [['jenisTajaan'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenisTajaan' => 'Jenis Tajaan',
        ];
    }

     public function getJenisTajaan() {
        return $this->hasOne(TblTajaan::className(), ['jenisTajaan'=>'jenisTajaan']);
    }
}
