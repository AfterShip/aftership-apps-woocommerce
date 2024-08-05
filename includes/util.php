<?php

function safeArrayGet($array, $key, $default = null) {
    return isset($array[$key]) ? $array[$key] : $default;
}
