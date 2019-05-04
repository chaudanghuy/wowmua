<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'Bootstrap' => $baseDir . '/vendor/holt59/cakephp3-bootstrap-helpers/',
        'Cakeminify' => $baseDir . '/vendor/visonforcoding/cakeminify/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Mailgun' => $baseDir . '/vendor/narendravaghela/cakephp-mailgun/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Utils' => $baseDir . '/vendor/cakemanager/cakephp-utils/',
        'WyriHaximus/MinifyHtml' => $baseDir . '/vendor/wyrihaximus/minify-html/',
        'WyriHaximus/TwigView' => $baseDir . '/vendor/wyrihaximus/twig-view/'
    ]
];