<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->exclude('build')
    ->exclude('demos')
    ->exclude('documentation')
    ->exclude('resources')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
// php-cs-fixer 3.95.x parses PHP syntax only up to 8.5 and refuses to run on 8.6.
// This repository must be style-checked on both 8.5 and 8.6, so allow the unsupported
// runtime explicitly (official Config option; env var PHP_CS_FIXER_IGNORE_ENV=1 is equivalent).
// Remove this once php-cs-fixer supports PHP 8.6.
return $config->setUnsupportedPhpVersionAllowed(true)->setRules([
        '@PHPUnit84Migration:risky'      => true,
        'short_scalar_cast'              => true,
        'switch_case_semicolon_to_colon' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;