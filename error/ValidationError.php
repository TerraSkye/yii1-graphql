<?php

namespace yii\graphql\error;

use GraphQL\Error\Error;

class ValidationError extends Error {
  public $validator;

  public function getValidator() {
    return $this->validator;
  }

  public function setValidator($validator) {
    $this->validator = $validator;

    return $this;
  }

  public function getValidatorMessages() {
    return $this->validator ? $this->validator->messages() : [];
  }
}
