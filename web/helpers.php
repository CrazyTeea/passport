<?php

function dump(...$args): void
{
    foreach ($args as $arg) {
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function dd(...$args): void
{
    foreach ($args as $arg) {
        echo "<pre>";
        var_dump($arg);
    }
    die();
}