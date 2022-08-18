<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.requirement_umum".
 *
 * @property int $id
 * @property int $main_id
 * @property string $requirement
 * @property string $ans_char
 * @property int $ans_no
 * @property string $ans_decimal
 */
class RequirementUmum extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_requirement_umum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ans_no'], 'integer'],
            [['requirement'], 'string'],
            [['ans_decimal'], 'number'],
            [['ans_char'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'requirement' => 'Requirement',
            'ans_char' => 'Ans Char',
            'ans_no' => 'Ans No',
            'ans_decimal' => 'Ans Decimal',
        ];
    }

    public static function penerbitan($gred, $cluster) {
        return RequirementPenerbitan::findAll(['gred_id' => $gred, 'cluster' => $cluster]);
    }

    public static function pengajaran($gred, $cluster) {
        return RequirementPengajaran::findAll(['gred_id' => $gred, 'cluster' => $cluster]);
    }

    public static function penyeliaan($gred, $cluster) {
        return RequirementPenyeliaan::findAll(['gred_id' => $gred, 'cluster' => $cluster]);
    }

    public static function penyelidikan($gred, $cluster) {
        return RequirementPenyelidikan::findAll(['gred_id' => $gred, 'cluster' => $cluster]);
    }

    public static function perundingan($gred, $cluster) {
        return RequirementPerundingan::findAll(['gred_id' => $gred, 'cluster' => $cluster]);
    }

    public static function service($gred, $cluster) {
        return RequirementService::findAll(['gred_id' => $gred, 'cluster' => $cluster]);
    }

    public static function persidangan($gred, $cluster) {
        return RequirementPersidangan::findAll(['gred_id' => $gred, 'cluster' => $cluster]);
    }

    public static function tempoh($gred) {
        if ($gred == 99) { //pentadbiran
            return RequirementTempoh::find()->where(['gred_id' => $gred])->all();
        } else {
            return RequirementTempoh::findOne(['gred_id' => $gred]);
        }
    }

    public static function umum($lantikan) {
        if ($lantikan == 1) {
            return RequirementUmum::find()->all();
        } else {
            return RequirementUmum::find()->where(['not in', 'id', [1,3]])->all();
        }
    }

}
