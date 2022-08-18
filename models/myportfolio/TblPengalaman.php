<?php

namespace app\models\myportfolio;

use Yii;

/**
 * This is the model class for table "myportfolio.tbl_pengalaman".
 *
 * @property int $id
 * @property string $icno
 * @property string $pengalaman
 * @property string $portfolio_id
 */
class TblPengalaman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_tbl_pengalaman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 12],
            [['pengalaman', 'tempoh'], 'required','message' => Yii::t('app', 'Wajib Diisi')],
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
            'pengalaman' => 'Pengalaman',
            'portfolio_id' => 'Portfolio ID',
            'tempoh' => 'tempoh'
        ];
    }
}
