<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
    ]);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'binary_operator_spaces' => [
            'default' => 'single_space',
            'operators' => [
                '=' => 'align_single_space_minimal',
                '=>' => 'align_single_space_minimal',
            ],
        ],
    ])
    ->setFinder($finder);
