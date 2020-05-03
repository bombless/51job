<?php
namespace models;

use modelBase\traits\AddRecord as traitAddRecord;

class JsonSerializable implements \JsonSerializable {
    use traitAddRecord;

    public function jsonSerialize() {
        return $this->records;
    }
}
