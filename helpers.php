<?php

function dump(...$args): void
{
    echo '<pre>';
    foreach ($args as $arg) {
        var_dump($arg);
    }
    echo '</pre>\n';
}

function dd(...$args): void
{
    echo "<pre>";
    foreach ($args as $arg) {
        print_r($arg);
    }
    echo "</pre>\n";
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
