<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.requirement_main".
 *
 * @property int $gred
 * @property string $gred
 * @property string $desc
 */
class RequirementMain extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_requirement_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['desc'], 'string'],
            [['gred'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'gred' => 'Gred',
            'desc' => 'Desc',
        ];
    }

    public function penerbitan($gred,$cluster) {
        return RequirementPenerbitan::findAll(['gred' => $gred, 'cluster' => $cluster]);
    }

    public function pengajaran($gred,$cluster) {
        return RequirementPengajaran::findAll(['gred' => $gred, 'cluster' => $cluster]);
    }

    public function penyeliaan($gred,$cluster) {
        return RequirementPenyeliaan::findAll(['gred' => $gred, 'cluster' => $cluster]);
    }

    public function penyelidikan($gred,$cluster) {
        return RequirementPenyelidikan::findAll(['gred' => $gred, 'cluster' => $cluster]);
    }

    public function perundingan($gred,$cluster) {
        return RequirementPerundingan::findAll(['gred' => $gred, 'cluster' => $cluster]);
    }
    
    public function service($gred,$cluster) {
        return RequirementService::findAll(['gred' => $gred, 'cluster' => $cluster]);
    }

    public function persidangan($gred,$cluster) {
        return RequirementPersidangan::findAll(['gred' => $gred, 'cluster' => $cluster]);
    }

    public static function umum() {
        return RequirementUmum::find()->all();
    }

}
