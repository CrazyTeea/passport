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
    echo "<pre>";
    foreach ($args as $arg) {
        print_r($arg);
    }
    die();
}

/***
 * @param array $orgs
 *
 * @return Generator
 */
function generatorOrg(array $orgs): Generator
{
    foreach ($orgs as $org)
        yield $org;
}
