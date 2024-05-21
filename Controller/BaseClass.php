<?php
final class BaseClass {

    final public const var = "Bar";
    public const check = "Fooo";

    public function __construct() {
        echo "check";
    }

    final public function toCheck() {
        echo "Foo";
    }
}
?>