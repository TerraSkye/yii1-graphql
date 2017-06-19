<?php


use GraphQL\Type\Definition\EnumType;
use GraphQL\Type\Definition\Type;

class ImageType extends GraphQLType {

  protected $attributes = [
    'name' => 'image',
    'description' => 'a common image type'
  ];

  public function fields() {
    $result = [
      'id' => Type::id(),
      'type' => new EnumType([
        'name' => 'ImageTypeEnum',
        'values' => [
          'USERPIC' => 'userpic'
        ]
      ]),
      'size' => ImageSizeEnumType::class,
      'width' => Type::int(),
      'height' => Type::int(),
      'url' => [
        'type' => Types::url(),
        'resolve' => [$this, 'resolveUrl']
      ],

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

  public function resolveUrl(Image $value, $args, CApplication $context) {
    switch ($value->type) {
      case Image::TYPE_USERPIC:
        $path = "/images/user/{$value->id}-{$value->size}.jpg";
        break;
      default:
        throw new \UnexpectedValueException("Unexpected image type: " . $value->type);
    }
    return $context->getHomeUrl() . $path;
  }
}
