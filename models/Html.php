<?php
namespace models;

use modelBase\traits\AddRecord as traitAddRecord;
use modelSpace\Record;

class Html extends JsonSerializable {
    use traitAddRecord;
    public function export()
    {
        return '<table>' . join('', array_map([$this, 'wrap_tr'], $this->records)) . '</table>';
    }

    private function wrap_tr(Record $record) {
        $ret = '<tr>';
        /** @var Record $item */
        foreach (['title', 'company', 'address'] as $item) {
            $ret .= '<td>' . htmlspecialchars($record-> { 'get' . ucfirst($item) }()) . '</td>';
        }
        $ret .= '</tr>';
        return $ret;
    }
}
