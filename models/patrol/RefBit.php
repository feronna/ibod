<?php

namespace app\models\patrol;

use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\TblRekod;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "keselamatan.patrol_ref_bit".
 *
 * @property int $id
 * @property string $bit_name
 * @property int $route_id refer to ref_route
 * @property string $position position where will the sequence of bit scanned
 * @property string $lat
 * @property string $lng
 * @property string $encrypted
 */
class RefBit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $latlng;

    public static function tableName()
    {
        return 'keselamatan.patrol_ref_bit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['encrypted'], 'string', 'max' => 150],
            [['updated_by'], 'string', 'max' => 12],
            [['updated_dt'], 'safe'],

            [['route_id', 'position', 'isActive'], 'integer'],
            [['bit_name', 'lat', 'lng'], 'string', 'max' => 50],

            //check exists
            [['bit_name'], 'check', 'on' => ['bit']],
            [['position'], 'check', 'on' => ['bit']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bit_name' => 'Bit Name',
            'route_id' => 'Route ID',
            'position' => 'Position',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'encrypted' => 'Encrypted',
        ];
    }
    public static function distance($latlng, $bit)
    {
        $myArray = explode(',', $latlng);

        $lat2 = $myArray[0];
        $lon2 = $myArray[1];

        $find = self::findOne(['id' => $bit]);
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

    public function check($attribute, $params)
    {

        $model = self::find()->where(['bit_name' => $this->bit_name])->andWhere(['route_id' => $this->route_id])->exists();
        $model1 = self::find()->where(['position' => $this->position])->andWhere(['route_id' => $this->route_id])->exists();


        if ($model) {

            $this->addError($attribute, 'Telah Wujud');
        }
        if ($model1) {

            $this->addError($attribute, 'Telah wujud!');
        }
    }
    public static function countBit($pos)
    {

        $val = 0;
        $model = self::find()->where(['route_id' => $pos])->andWhere(['isActive' => 1])->all();
        if ($model) {
            $val = count($model);
        }

        return $val;
    }
    public static function DisplayLoc($id)
    {
        $val = '';

        $model = self::findOne(['id' => $id]);


        if ($model) {

            $val = $model->lat ? '<a href="https://www.google.com/maps/dir/' . $model->lat . ',' . $model->lng . '/' .  $model->lat . ',' . $model->lng . '/@' .  $model->lat . ',' . $model->lng . ',18z" target="_blank" class="btn-primary btn-sm">MAPS</a>' : '';
        }

        return $val;
    }

    public static function getBlob($id)
    {
        $model = self::findOne(['id' => $id]);
        var_dump(Html::img('data:image/png;base64,' . base64_encode($model->fileName), ['alt' => 'My image']));
        die;
        // return Html::img('data:image/png;base64,'.base64_encode($model->fileName), ['alt' => 'My image']);
    }
    public static function Name($id, $type, $route_id)
    {
        $val = "";
        $model = self::findOne(['id' => $id]);
        $pos = RefPosKawalan::findOne(['id' => $route_id]);
        if ($type == 'pos-start') {

            $val = $pos->pos_kawalan . ' - Mula';
        } elseif ($type == 'pos-end') {
            $val = $pos->pos_kawalan . ' - Tamat';
        } else {
            $val = $model->bit_name;
        }
        return $val;
    }
    public static function patroltotal($pos, $shift, $icno, $date = null, $cuti = null, $inc = null)
    {

        $val = 0;
        $pk = self::find()->where(['route_id' => $pos])->count();
        if (!$date) {
            $date = date('Y-m-d');
        }
        if (!$inc) {
            if (!$cuti) {

                $cuti = TblRekod::DisplayCuti($icno, $date);
            }
        }

        // var_dump($cuti);
        $excused = TblExcused::find()->where(['icno' => $icno])->andWhere(['date' => $date])->andWhere(['shift_id' => $shift])->andWhere(['status' => 'APPROVED'])->one();
        if (!$excused && $cuti == "") {

            if ($shift == 3 || $shift == 18) {
                $val = 4 * $pk;
            }

            if ($shift == 4 || $shift == 19 || $shift == 23 || $shift == 24) {
                $val = 2 * $pk;
            }
            if ($shift == 5 || $shift == 20) {
                $val = 3 * $pk;
            }
        } else {
            $val = Rekod::countpatrol($icno, $date, $shift);
        }
        return $val;
    }
}
