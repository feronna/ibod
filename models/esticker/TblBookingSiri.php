<?php

namespace app\models\esticker;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "{{%keselamatan.stc_booking_siri}}".
 *
 * @property int $id
 * @property int $stc_type
 * @property string $veh_type
 * @property string $kod_siri
 * @property string $siri
 * @property string $no_siri
 * @property int $id_kenderaan
 * @property string $ICNO
 * @property string $created_at
 * @property string $created_by
 */
class TblBookingSiri extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%keselamatan.stc_booking_siri}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['stc_type', 'id_kenderaan'], 'integer'],
            [['created_at'], 'safe'],
            [['veh_type'], 'string', 'max' => 10],
            [['kod_siri'], 'string', 'max' => 5],
            [['siri', 'no_siri'], 'string', 'max' => 15],
            [['ICNO', 'created_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'stc_type' => 'Stc Type',
            'veh_type' => 'Veh Type',
            'kod_siri' => 'Kod Siri',
            'siri' => 'Siri',
            'no_siri' => 'No Siri',
            'id_kenderaan' => 'Id Kenderaan',
            'ICNO' => 'Icno',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    public static function findRunningSiri($type) {
        // 1. hold booked 
        $booked = ArrayHelper::toArray(TblBookingSiri::find()->where(['kod_siri' => $type])->select('siri')->column());
        // 2. find running exclude booking & find minimum running

        if ($booked) {
            $min_siri = TblPelekatKenderaan::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->andWhere(['not in', 'siri', $booked])->min('siri');
        } else {
            $min_siri = TblPelekatKenderaan::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->min('siri');
        }
        // 3. check if (ada minimum running no) => min num +1 else start running first no
        if ($min_siri) {
            $initial = TblPelekatKenderaan::find()->where(['kod_siri' => $type])->andWhere(['no_siri' => '000001'])->one();
            if (empty($initial)) {
                $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
            } else {
                $running_siri = str_pad($min_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } else {
            $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
        }
        // 4. check if (exist minimum number) infinite looping (stop if not exist)  
        $exist = '';
        do {
            $exist = TblPelekatKenderaan::findOne(['kod_siri' => $type,'siri' => $running_siri]);
            if ($exist) {
                $running_siri = str_pad($running_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } while (!empty($exist));

        return $running_siri;
    }
    
    public static function findRunningSiriStudent($type) {
        // 1. hold booked 
        $booked = ArrayHelper::toArray(TblBookingSiri::find()->where(['kod_siri' => $type])->select('siri')->column());
        // 2. find running exclude booking & find minimum running

        if ($booked) {
            $min_siri = TblPelekatKenderaanStudent::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->andWhere(['not in', 'siri', $booked])->min('siri');
        } else {
            $min_siri = TblPelekatKenderaanStudent::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->min('siri');
        }
        // 3. check if (ada minimum running no) => min num +1 else start running first no
        if ($min_siri) {
            $initial = TblPelekatKenderaanStudent::find()->where(['kod_siri' => $type])->andWhere(['no_siri' => '000001'])->one();
            if (empty($initial)) {
                $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
            } else {
                $running_siri = str_pad($min_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } else {
            $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
        }
        // 4. check if (exist minimum number) infinite looping (stop if not exist)  
        $exist = '';
        do {
            $exist = TblPelekatKenderaanStudent::findOne(['kod_siri' => $type,'siri' => $running_siri]);
            if ($exist) {
                $running_siri = str_pad($running_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } while (!empty($exist));

        return $running_siri;
    }
    
    public static function findRunningSiriJabatan($type) {
        // 1. hold booked 
        $booked = ArrayHelper::toArray(TblBookingSiri::find()->where(['kod_siri' => $type])->select('siri')->column());
        // 2. find running exclude booking & find minimum running

        if ($booked) {
            $min_siri = TblPelekatKenderaanJabatan::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->andWhere(['not in', 'siri', $booked])->min('siri');
        } else {
            $min_siri = TblPelekatKenderaanJabatan::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->min('siri');
        }
        // 3. check if (ada minimum running no) => min num +1 else start running first no
        if ($min_siri) {
            $initial = TblPelekatKenderaanJabatan::find()->where(['kod_siri' => $type])->andWhere(['no_siri' => '000001'])->one();
            if (empty($initial)) {
                $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
            } else {
                $running_siri = str_pad($min_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } else {
            $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
        }
        // 4. check if (exist minimum number) infinite looping (stop if not exist)  
        $exist = '';
        do {
            $exist = TblPelekatKenderaanJabatan::findOne(['kod_siri' => $type,'siri' => $running_siri]);
            if ($exist) {
                $running_siri = str_pad($running_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } while (!empty($exist));

        return $running_siri;
    }
    
    public static function findRunningSiriKontraktor($type) {
        // 1. hold booked 
        $booked = ArrayHelper::toArray(TblBookingSiri::find()->where(['kod_siri' => $type])->select('siri')->column());
        // 2. find running exclude booking & find minimum running

        if ($booked) {
            $min_siri = TblPelekatKenderaanKontraktor::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->andWhere(['not in', 'siri', $booked])->min('siri');
        } else {
            $min_siri = TblPelekatKenderaanKontraktor::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->min('siri');
        }
        // 3. check if (ada minimum running no) => min num +1 else start running first no
        if ($min_siri) {
            $initial = TblPelekatKenderaanKontraktor::find()->where(['kod_siri' => $type])->andWhere(['no_siri' => '000001'])->one();
            if (empty($initial)) {
                $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
            } else {
                $running_siri = str_pad($min_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } else {
            $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
        }
        // 4. check if (exist minimum number) infinite looping (stop if not exist)  
        $exist = '';
        do {
            $exist = TblPelekatKenderaanKontraktor::findOne(['kod_siri' => $type,'siri' => $running_siri]);
            if ($exist) {
                $running_siri = str_pad($running_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } while (!empty($exist));

        return $running_siri;
    }
    
     public static function findRunningSiriPelawat($type) {
        // 1. hold booked 
        $booked = ArrayHelper::toArray(TblBookingSiri::find()->where(['kod_siri' => $type])->select('siri')->column());
        // 2. find running exclude booking & find minimum running

        if ($booked) {
            $min_siri = TblPelekatKenderaanPelawat::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->andWhere(['not in', 'siri', $booked])->min('siri');
        } else {
            $min_siri = TblPelekatKenderaanPelawat::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->min('siri');
        }
        // 3. check if (ada minimum running no) => min num +1 else start running first no
        if ($min_siri) {
            $initial = TblPelekatKenderaanPelawat::find()->where(['kod_siri' => $type])->andWhere(['no_siri' => '000001'])->one();
            if (empty($initial)) {
                $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
            } else {
                $running_siri = str_pad($min_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } else {
            $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
        }
        // 4. check if (exist minimum number) infinite looping (stop if not exist)  
        $exist = '';
        do {
            $exist = TblPelekatKenderaanPelawat::findOne(['kod_siri' => $type,'siri' => $running_siri]);
            if ($exist) {
                $running_siri = str_pad($running_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } while (!empty($exist));

        return $running_siri;
    }
    
    public static function findRunningSiriVip($type) {
        // 1. hold booked 
        $booked = ArrayHelper::toArray(TblBookingSiri::find()->where(['kod_siri' => $type])->select('siri')->column());
        // 2. find running exclude booking & find minimum running

        if ($booked) {
            $min_siri = TblPelekatKenderaanVip::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->andWhere(['not in', 'siri', $booked])->min('siri');
        } else {
            $min_siri = TblPelekatKenderaanVip::find()->where(['kod_siri' => $type])->andWhere(['is not', 'no_siri', NULL])->min('siri');
        }
        // 3. check if (ada minimum running no) => min num +1 else start running first no
        if ($min_siri) {
            $initial = TblPelekatKenderaanVip::find()->where(['kod_siri' => $type])->andWhere(['no_siri' => '000001'])->one();
            if (empty($initial)) {
                $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
            } else {
                $running_siri = str_pad($min_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } else {
            $running_siri = str_pad(1, 6, '0', STR_PAD_LEFT);
        }
        // 4. check if (exist minimum number) infinite looping (stop if not exist)  
        $exist = '';
        do {
            $exist = TblPelekatKenderaanVip::findOne(['kod_siri' => $type,'siri' => $running_siri]);
            if ($exist) {
                $running_siri = str_pad($running_siri + 1, 6, '0', STR_PAD_LEFT);
            }
        } while (!empty($exist));

        return $running_siri;
    }

}
