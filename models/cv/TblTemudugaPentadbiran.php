<?php

namespace app\models\cv;
use app\models\cv\TblpMarkahIv;
use app\models\hronline\Tblprcobiodata;
use app\models\cv\TemudugaPentadbiran;

use Yii;

/**
 * This is the model class for table "cvonline.cv_tbl_temuduga_pentadbiran".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $gred_apply
 * @property int $isActive
 */
class TblTemudugaPentadbiran extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_temuduga_pentadbiran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gred_apply','iv_id', 'isActive','qualified'], 'integer'],
             [['qualified','qualified_datetime', 'qualified_by'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'gred_apply' => 'Gred Apply',
            'isActive' => 'Is Active',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    } 
    
    public function MarkahIvBPanel($iv_id) {
        return TblpMarkahIv::find()->where(['iv_id' => $iv_id])
                                    ->andWhere(['panel_ICNO' => Yii::$app->user->getId()])
                                    ->andWhere(['=', 'DATE(datetime)', date("Y-m-d")])->one();
    }
    
    public function checkMarkahIv($iv_id) {
        return TblpMarkahIv::find()->where(['iv_id' => $iv_id])->one();
    } 

    public function jumlahMarkahIv($iv_id) {
        $model = TblpMarkahIv::find()->where(['iv_id' => $iv_id])->all();
        $markah = 0;
        foreach ($model as $i => $model) {
            $i = $i + 1;
            $markah = $markah + $model->markah;
        }

        return $markah . '/' . $i;
    }
    
    public function checkJd($icno) {
        return \app\models\myportfolio\TblPortfolio::find()->where(['icno' => $icno])->andWhere(['status_hantar'=>1])->one();
    }
    
    public function getTemuduga() {
       return $this->hasOne(TemudugaPentadbiran::className(), ['id' => 'iv_id']);
    }
}
