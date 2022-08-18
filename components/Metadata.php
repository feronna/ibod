<?php

namespace app\components;
/**
 * Metadata Helps to get metadata about models,controllers and actions in application*
 *
 * For using you need:
 * 1. Place this file to directory with components of your application (your_app_dir/protected/components)
 * 2. Add it to 'components' in your application config (your_app_dir/protected/config/main.php)
 * 'components'=>array(
 *   'metadata'=>array('class'=>'Metadata'),
 *    ...
 *  ),
 * 3. Use:
 *   $user_actions = Yii::app()->metadata->getActions('UserController');
 *   var_dump($user_actions);
 *
 * @author Vitaliy Stepanenko <mail@vitaliy.in>
 * @version 0.2
 * @license BSD
 * @link http://www.yiiframework.com/extension/metadata/
 */
use Yii;
use yii\base\Component;
//use yii\base\InvalidConfigException;

class Metadata extends Component
{

    /**
     * Get all information about application
     * if modules of your application have controllers with same name, it will raise fatall error
     *
     */
    public function getAll()
    {

        $meta = array(
            'models' => $this->getModels(),
            'controllers' => $this->getControllers(),
            'modules' => $this->getModules(),
        );
        foreach ($meta['controllers'] as &$controller) {
            $controller = array(
                'name' => $controller,
                'actions' => $this->getActions($controller)
            );
        }

        foreach ($meta['modules'] as &$module) {

            $controllers = $this->getControllers($module);

            foreach ($controllers as &$controller) {
                $controller = array(
                    'name' => $controller,
                    'actions' => $this->getActions($controller, $module)
                );
            }


            $module = array(
                'name' => $module,
                'controllers' => $controllers,
                'models' => $this->getModels($module),
            );

        }

        return $meta;

    }

    /**
     * Get actions of controller
     *
     * @param mixed $controller
     * @param mixed $module
     * @return mixed
     */
    public function getActions($controller, $module = null)
    {
        if ($module != null) {
            $path = join(DIRECTORY_SEPARATOR, array(Yii::app()->getModule($module)->basePath, 'controllers'));
            $this->setModuleIncludePaths($module);
        }
        else {
            $path = Yii::getAlias('@app/controllers');
        }

        $actions = array();
        $file = fopen($path . DIRECTORY_SEPARATOR . $controller . '.php', 'r');
        $lineNumber = 0;
        while (feof($file) === false) {
            ++$lineNumber;
            $line = fgets($file);
            preg_match('/public[ \t]+function[ \t]+action([A-Z]{1}[a-zA-Z0-9]+)[ \t]*\(/', $line, $matches);
            if ($matches !== array()) {
                $name = $matches[1];
                $actions[] = $matches[1];
            }
        }

        return $actions;

    }

    /**
     * Set php include paths for module
     *
     * @param mixed $module
     */
    private function setModuleIncludePaths($module)
    {
        set_include_path(join(PATH_SEPARATOR, array(
                                                   get_include_path(),
                                                   //join(DIRECTORY_SEPARATOR,array(Yii::app()->modulePath,$module,'controllers')),
                                                   join(DIRECTORY_SEPARATOR, array(Yii::app()->modulePath, $module,
                                                                                   'components')),
                                                   join(DIRECTORY_SEPARATOR, array(Yii::app()->modulePath, $module,
                                                                                   'models')),
                                                   join(DIRECTORY_SEPARATOR, array(Yii::app()->modulePath, $module,
                                                                                   'vendors')),
                                              )));
    }

    /**
     * Get list of controllers with actions
     *
     * @param mixed $module
     * @return array
     */
    function getControllersActions($module = null)
    {
        $ind = 0;
        $c = $this->getControllers($module);
        foreach ($c as $index => $controller) {
//            $controller = array(
//                'name' => $controller,
//                'actions' => $this->getActions($controller, $module)
//            );
            $actions = $this->getActions($controller, $module);
            foreach($actions as $ac) {
                $controller = str_ireplace('Controller', '', $controller);
                $controller = preg_replace('/\B([A-Z])/', '-$1', $controller);
                $ac = preg_replace('/\B([A-Z])/', '-$1', $ac);
                $ctrls[$ind] = strtolower($controller.'/'.$ac);
                $ind += 1;
            }
            $ind += 1;
            //$ctrls[$index] = $actions;
        }
        return $ctrls;
    }

    /**
     * Scans controller directory & return array of MVC controllers
     *
     * @param mixed $module
     * @param mixed $include_classes
     * @return array
     */
    public function getControllers($module = null)
    {

        if ($module != null) {
            $path = join(DIRECTORY_SEPARATOR, array(Yii::$app->getModule($module)->basePath, 'controllers'));
        }
        else {
            $path = Yii::getAlias('@app/controllers');
        }
        $controllers = array_filter(scandir($path), array($this, 'isController'));
        foreach ($controllers as $field => $c) {
            $c = str_ireplace('.php', '', $c);
            $ctrls[$field] = $c; 
        }
        //return $controllers;
        return $ctrls;
    }
    
    public function getControllerLists(){   
//  return controller list in an array with index of its controller name
//  example:*******
//        array[
//            ['Biodata']=>'BiodataController',
//        ]
        
        $path = Yii::getAlias('@app/controllers');
        $ctrls = [];
        $controllers = array_filter(scandir($path), array($this, 'isController'));
        foreach ($controllers as $field => $c) {
            $index = '';
            $c = str_ireplace('.php', '', $c);
            $index_to_be = substr($c, 0, strpos($c, "Controller"));
            $i_t_b = preg_split('/(?=[A-Z])/',lcfirst($index_to_be));
            for($i = 1; $i < count($i_t_b); $i++ ){
                $i_t_b[$i] ='-'.lcfirst($i_t_b[$i]);
            }
            for($i = 0; $i < count($i_t_b); $i++ ){
                $index = $index.$i_t_b[$i];
                
            }
            $ctrls[$index] = $c;
        }
        
        return $ctrls;
    }
    
    
    
    public function getAction($controller) {
        
        $path = Yii::getAlias('@app/controllers');

        $actions = [];
        $file = fopen($path . DIRECTORY_SEPARATOR . $controller . '.php', 'r');
        $lineNumber = 0;
        while (feof($file) === false) {
            $index= '';
            ++$lineNumber;
            $line = fgets($file);
            preg_match('/public[ \t]+function[ \t]+action([A-Z]{1}[a-zA-Z0-9-_]+)[ \t]*\(/', $line, $matches);
            if ($matches !== array()) {
             
                $i_t_b = preg_split('/(?=[A-Z])/',lcfirst($matches[1]));
                for($i = 1; $i < count($i_t_b); $i++ ){
                    $i_t_b[$i] ='-'.lcfirst($i_t_b[$i]);
                }
                for($i = 0; $i < count($i_t_b); $i++ ){
                    $index = $index.$i_t_b[$i];
                }
                $actions[] = $index;
            }

        }
        return $actions;
    }
    
    public function getActionList() {
        $action = [];
        $action_array = [];
        $controllers_list = Yii::$app->metadata->getControllerLists();
     
        foreach ($controllers_list as $c) {
            $action = [];
            $actions_list = Yii::$app->metadata->getAction($c);
            foreach ($actions_list as $a) {
                $action[$a] = $a;
            }
           
            $action_array[$c] = $action;
        }
        
        return $action_array;
        
    }

    /**
     * Scans models directory & return array of MVC models
     *
     * @param mixed $module
     * @param mixed $include_classes
     * @return array
     */
    public function getModels($module = null, $include_classes = false)
    {

        if ($module != null) {
            $path = join(DIRECTORY_SEPARATOR, array(Yii::app()->getModule($module)->basePath, 'models'));
        }
        else {
            $path = Yii::getPathOfAlias('application.models');
        }

        $models = array();
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $f) {
                if (stripos($f, '.php') !== false) {
                    $models[] = str_ireplace('.php', '', $f);
                    if ($include_classes) {
                        include_once($path . DIRECTORY_SEPARATOR . $f);
                    }

                }
            }
        }
        return $models;

    }

    /**
     * Used in getModules() to filter array of files & directories
     *
     * @param mixed $a
     */
    private function isController($a)
    {
        return stripos($a, 'Controller.php') !== false;
    }


    /**
     * Returns array of module names
     *
     */
    public function getModules()
    {
        return array_keys(Yii::app()->modules);
    }

    /**
     * Used in getModules() to filter array of files & directories
     *
     * @param mixed $a
     */
    private function isModule($a)
    {
        return $a != '.' and $a != '..' and is_dir(Yii::app()->modulePath . DIRECTORY_SEPARATOR . $a);
    }

}
