<?php

namespace app\models\ejobs;

use app\models\ejobs\TblpEdusubjek;
use Yii;

/**
 * This is the model class for table "ejobs.tbl_edusubjek_bm".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $EduLevel_id
 * @property int $gred_id
 */
class TblpEduSyaratBm extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ejobs.tbl_edusubjek_bm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ICNO', 'EduLevel_id', 'gred_id', 'EduSchool', 'EduYear'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['EduLevel_id', 'EduYear', 'gred_id'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
            ['EduYear', 'checkYear'],
        ];
    }

    public function checkYear($attribute) {
        if (!preg_match('/^[0-9]{4}$/', $this->$attribute)) {
            $this->addError($attribute, 'Tahun Graduasi tidak lebih 4 digit.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'EduLevel_id' => 'Tahap Pendidikan',
            'gred_id' => 'Gred',
        ];
    }

    public function getChild() {
        return $this->hasMany(TblpEdusubjek::className(), ['bm_id' => 'id']);
    }

}
