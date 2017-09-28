<?php

namespace Eder\JsonLd;

use JsonSerializable;

class JsonLdSerialize implements JsonSerializable {

	public function __construct(array $array) {
        $this->array = $array;
    }

    public function jsonSerialize() {
        return $this->array;
    }

}