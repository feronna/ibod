<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cv.cv_tbl_jobdetails".
 *
 * @property string $uid
 * @property string $jobdetails
 * @property int $id
 * @property string $ICNO
 */
class TblJobdetails extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_tbl_jobdetails';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['jobdetails'], 'required'],
            [['jobdetails'], 'string', 'max' => 255],
            [['uid'], 'string', 'max' => 20],
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'uid' => 'Uid',
            'jobdetails' => 'Tugasan',
            'id' => 'ID',
            'ICNO' => 'Icno',
        ];
    }

    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }

    public function getRecordLnpt() {
        return \app\models\lppums\TblSenaraiTugas::find()->joinWith('lpp')
                        ->where(['lppums_lpp.PYD' => Yii::$app->user->getId()])
                        ->andWhere(['!=', 'lppums_lpp.tahun', date('Y')])
                        ->orderBy(['lppums_lpp.tahun' => SORT_DESC])
                        ->all();
    }
    
    public function getRecordLnptGrid() {
        return \app\models\lppums\TblSenaraiTugas::find()->joinWith('lpp')
                        ->where(['lppums_lpp.PYD' => Yii::$app->user->getId()])
                        ->andWhere(['!=', 'lppums_lpp.tahun', date('Y')])
                        ->orderBy(['lppums_lpp.tahun' => SORT_DESC]);
    }

}
