<?php

function dump(...$args): void
{
    foreach ($args as $arg) {
        echo "<pre>";
        print_r($arg);
        echo "</pre>";
    }
}

function dd(...$args): void
{
    foreach ($args as $arg) {
        echo "<pre>";
        print_r($arg);
    }
    die();
}