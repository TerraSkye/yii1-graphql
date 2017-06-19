<?php
use yii\graphql\error\ValidationError;

/**
 * Created by PhpStorm.
 * User: sjoerd
 * Date: 7-6-17
 * Time: 11:44
 */
class DefaultController extends CController {


  public function actions(){
    return [
      'index' => [
         'class' => GraphQLAction::class
      ]
    ];
  }



//  public function actionIndex() {
//
//    var_dump($this);exit;
//  }


  public function actionError() {
    /**
     * @var $error \CErrorHandler
     */
    $error = Yii::app()->getErrorHandler();


    if ($error->getException() instanceof \GraphQL\Error\Error) {
      /**
       * @var $e \GraphQL\Error\Error;
       */
      $e = $error->getException();
      $error = [
        'message' => $e->getMessage()
      ];
      $locations = $e->getLocations();
      if (!empty($locations)) {
        $error['locations'] = array_map(function ($loc) {
          return $loc->toArray();
        }, $locations);
      }

      $previous = $e->getPrevious();
      if ($previous && $previous instanceof ValidationError) {
        $error['validation'] = $previous->getValidatorMessages();
      }
      header('Content-Type: application/json');
      echo json_encode($error);
      Yii::app()->end();
    }

    CVarDumper::dump($error->getError());

    echo "error";

  }
}