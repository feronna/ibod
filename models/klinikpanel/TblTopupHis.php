<?php

namespace app\models\klinikpanel;

use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "klinikpanel2.tbl_topup_his".
 *
 * @property int $id
 * @property string $icno
 * @property string $topup_amount
 * @property string $topup_by
 * @property string $topup_dt
 */
class TblTopupHis extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb()
    {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_tbl_topup_his';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topup_amount'], 'number'],
            [['topup_dt'], 'safe'],
            [['icno', 'topup_by'], 'string', 'max' => 15],
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
            'topup_amount' => 'Topup Amount',
            'topup_by' => 'Topup By',
            'topup_dt' => 'Topup Dt',
        ];
    }

    public function getPenambah()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'topup_by']);
    }

    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

}
