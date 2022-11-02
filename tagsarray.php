<?php
    $tagsarray = array(1, 3, 6, 9, 1, 5, 0, 1, 9, 1);
    
    function populartag($tagsarray) {
        $values = array();
        foreach ($tagsarray as $v) {
            if (isset($values[$v])) {
                $values[$v] ++;
            } else {
                $values[$v] = 1;
            }
        } 
        arsort($values);
        $modes = array();
        $x = $values[key($values)];
        reset($values); 
        foreach ($values as $key => $v) {
            if ($v == $x) {
                $modes[] = $key;
            } else {
                break;
            }
        } 
        return $modes;
    }

    print_r(populartag($tagsarray));
?>