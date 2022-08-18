<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.tbl_lantikan_belum_selesai".
 *
 * @property int $id
 * @property string $ICNO no ic staff yg dilantik
 * @property string $Staff_Id UMSPER staff yg dilantik
 * @property string $Admin_ICNO admin yg melantik
 */
class Tbllantikanbelumselesai extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    } 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tbl_lantikan_belum_selesai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'Staff_Id', 'Admin_ICNO'], 'required'],
            [['ICNO', 'Admin_ICNO'], 'string', 'max' => 12],
            [['Staff_Id'], 'string', 'max' => 15],
            [['lantikan','profil_gaji','lpg'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'Staff_Id' => 'Staff ID',
            'Admin_ICNO' => 'Admin Icno',
        ];
    }

}
