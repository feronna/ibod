<?php

namespace app\models\esticker;

use yii\data\ActiveDataProvider;
use Yii;

/**
 * This is the model class for table "keselamatan.stc_pay_rate".
 *
 * @property int $id
 * @property string $type
 * @property string $amount
 * @property string $amount2
 * @property string $desc
 * @property string $maximum_desc
 * @property int $maximum
 */
class PayRate extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.stc_pay_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['amount', 'amount2', 'bas_lori_rate'], 'number'],
            [['maximum', 'period'], 'integer'],
            [['type'], 'string', 'max' => 150],
            [['desc', 'maximum_desc'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'amount' => 'Amount',
            'amount2' => 'Amount2',
            'desc' => 'Desc',
            'maximum_desc' => 'Maximum Desc',
            'maximum' => 'Maximum',
        ];
    }

    public static function findGridRate() {

        $model = new ActiveDataProvider([
            'query' => PayRate::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $model;
    }

    public static function findGridRatebyType($type) {

        $model = new ActiveDataProvider([
            'query' => PayRate::find()->where(['IN','type',$type]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $model;
    }

    public static function findTotalAktifSticker($id) {
        $model = TblPelekatKenderaan::find()->joinWith('kenderaan')->where(['stc_sticker_staf.v_co_icno' => $id])->andWhere(['stc_sticker_staf.status_kenderaan' => 'AKTIF'])->all();
        $i = 0;
        foreach ($model as $model) {
            if ($model->status_mohon == 'AKTIF') {

                if (empty($model->expired_date_2)) {
                    if (date('Y-m-d') < $model->expired_date_1) {
                        $i++;
                    }
                } else {
                    if (date('Y-m-d') < $model->expired_date_2) {
                        $i++;
                    }
                }
            }

            if ($model->status_mohon == 'MENUNGGU BAYARAN KAUNTER' || $model->status_mohon == 'MENUNGGU KUTIPAN') {
                $i++;
            }
        }

        return $i;
    }

    public static function findAmountRate($type, $id, $index) {
        $total_veh = PayRate::findTotalAktifSticker($id);
        $model = PayRate::find()->where(['type' => $type])->one();
        $rate = $model->amount;
        if (in_array($type, ['KHAS', 'STAFF'])) {
            if ($total_veh >= 2) {
                $rate = $model->amount2;
            }
        }

        return $rate;
    }
    
    public static function findAmountRateLanjutan($id) {
        $pelekat = TblPelekatKenderaan::find()->where(['id_kenderaan' => $id])->andWhere(['status_mohon'=>'AKTIF'])->one();
          
        return $pelekat->total;
    }

}
