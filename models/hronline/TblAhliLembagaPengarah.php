<?php

namespace app\models\hronline; 
use Yii;

/**
 * This is the model class for table "{{%hrm.lpu_tbl_ahli_lpu}}".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $title
 * @property string $name
 * @property string $addr
 * @property string $poskod
 * @property int $city_id
 * @property int $state_id
 * @property string $no_tel_1
 * @property string $no_tel_2
 * @property string $no_phone
 * @property string $no_faks
 * @property string $email
 * @property string $date_assign
 * @property string $pa_title_id
 * @property string $pa_name
 * @property string $pa_email
 * @property string $pa_phone
 * @property int $post_id position LPU
 * @property string $created_at
 * @property string $created_by
 * @property int $isActive
 */
class TblAhliLembagaPengarah extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%hrm.lpu_tbl_ahli_lpu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'name', 'post_id', 'addr', 'poskod', 'city_id', 'state_id'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['post_id', 'isActive'], 'integer'],
            [['city_id', 'state_id', 'date_assign', 'created_at', 'id'], 'safe'],
            [['ICNO', 'created_by'], 'string', 'max' => 12],
            [['title', 'name', 'pa_name'], 'string', 'max' => 150],
            [['addr'], 'string', 'max' => 600],
            [['poskod'], 'string', 'max' => 10],
            [['no_tel_1', 'no_tel_2', 'no_phone', 'no_faks', 'pa_phone'], 'string', 'max' => 15],
            [['email', 'pa_email'], 'string', 'max' => 60],
            [['pa_title_id'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'title' => 'Title',
            'name' => 'Name',
            'addr' => 'Addr',
            'poskod' => 'Poskod',
            'city_id' => 'City ID',
            'state_id' => 'State ID',
            'no_tel_1' => 'No Tel 1',
            'no_tel_2' => 'No Tel 2',
            'no_phone' => 'No Phone',
            'no_faks' => 'No Faks',
            'email' => 'Email',
            'date_assign' => 'Date Assign',
            'pa_title_id' => 'Pa Title ID',
            'pa_name' => 'Pa Name',
            'pa_email' => 'Pa Email',
            'pa_phone' => 'Pa Phone',
            'post_id' => 'Post ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'isActive' => 'Is Active',
        ];
    }

    public function findVip($id) {
        return TblAhliLembagaPengarah::find()->where(['id' => $id])->one();
    }

    public function getKenderaan() {
        return $this->hasMany(\app\models\esticker\TblStickerVip::className(), ['id_lpu' => 'id']);
    } 

}
