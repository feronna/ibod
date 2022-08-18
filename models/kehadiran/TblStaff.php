<?php

namespace app\models\kehadiran;

use Yii;
use app\models\hronline\Tblprcobiodata;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "attendance.tbl_staffs".
 *
 * @property int $id
 * @property string $staff_icno staf seliaan utk syif
 * @property string $sup_icno icno penyelia kehadiran
 * @property string $created_at
 */
class Tblstaff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance.tbl_staffs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['staff_icno', 'sup_icno', 'created_at'], ''],
            ['staff_icno', 'unique'],
            [['created_at'], 'safe'],
            [['staff_icno', 'sup_icno'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_icno' => 'Staff Name',
            'sup_icno' => 'Supervisor Name',
            'created_at' => 'Added Datetime',
            'staff.CONm' => 'Staff',
            'supervisor.CONm' => 'Supervisor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'staff_icno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisor()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'sup_icno']);
    }

    public function search($params)
    {

        $query = Tblstaff::find();
        $query->joinWith(['supervisor a', 'staff b']);
        $query->limit(100);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'a.CONm', $this->sup_icno])
            ->andFilterWhere(['like', 'b.CONm', $this->staff_icno]);


        return $dataProvider;
    }
}
