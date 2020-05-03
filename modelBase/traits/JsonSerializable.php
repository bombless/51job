<?php
namespace modelBase\traits;


trait JsonSerializable {
    private $records;
    function addRecord(Record $record) {
        $this->records[] = $record;
    }
}
