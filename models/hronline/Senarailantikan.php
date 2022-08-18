<?php

namespace app\models\hronline;

use Yii;

// This is the model class for table "hronline.senarailantikan.

class Senarailantikan extends \yii\db\ActiveRecord
{   
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.senarailantikan';
    }

    public $dept_id;

    public function rules()
    {
        return [
            [['id', 'isActive'], 'integer'],
            [['lantikanNm', 'Dept_Id'], 'required', 'message'=>'Ruang ini adalah mandatori.'],
            [['lantikanNm'], 'string', 'max' => 100],
            [['Dept_Id'], 'string', 'max'=>255],
            [['dept_id'],'string',],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lantikanNm' => 'Lantikan Nm',
            'Dept_Id' => 'Dept ID',
            'isActive' => 'Is Active',
        ];
    }

    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'Dept_Id']);
    }
    
    public function showOnlyLantikan($loginDept){
        $senarailantikan = Senarailantikan::find()->all();
        $departmentlist = [];
        $idlist = [];
        foreach ($senarailantikan as $senarailantikans) {
            $departmentlist = explode(",", $senarailantikans->Dept_Id);
            for ($i=0; $i < count($departmentlist); $i++) { 
                if ($loginDept == $departmentlist[$i]) {
                    array_push($idlist, $senarailantikans->id);
                }
            
            }
        }

        return $idlist;
    }

    public function getJabatan(){
        if($this->department){
            return $this->department->fullname;
        }
        return '-';
    }

    public function getStatus() {
        return $this->isActive ? "Aktif" : "Tidak Aktif";
    }
}
