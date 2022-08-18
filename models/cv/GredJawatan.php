<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.gredjawatan".
 *
 * @property int $id
 * @property string $nama
 * @property string $gred
 * @property string $skim
 * @property string $skimno
 * @property string $fname
 * @property string $kumpulan
 * @property int $svc
 * @property string $kosong
 */
class GredJawatan extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {//khas for cv online
        return 'hrm.cv_gredjawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['svc', 'isActive', 'up_rank'], 'integer'],
            [['nama', 'fname', 'kumpulan'], 'string', 'max' => 255],
            [['gred', 'skim', 'skimno'], 'string', 'max' => 10],
            [['kosong'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'gred' => 'Gred',
            'skim' => 'Skim',
            'skimno' => 'Skimno',
            'fname' => 'Fname',
            'kumpulan' => 'Kumpulan',
            'svc' => 'Svc',
            'kosong' => 'Kosong',
        ];
    }

    public function getTemuduga() {
        return $this->hasOne(\app\models\cv\TemudugaPentadbiran::className(), ['gred_id' => 'id'])->where(['tarikh_iv' => date("Y-m-d")]);
    }

    public function getDisplayKenaikan() {
        $model = GredJawatan::find()->where(['id' => $this->up_rank])->one();

        return $model ? $model->fname : '-';
    }

}
