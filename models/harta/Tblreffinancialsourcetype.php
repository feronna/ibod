<?php

namespace app\models\harta;

use Yii;

/**
 * This is the model class for table "harta.tblreffinancialsourcetype".
 *
 * @property int $id
 * @property string $FinclSrcTypeCd
 * @property string $FinclSrcTypeNm
 */
class Tblreffinancialsourcetype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tblreffinancialsourcetype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FinclSrcTypeCd'], 'required'],
            [['FinclSrcTypeCd'], 'string', 'max' => 2],
            [['FinclSrcTypeNm'], 'string', 'max' => 40],
            [['FinclSrcTypeCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'FinclSrcTypeCd' => 'Fincl Src Type Cd',
            'FinclSrcTypeNm' => 'Fincl Src Type Nm',
        ];
    }
}
