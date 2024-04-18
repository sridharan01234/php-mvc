<?php
echo "<br>";
$arr = array("apple", "orange", "mango", "banana");
array_splice($arr, 1, 0, array("grapes","jackfruit","watermelon"));
var_dump($arr);

echo "<br>";

global $check;
global $carry;

function checkGrapes($arr) {
    if($arr == "mango") {
        $GLOBALS['check'] = 1;
        $GLOBALS['carry'] = $arr;
        return "strawberry";
    }
    if($GLOBALS['check'] == 1) {
        $temp = $GLOBALS['carry'];
        $GLOBALS['carry'] = $arr;
        return $temp;
    }
    return $arr;
}

$arr = array_map("checkGrapes", $arr);

var_dump($arr);

function recursiveCheck($arr,$check) {
    if($arr == "banana") {
        array_push($check,1);
        return recursiveCheck("grapes",1,$arr);
    }
    if($check) {
        $temp = $GLOBALS['carry'];
        $GLOBALS['carry'] = $arr;
        return $GLOBALS['carry'];
    }
    return $arr;
}

global $checkArr;
$arr = array_map("recursiveCheck", $arr,$check);

?>