<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_tbl_markah_keseluruhan".
 *
 * @property string $markah_id
 * @property int $lpp_id
 * @property double $markah_PPP
 * @property double $markah_PPK
 * @property double $markah_PP
 * @property string $catatan
 * @property double $markah_CPD
 */
class TblMarkahKeseluruhan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_markah_keseluruhan';
    }
    
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id'], 'integer'],
            [['markah_PPP', 'markah_PPK', 'markah_PP', 'markah_CPD'], 'number'],
            [['catatan'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'markah_id' => Yii::t('app', 'Markah ID'),
            'lpp_id' => Yii::t('app', 'Lpp ID'),
            'markah_PPP' => Yii::t('app', 'Markah Ppp'),
            'markah_PPK' => Yii::t('app', 'Markah Ppk'),
            'markah_PP' => Yii::t('app', 'Markah Pp'),
            'catatan' => Yii::t('app', 'Catatan'),
            'markah_CPD' => Yii::t('app', 'Markah Cpd'),
        ];
    }
}
