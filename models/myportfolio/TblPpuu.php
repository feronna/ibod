<?php

namespace app\models\myportfolio;

use Yii;

/**
 * This is the model class for table "myportfolio.tbl_ppuu".
 *
 * @property int $id
 * @property string $icno
 */
class TblPpuu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_tbl_ppuu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
        ];
    }
}
