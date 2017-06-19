<?php

/**
 * Created by PhpStorm.
 * User: sjoerd
 * Date: 14-6-17
 * Time: 13:49
 */

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;


class ImageQuery extends GraphQLQuery{



  protected $attributes = [
    'name'=>'images',
    'description'=>'Returns subset of images available',
  ];


  public function type()
  {
    return Type::listOf(GraphQL::type(ImageType::class));
  }



  public function args()
  {
    return [
      'after'=>[
        'type'=>Type::id(),
        'description'=>'Fetch images listed after the image with this ID'
      ],
      'limit' => [
        'type' => Type::int(),
        'description' => 'Number of images to be returned',
        'defaultValue' => 10
      ]
    ];
  }


  protected function resolve($value, $args, $context, ResolveInfo $info)
  {
    $args += ['after' => null];
    return [];// images.
  }




}