<?php
namespace modelBase\traits;

use modelSpace\Record;

trait AddRecord {
    private $records;
    function addRecord(Record $record) {
        $this->records[] = $record;
    }
}
