<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.temuduga_pentadbiran".
 *
 * @property int $id
 * @property int $gred_id
 * @property string $tarikh_iv
 * @property string $masa_iv
 */
class TemudugaPentadbiran extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_temuduga_pentadbiran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['gred_id', 'ads_id'], 'integer'],
            [['tarikh_iv','notify_status_iv'], 'safe'],
            [['masa_iv'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'gred_id' => 'Gred ID',
            'tarikh_iv' => 'Tarikh Iv',
            'masa_iv' => 'Masa Iv',
        ];
    }

    public function getJawatan() {
        return $this->hasOne(\app\models\cv\GredJawatan::className(), ['id' => 'gred_id']);
    }

    public function getTotalIV() {

        return \app\models\cv\TemudugaPentadbiran::find()
                        ->leftJoin('hrm.cv_tbl_temuduga_pentadbiran', 'cv_temuduga_pentadbiran.gred_id = cv_tbl_temuduga_pentadbiran.gred_apply')
                        ->where(['cv_tbl_temuduga_pentadbiran.gred_apply' => $this->gred_id])
                        ->andWhere(['cv_tbl_temuduga_pentadbiran.iv_id' => $this->id])
                        ->count();
    }

    public function getFindTotalQualified() {

        return \app\models\cv\TemudugaPentadbiran::find()
                        ->leftJoin('hrm.cv_tbl_temuduga_pentadbiran', 'cv_temuduga_pentadbiran.id = cv_tbl_temuduga_pentadbiran.iv_id')
                        ->andWhere(['cv_tbl_temuduga_pentadbiran.iv_id' => $this->id])
                        ->andWhere(['cv_tbl_temuduga_pentadbiran.qualified' => 1])
                        ->count();
    }

}
