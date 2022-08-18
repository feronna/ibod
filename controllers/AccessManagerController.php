<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\system_core\Tblpermission;
use app\models\system_core\Tblrole;
use app\models\system_core\Tblrolepermission;
use app\models\system_core\Tbluserrole;


use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class AccessManagerController extends Controller
{
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                    [
                        'actions' => ['index','create-role','update-role','view-role','role-details','create-perm','view-perm','view-roleperm',
                        'assign-perm','unassign-perm','assign-user','unassign-user','delete-role','delete-perm',],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function($rules, $action){
                            if(Yii::$app->user->getId() == '940402125181'){
                                return true;
                            }
                            return false;
                        }
                        
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionCreateRole() {
        
        $role = new Tblrole();
        
        $controllers_list = Yii::$app->metadata->getControllerLists();
        
        if($role->load(Yii::$app->request->post())){
            //$role->controller_id = substr($role->controller_id, 0, strpos($role->controller_id, "Controller"));
            if($role->save()){
                return $this->redirect(['view-role']);
            }
        }
        return $this->render('createrole',[
            'role' => $role,
            'controllers' => $controllers_list,
        ]);
        
        
    }
    
    public function actionUpdateRole($id) {
        $role = $this->findRole($id);
        
        if($role->load(Yii::$app->request->post())){
            if($role->save()){
                
                return $this->redirect(['view-role']);
            }
        }
        
        return $this->render('updaterole',[
            'role' => $role,
        ]);
    }
    
    public function actionViewRole() {
        $role = Tblrole::find()->all();
        
        return $this->render('viewrole',[
            'role' => $role,
        ]);
    }
    
    public function actionRoleDetails($id) {
        
        $role = $this->findRole($id);
        $perm = Yii::$app->AccessManager->PermissionList($id);
        $user = Yii::$app->AccessManager->UserList($id);
        return $this->render('roledetails',[
            'role'=>$role,
            'perm'=>$perm,
            'user'=>$user,
        ]);
    }
    
    public function actionCreatePerm() {
        
        $perm = new Tblpermission();
        $actions_list = Yii::$app->metadata->getActionList();
        
        if($perm->load(Yii::$app->request->post())){
            if($perm->save()){
                return $this->redirect(['view-perm']);
            }
        }
        
        return $this->render('createpermission',[
            'perm' => $perm,
            'actions' => $actions_list,
            
        ]);
        
    }
    
    public function actionViewPerm() {
        $perm = Tblpermission::find()->all();
        
        return $this->render('viewperm',[
            'perm' => $perm,
        ]);
    }
    
    public function actionViewRoleperm() {
        $roleperm = Tblrolepermission::find()->all();
        
        return $this->render('viewroleperm',[
            'roleperm' => $roleperm,
        ]);
    }
    
    public function actionAssignPerm($role_id) {
        $role = [];
        $perm = [];
        $roleperm = new Tblrolepermission();
        $role_list = Tblrole::find()->where(['role_id'=>$role_id])->one();
        $role[$role_list->role_id] = $role_list->role_name;
        $perm_list = Tblpermission::find()->all();
        foreach ($perm_list as $p) {
            $perm[$p->perm_id] = $p->perm_desc;
        }
        $roleperm->role_id = $role_id;
        
        if($roleperm->load(Yii::$app->request->post())){
            if($roleperm->save()){
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Permission berjaya dipasang.']);
                return $this->redirect(['role-details','id'=>$roleperm->role_id]);
            }
        }
        return $this->render('assignroleperm',[
            'roleperm'=>$roleperm,
            'role'=>$role,
            'perm'=>$perm,
        ]);
        
    }
    
    public function actionUnassignPerm($perm_id, $role_id) {
        $roleperm = Tblrolepermission::find()->where(['role_id'=>$role_id])->andWhere(['perm_id'=>$perm_id])->one();
        if($roleperm){
            if($roleperm->delete()){
               Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Permission berjaya dibuang.']); 
            }
        }
        return $this->redirect(['role-details', 'id'=>$role_id]);
    }
    
    public function actionAssignUser($role_id) {
        $role = $this->findRole($role_id);
        $userrole = new Tbluserrole();
        $userrole->role_id = $role_id;
        $userrole->controller_id = $role->controller_id;
        
        if($userrole->load(Yii::$app->request->post())){
            $userrole->user_id = \trim($userrole->user_id);
            $userstatus = Yii::$app->AccessManager->VerifyUser($userrole->user_id);
            switch ($userstatus) {
                case "1":
                    if($userrole->save()){
                        Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah.']);
                        return $this->redirect(['role-details','id'=>$role_id]);
                    }

                    break;
                case "2":
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No K/P wujud tetapi tidak aktif.']); 

                    break;
                case "3":
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No K/P tidak wujud dalam database.']);

                    break;
            }
        }
        
        return $this->render('assignuser',[
            'user'=>$userrole,
            'role'=>$role,
        ]);
        
    }
    
    public function actionUnassignUser($user_id, $role_id) {
        $userrole = Tbluserrole::find()->where(['user_id'=>$user_id])->andWhere(['role_id'=>$role_id])->one();
        if($userrole){
            if($userrole->delete()){
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Pengguna berjaya dibuang.']); 
            }
        }
        return $this->redirect(['role-details', 'id'=>$role_id]);
    }


    public function actionDeleteRole($id) {
        $perm_exist = Tblrolepermission::find()->where(['role_id'=>$id])->all();
        $user_exist = Tbluserrole::find()->where(['role_id'=>$id])->all();
        
        if($perm_exist || $user_exist){
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak boleh padam', 'type' => 'error', 'msg' => 'Role ini digunakan.']);
        }else{
           $role = $this->findRole($id);
        
            if($role->delete()){
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Role berjaya dipadam.']);
            } 
        }
        
        
        return $this->redirect(['view-role']);
    }
    
    public function actionDeletePerm($id) {
        
        $exist = Tblrolepermission::find()->where(['perm_id'=>$id])->all();
        if($exist){
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak boleh padam', 'type' => 'error', 'msg' => 'Permission ini digunakan.']);
        }else{
            $perm = $this->findPerm($id);
            $perm->delete();
        }
        
        return $this->redirect(['view-perm']);
    }
    
    protected function findRole($id) {
        if (($model = Tblrole::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findPerm($id) {
        if (($model = Tblpermission::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
