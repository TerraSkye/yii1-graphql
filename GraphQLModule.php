<?php

/**
 * Created by PhpStorm.
 * User: sjoerd
 * Date: 7-6-17
 * Time: 11:43
 */
Yii::setPathOfAlias('GraphQL', dirname(__FILE__));
Yii::import('GraphQL.components.*');

class GraphQLModule extends CWebModule {

  use GraphQLModuleTrait;


  public function init() {
    parent::init();
    Yii::setPathOfAlias('GraphQL', dirname(__FILE__));

    Yii::import('GraphQL.error.*');
    Yii::import('GraphQL.exceptions.*');
    Yii::import('GraphQL.types.*');

    Yii::import('GraphQL.objects.types.*');
    Yii::import('GraphQL.objects.types.ImageType');
    Yii::import('GraphQL.objects.queries.*');
    Yii::import('GraphQL.objects.mutations.*');

    Yii::app()->setComponents(array(
      'errorHandler' => array(
        'class' => 'CErrorHandler',
        'errorAction' => $this->getId() . '/default/error',
      ),
      'user' => array(
        'class' => 'CWebUser',
        'stateKeyPrefix' => 'api',
        'loginUrl' => Yii::app()->createUrl($this->getId() . '/default/login'),
      ),
    ), FALSE);


    $beginTime = microtime(TRUE);


    $this->schema['query'] = Cmap::mergeArray($this->schema['query'], $this->discover(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'objects' . DIRECTORY_SEPARATOR . 'queries', 'Query'));
    $this->schema['mutation'] = Cmap::mergeArray($this->schema['mutation'], $this->discover(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'objects' . DIRECTORY_SEPARATOR . 'mutations', 'Mutation'));





    $duringTime = microtime(TRUE) - $beginTime;
    Yii::trace("discoverd schema during : {$duringTime} second", 'graphql');


  }


  /**
   * Performs access check to gii.
   * This method will check to see if user IP and password are correct if they attempt
   * to access actions other than "default/login" and "default/error".
   * @param CController $controller the controller to be accessed.
   * @param CAction $action the action to be accessed.
   * @throws CHttpException if access denied
   * @return boolean whether the action should be executed.
   */
  public function beforeControllerAction($controller, $action) {
    if (parent::beforeControllerAction($controller, $action)) {
      return TRUE;
    }
    return FALSE;
  }


  private function discover($dir, $suffix) {
    $components = [];
    if (Yii::app()->getComponent('cache') && (Yii::app()->getCache()
        ->get(base64_encode(serialize(func_get_args())))) === FALSE
    ) {
      $Directory = new RecursiveDirectoryIterator($dir);
      $Iterator = new RecursiveIteratorIterator($Directory);
      $types = new RegexIterator($Iterator, "/^.+$suffix\.php$/i", RecursiveRegexIterator::GET_MATCH);

      foreach ($types as $name => $object) {
        $class = substr($name, strrpos($name, '/') + 1, -4);
        Yii::import('name');
        $components[lcfirst(substr($class, 0, -strlen($suffix)))] = $class;
      }
    }
    return $components;
  }

}