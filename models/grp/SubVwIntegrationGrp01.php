<?php

namespace app\models\grp;

use Yii;

/**
 * This is the model class for table "integration.sub_vw_integration_grp_01".
 *
 * @property string $CONm
 * @property string $ICNO
 * @property string $GenderCd
 * @property int $JUMLAH_ISTERI
 */
class SubVwIntegrationGrp01 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'integration.sub_vw_integration_grp_01';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['JUMLAH_ISTERI'], 'integer'],
            [['CONm'], 'string', 'max' => 255],
            [['ICNO'], 'string', 'max' => 12],
            [['GenderCd'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CONm' => 'Co Nm',
            'ICNO' => 'Icno',
            'GenderCd' => 'Gender Cd',
            'JUMLAH_ISTERI' => 'Jumlah  Isteri',
        ];
    }
}
