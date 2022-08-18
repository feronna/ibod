<?php

namespace app\models\cuti;

use Yii;

/**
 * This is the model class for table "e_cuti.jenis_cuti".
 *
 * @property int $jenis_cuti_id
 * @property string $jenis_cuti_nama
 * @property string $jenis_cuti_catatan
 * @property int $jenis_cuti_kira 1 = kira, 0 = tidak kira
 * @property int $jenis_cuti_papar
 * @property int $ctr
 * @property string $form_type
 */
class JenisCuti extends \yii\db\ActiveRecord {

    // add the function below:
//    public static function getDb() {
//        return Yii::$app->get('db2'); // second database
//    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        // return 'e_cuti.jenis_cuti';
        return 'hrm.cuti_leave_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['jenis_cuti_kira', 'jenis_cuti_papar','ctr'], 'integer'],
                [['jenis_cuti_nama'], 'string', 'max' => 10],
                [['form_type'], 'string', 'max' => 20],
                [['jenis_cuti_catatan','jenis_cuti_catatan_bi'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'jenis_cuti_id' => 'Jenis Cuti ID',
            'jenis_cuti_nama' => 'Jenis Cuti Nama',
            'jenis_cuti_catatan' => 'Jenis Cuti Catatan',
            'jenis_cuti_kira' => 'Jenis Cuti Kira',
            'jenis_cuti_papar' => 'Jenis Cuti Papar',
            'ctr' => 'isCTR',
            'form_type' => 'Jenis Form',
        ];
    }
    
    public function getFullname() {
        return $this->jenis_cuti_nama . ' - '. $this->jenis_cuti_catatan;
    }

}
