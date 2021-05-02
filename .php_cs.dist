<?php

$finder = PhpCsFixer\Finder::create()
    ->notPath('bootstrap/cache')
    ->notPath('storage')
    ->notPath('vendor')
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'phpdoc_var_without_name' => false,
        'declare_strict_types' => false,
        'phpdoc_line_span' => ['property' => 'single'],
        'blank_line_after_namespace' => true,
        'visibility_required' => true,
        'encoding' => true,
        'full_opening_tag' => true,
        'braces' => true,
        'line_ending' => true,
    ])->setFinder($finder);
