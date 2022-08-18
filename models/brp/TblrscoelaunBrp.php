<?php

namespace app\models\brp;

use Yii;

/**
 * This is the model class for table "brp.tblrscoelaun_brp".
 *
 * @property string $el_id PK, auto incr
 * @property string $el_brp_id
 * @property int $el_elaun_cd
 * @property string $el_amount
 * @property string $el_created_by
 * @property string $el_created_date
 */
class TblrscoelaunBrp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.brp_tblrscoelaun_brp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['el_brp_id', 'el_elaun_cd'], 'integer'],
            [['el_amount'], 'number'],
            [['el_created_date'], 'safe'],
            [['el_created_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'el_id' => 'El ID',
            'el_brp_id' => 'El Brp ID',
            'el_elaun_cd' => 'El Elaun Cd',
            'el_amount' => 'El Amount',
            'el_created_by' => 'El Created By',
            'el_created_date' => 'El Created Date',
        ];
    }
}
