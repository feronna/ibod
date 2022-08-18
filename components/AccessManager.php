<?php
 
namespace app\components;

use Yii;
use yii\base\Component;
use app\models\system_core\Tblpermission;
use app\models\system_core\Tblrole;
use app\models\system_core\Tblrolepermission;
use app\models\system_core\Tbluserrole;
use app\models\hronline\Tblprcobiodata;


class AccessManager extends Component
{
    //generate the special rules for any controllers that apply this componenet;
    public function Allowed($controller_id){
        
        $action_id = [];
        $action = ['Tidak-ada-access'];
        $rules_ = [];
        $rules = ['actions'=> $action,
                   'allow' => true,
                   'roles' => ['@'],
                   'matchCallback' => function($rule, $action){
                    return true;
                    },
                  ];
        $user_id = Yii::$app->user->getId();
        
        $rl = Tblrole::find()->where(['controller_id'=>$controller_id])->all();
        
       foreach ($rl as $rl){

            if (($usermodel = $this->userRole_id($user_id, $rl->role_id)) !== null) {
                if(($roleperms = $this->rolePerm($usermodel->role_id)) !== null){
                    foreach ($roleperms as $roleperm) {
                        //collect all the action id into an array;
                        array_push($action_id, $roleperm->perm_id);
                    }
                    $flag_all_perm = false;
                    $permissions = $this->permission($action_id);
                    foreach ($permissions as $permission) {
                        //collect all the action name into an array;
                        array_push($action, $permission->perm_desc);
                        if ($permission->perm_desc == '*') {
                            $flag_all_perm = true;
                        }
                    }
                    if (!empty($action)) {
                        $rules = [
                                'actions' => $action,
                                'allow' => true,
                                'roles' => ['@'],
                                'matchCallback' => function ($rule, $action) {
                                    return true;
                                },
                            ];
                        if($flag_all_perm){ // to cut rules if there is '*' action ;
                            array_shift($rules);
                        }
                    }

                }
                
            }
       }
       
       return $rules;
        
    }
    
    public function PermissionList($role_id) {
        $perm_list_id = [];
    
        $role_perms = Tblrolepermission::find()->where(['role_id'=>$role_id])->all();
        foreach ($role_perms as $p) {
            array_push($perm_list_id, $p->perm_id);
        }
        
        return $perms = Tblpermission::find()->where(['IN','perm_id',$perm_list_id])->all();
    }
    
    public function UserList($role_id) {
        $user_role = Tbluserrole::find()->with('userBiodata')->where(['role_id'=>$role_id])->all();
     
        return $user_role;
    }
    
    public function VerifyUser($user_id) {
        // return 1 => user exist and active;
        // return 2 => user exist but not active;
        // return 3 => user not exist;        
        $user = Tblprcobiodata::find()->where(['ICNO'=>$user_id])->one();
        if($user){
            switch ($user->Status) {
                case "6":
                    return 2;
                    break;

                default:
                    return 1;
                    break;
            }
        }
        return 3;
    }
    
    public function userRole($user_id, $controller_id){
        
        $usermodel = Tbluserrole::find()->where(['user_id'=>$user_id])->andWhere(['controller_id'=>$controller_id])->one();
       
        if(!empty($usermodel)){
            return $usermodel;
        }
        return null;
        
    }
    public function userRole_id($user_id, $role_id){
        
        if(($usermodel = Tbluserrole::find()->where(['user_id'=>$user_id])->andWhere(['role_id'=>$role_id])->one()) !== null){
            return $usermodel;
        }
        return null;
        
    }
    
    public function rolePerm($role_id) {
        
        $roleperms = Tblrolepermission::find()->where(['role_id'=>$role_id])->all();
        if(!empty($roleperms)){
            return $roleperms;
        }
        return null;
    }
    
    public function permission($action_id) {
        
        $permissions = Tblpermission::find()->where(['IN','perm_id',$action_id])->all();
        if(!empty($permissions)){
            return $permissions;
        }
        return null;
    }
    
}
