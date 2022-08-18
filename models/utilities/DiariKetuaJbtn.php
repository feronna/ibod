<?php

namespace app\models\utilities;

use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use Yii;
use yii\data\ActiveDataProvider;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "utilities.diari_ketua_jbtn".
 *
 * @property int $id
 * @property string $staf_icno
 * @property string $icno
 * @property string $title
 * @property string $detail
 * @property string $create_dt
 * @property string $update_dt
 */
class DiariKetuaJbtn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.diari_ketua_jbtn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail'], 'string'],
            [['due_date', 'create_dt', 'update_dt', 'staf_icno'], 'safe'],
            [['staf_icno', 'icno'], 'string', 'max' => 16],
            [['status', 'notification', 'fav', 'type'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            'due_date' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['due_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['due_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime(str_replace("/", "-", $this->due_date)));
                },
            ],
        ];
    }


    public function afterFind()
    {

        $this->due_date = Yii::$app->formatter->asDate($this->due_date, 'dd/MM/yyyy');

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staf_icno' => 'Kakitangan / Assignee',
            'type' => 'Jenis / Type',
            'icno' => 'Icno',
            'title' => 'Tajuk / Title',
            'detail' => 'Perincian / Detail',
            'create_dt' => 'Dibuat Pada',
            'createDtFormat' => 'Dibuat Pada',
            'update_dt' => 'Dikemaskini Pada',
            'status' => 'Status ?',
            'statusText' => 'Status ?',
            'due_date' => 'Due date',
            'notification' => 'Notification ?',
            'fav' => 'Favourite',
            'favIcon' => 'Fav',
            'typeText' => 'Type',
        ];
    }

    public function getStaffBio()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'staf_icno']);
    }

    public function getCreateDtFormat()
    {
        $formatter = \Yii::$app->formatter;
        return $formatter->asDate($this->create_dt, 'long');
    }



    public function getTypeText()
    {
        return $this->arrType($this->type);
    }

    public function getStatusText()
    {
        return $this->status == 1 ? '<span class="label label-success">Completed</span>' : '<span class="label label-warning">In-progress</span>';
    }

    public function getFavIcon()
    {
        return $this->fav == 1 ? '<i class="fa fa-heart"></i>' : '<i class="fa fa-heart-o"></i>';
    }

    public function search($params, $icno = null)
    {
        $query = DiariKetuaJbtn::find();
        $query->joinWith(['staffBio']);
        $query->limit(100);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'diari_ketua_jbtn.icno' => $icno,
            'diari_ketua_jbtn.staf_icno' => $this->staf_icno,
            // 'create_dt' => $this->create_dt,
        ]);

        $query->andFilterWhere(['like', 'diari_ketua_jbtn.title', $this->title])
            ->andFilterWhere(['=', 'diari_ketua_jbtn.status', $this->status])
            ->andFilterWhere(['like', 'tblprcobiodata.CONm', $this->staf_icno]);

        $query->orderBy(['create_dt' => SORT_DESC]);

        return $dataProvider;
    }

    public static function isKj($userid)
    {

        $model = Department::findOne(['chief' => $userid, 'isActive' => 1]);

        if ($model) {
            return true;
        }

        if ($userid == '890426495037') {
            return true;
        }

        if ($userid == '840813125655') {
            return true;
        }

        return false;
    }

    public function arrType($id = null)
    {
        $arr = [
            1 => 'Tasks',
            2 => 'Issue',
            3 => 'Insiden',
        ];

        if ($id) {

            return $arr[$id];
        }

        return $arr;
    }

    public static function totalByStatus($icno)
    {

        $overdue = self::find()->where(['icno' => $icno, 'status' => 0, ])->andWhere(['<','due_date',date('Y-m-d')])->count();
        $completed = self::find()->where(['icno' => $icno, 'status' => 1])->count();
        $inProgress = self::find()->where(['icno' => $icno, 'status' => 0])->count();
        $fav = self::find()->where(['icno' => $icno, 'fav' => 1])->count();

        $arr = [
            'overdue' => $overdue,
            'completed' => $completed,
            'inProgress' => $inProgress,
            'fav' => $fav,
        ];


        return $arr;
    }
}
