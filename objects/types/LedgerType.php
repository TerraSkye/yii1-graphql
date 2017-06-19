<?php


use GraphQL\Type\Definition\Type;

class LedgerType extends GraphQLType {

  protected $attributes = [
    'name' => 'ledger',
    'description' => 'a ledger'
  ];

  public function fields() {
    $result = [
      'id' => Type::id(),
      'name' => Type::string(),
      // Just for the sake of example
      'fieldWithError' => [
        'type' => Type::string(),
        'resolve' => function () {
          throw new \Exception("Field with exception");
        }
      ],
      'nonNullFieldWithError' => [
        'type' => Type::nonNull(Type::string()),
        'resolve' => function () {
          throw new \Exception("Non-null field with exception");
        }
      ]
    ];
    return $result;
  }


}
