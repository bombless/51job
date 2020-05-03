<?php
namespace models;

use modelBase\traits\AddRecord as traitAddRecord;
use modelSpace\Record;

class TclTk extends JsonSerializable {
    use traitAddRecord;

    private function escape_string(string $value) {
        $characters = '\\[]"';
        foreach (str_split($characters) as $c) {
            $value = str_replace($c, '\\' . $c, $value);
        }
        return $value;
    }

    public function export() {
        $ret = '#!/usr/bin/wish' . "\n";

        $ret .= 'frame .frAlles

# create canvas with scrollbars
canvas .frAlles.c -width 800 -height 800 -yscrollcommand ".frAlles.yscroll set"
scrollbar .frAlles.yscroll -command ".frAlles.c yview"
pack .frAlles.yscroll -side right -fill y
pack .frAlles.c -expand yes -fill both -side top

# create frame with widgets
frame .frAlles.c.frWidgets -borderwidth 0 -height ' . (count($this->records) * 22) . ' -width 800';

        $ret .= "\n\n\n";

        /** @var Record $record */
        foreach ($this->records as $idx => $record) {
            foreach (['title', 'company', 'address'] as $item) {
                $methodName = 'get' . ucfirst($item);
                $text = $record->$methodName();
                $text = $this->escape_string($text);
                $ret .= 'label .frAlles.c.frWidgets.l_' . $idx . '_' . $item . ' -text "' . $text . '"' . "\n";
            }
            $ret .= 'grid .frAlles.c.frWidgets.l_' .  $idx . '_title .frAlles.c.frWidgets.l_' . $idx . '_company .frAlles.c.frWidgets.l_' . $idx . '_address' . "\n";

            $ret .= "\n";
        }

        $ret .= "\n\n\n";

        $ret .= '

# place widgets and buttons
.frAlles.c create window 0 0 -anchor nw -window .frAlles.c.frWidgets 

# determine the scrollregion
.frAlles.c configure -scrollregion [.frAlles.c bbox all]

# show the canvas
pack .frAlles -expand yes -fill y -side top';

        $ret .= "\n\n\n";
        return $ret;
    }

}
