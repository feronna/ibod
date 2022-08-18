<?php

namespace app\models\patrol;

use Yii;

/**
 * This is the model class for table "keselamatan.patrol_rating".
 *
 * @property int $id
 * @property string $icno
 * @property string $month_date
 * @property double $rating
 * @property double $percentage
 */
class PatrolRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.patrol_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month_date'], 'safe'],
            [['rating_hakiki','rating_lmj','percentage_hakiki','percentage_lmj'], 'number'],
            [['icno'], 'string', 'max' => 12],
            [['jum_hakiki','jum_lm'], 'integer'],
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
            'month_date' => 'Month Date',
            'rating' => 'Rating',
            'percentage' => 'Percentage',
        ];
    }
    public static function rating($icno,$yr,$mth){

        $val = '';
        if (Rekod::months($mth)) {
            // echo 'd';die;
            $mth =  Rekod::months($mth);
        }  

        $model = self::find()->where(['icno' => $icno])->andWhere(['MONTH(month_date)' => $mth])->andWhere(['YEAR(month_date)' => $yr])->one();
        if($model){
            $val = $model->rating_hakiki;

        }
        return $val;
    }
    public static function monthlyhakiki($icno, $mth, $yr)
    {
        $val = '0';

        if (Rekod::months($mth)) {
            $mth =  Rekod::months($mth);
        }
        $model = self::find()->where(['icno' => $icno])->andWhere(['MONTH(month_date)' => $mth])->andWhere(['YEAR(month_date)' => $yr])->one();
        if($model){
            $val = $model->jum_hakiki;

        }
        return $val;

    }
    public static function monthlylm($icno, $mth, $yr)
    {
        $val = '0';

        if (Rekod::months($mth)) {
            $mth =  Rekod::months($mth);
        }
        $model = self::find()->where(['icno' => $icno])->andWhere(['MONTH(month_date)' => $mth])->andWhere(['YEAR(month_date)' => $yr])->one();
        if($model){
            $val = $model->jum_lm;

        }
        return $val;

    }
    public static function monthlypercents($icno, $mth, $yr)
    {
        $val = '0';

        if (Rekod::months($mth)) {
            $mth =  Rekod::months($mth);
        }
        $model = self::find()->where(['icno' => $icno])->andWhere(['MONTH(month_date)' => $mth])->andWhere(['YEAR(month_date)' => $yr])->one();
        if($model){
            $val = $model->percentage_hakiki;

        }
        return $val;

    }
}
