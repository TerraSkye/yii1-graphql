<?php

/**
 * Created by PhpStorm.
 * User: sjoerd
 * Date: 14-6-17
 * Time: 13:49
 */

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;


class LedgersQuery extends GraphQLQuery {


  protected $attributes = [
    'name' => 'ledgers',
    'description' => 'Returns subset of ledgers available',
  ];


  public function type() {
    return Type::listOf(GraphQL::type(LedgerType::class));
  }


  public function args() {
    return [
      'after' => [
        'type' => Type::id(),
        'description' => 'Fetch images listed after the ledger with this ID'
      ],
      'limit' => [
        'type' => Type::int(),
        'description' => 'Number of ledger to be returned',
        'defaultValue' => 10
      ]
    ];
  }


  protected function resolve($value, $args, $context, ResolveInfo $info) {
    $args += ['after' => NULL];
    return [
      [
        'id' => 20,
        'name' => "walalala"
      ],
      [
        'id' => 21,
        'name' => 'whohohoh'
      ]
    ];// images.
  }


}