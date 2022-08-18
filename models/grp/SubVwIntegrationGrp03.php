<?php

namespace app\models\grp;

use Yii;

/**
 * This is the model class for table "integration.sub_vw_integration_grp_03".
 *
 * @property string $CONm
 * @property string $ICNO
 * @property int $jumlah
 */
class SubVwIntegrationGrp03 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'integration.sub_vw_integration_grp_03';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jumlah'], 'integer'],
            [['CONm'], 'string', 'max' => 255],
            [['ICNO'], 'string', 'max' => 12],
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
            'jumlah' => 'Jumlah',
        ];
    }
}
