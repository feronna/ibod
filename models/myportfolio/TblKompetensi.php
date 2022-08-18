<?php

namespace app\models\myportfolio;

use Yii;

/**
 * This is the model class for table "myportfolio.tbl_kompetensi".
 *
 * @property int $id
 * @property string $icno
 * @property string $kompetensi
 * @property string $portfolio_id
 */
class TblKompetensi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_tbl_kompetensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 12],
            [['kompetensi'], 'required', 'message' => Yii::t('app', 'Wajib Diisi')],
            [['portfolio_id'], 'string', 'max' => 50],
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
            'kompetensi' => 'Kompetensi',
            'portfolio_id' => 'Portfolio ID',
        ];
    }
}
