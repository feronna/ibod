<?php

namespace app\models\keselamatan;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "keselamatan.ref_pos_kawalan".
 *
 * @property int $id
 * @property string $pos_kawalan
 * @property string $pecahan_pos
 * @property string $added_by
 * @property string $updated_by
 * @property string $kampus
 * @property int $active
 */
class RefPosKawalan extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.ref_pos_kawalan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['active'], 'integer'],
            [['pos_kawalan'], 'string', 'max' => 50],
            [['pecahan_pos'], 'string', 'max' => 250],
            [['file_hashcode','start_hashcode','end_hashcode'], 'string', 'max' => 100],
            [['added_by', 'updated_by', 'kampus_id'], 'string', 'max' => 20],
            [['pos_kawalan'], 'check', 'on' => ['bit']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'pos_kawalan' => 'Pos Kawalan',
            'pecahan_pos' => 'Pecahan Pos',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
            'kampus' => 'Kampus',
            'active' => 'Active',
        ];
    }

    public function getStatus() {
        if ($this->active == '1') {
            return '<span class="label label-success">Aktif</span>';
        } else {
            return '<span class="label label-warning">Tidak Aktif</span>';
        }
    }

    public function getCampus() {
        return $this->hasOne(\app\models\hronline\Campus::className(), ['campus_id' => 'kampus_id']);
    }
    public function check($attribute, $params)
    {

        $model = self::find()->where(['LIKE','pos_kawalan' ,$this->pos_kawalan])->exists();
        // $model1 = self::find()->where(['position' => $this->position])->andWhere(['route_id'=>$this->route_id])->exists();

      
        if ($model) {

            $this->addError($attribute, 'Pos Kawalan Telah Wujud');
        }
      
    }
    public static function namapos($id){
        $val = "";
        $model = self::findOne(['id' => $id]);
        if($model){
            $val = $model->pos_kawalan;
        }
        return $val;
    }
    public static function file($id){
        $val = "";
        $model = self::findOne(['id'=>$id]);
        if($model){
            $val = $model->file_hashcode;
        }
        return $val;
    }
  
    public function getDisplayLink()
    {
        if (!empty($this->file_hashcode && $this->file_hashcode != 'deleted')) {
            return Html::a(Yii::$app->FileManager->NameFile($this->file_hashcode), Yii::$app->FileManager->DisplayFile($this->file_hashcode));
        }
        return 'File not exist!';
    }
    public static function distance($latlng, $id)
    {
        $myArray = explode(',', $latlng);

        $lat2 = $myArray[0];
        $lon2 = $myArray[1];

        $find = self::findOne(['id' => $id]);
        $lat1 = $find->lat;
        $lon1 = $find->lng;
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            // $unit = strtoupper($unit);
            $cal = $miles * 1.609344;
            // var_dump($cal);die;
            if ($cal < 0.15) {
                return true;
            } else {
                return false;
            }
            // if ($unit == "K") {
            //   return ($miles * 1.609344);
            // } else if ($unit == "N") {
            //   return ($miles * 0.8684);
            // } else {
            //   return $miles;
            // }
        }
    }
}
