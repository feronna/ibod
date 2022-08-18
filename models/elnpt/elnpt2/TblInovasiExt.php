<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_tbl_inovasi".
 *
 * @property int $id
 * @property string $tajuk_projek
 * @property int $lpp_id
 * @property int $bil_impak
 * @property double $amaun_projek
 */
class TblInovasiExt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_tbl_inovasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'bil_impak'], 'integer'],
            [['amaun_projek'], 'number'],
            [['tajuk_projek'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tajuk_projek' => 'Tajuk Projek',
            'lpp_id' => 'Lpp ID',
            'bil_impak' => 'Bil Impak',
            'amaun_projek' => 'Amaun Projek',
        ];
    }
}
