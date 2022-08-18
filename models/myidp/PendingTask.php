<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "hrd.idp_pending_task".
 *
 * @property int $task_id
 * @property string $task_submenu
 * @property string $task_menu
 * @property string $assign_for
 */
class PendingTask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_pending_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_submenu', 'task_menu'], 'string', 'max' => 100],
            [['assign_for'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'task_submenu' => 'Task Submenu',
            'task_menu' => 'Task Menu',
            'assign_for' => 'Assign For',
        ];
    }

    public static function calcPendingUrusetia($userID)
    {
        $count = 0;

        $isAdmin = UrusetiaLatihan::find()->where(['userID' => $userID])->one();

        //Nasir jak jadi komen dulu
        // if ($isAdmin && ($isAdmin->ul_type == 'akademik')){

        //     $count = PermohonanKursusLuar::totalPendingd(4);

        // } elseif ($isAdmin && ($isAdmin->ul_type == 'pentadbiran')){

        //     $count = PermohonanKursusLuar::totalPendingd(44);

        // } 

        if ($isAdmin){

            $count = PermohonanKursusLuar::totalPendingd(44) + PermohonanKursusLuar::totalPendingd(4);
        }

        return $count;
    }

    public static function calcPendingPegawai($userID)
    {
        $count = 0;

        $isAdmin = UserAccess::find()->where(['userID' => $userID])->one();
        $isAdmin2 = UrusetiaLatihan::find()->where(['userID' => $userID])->one();

        if (($isAdmin && ($isAdmin->usertype == 'pegawaiLatihan')) 
        || ($isAdmin2 && ($isAdmin2->ul_type == 'ketuaUrusetia'))){

            $count = PermohonanLatihan::totalPendingd($userID,0);

        } elseif ($isAdmin && ($isAdmin->usertype == 'ketuaSektor')){

            $count = PermohonanLatihan::totalPendingd($userID,0);

        } 

        return $count;
    }
}
