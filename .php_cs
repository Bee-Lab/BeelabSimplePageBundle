<?php
// see https://github.com/FriendsOfPHP/PHP-CS-Fixer

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__.'/Controller', __DIR__.'/DependencyInjection', __DIR__.'/Entity', __DIR__.'/Tests', __DIR__.'/Validator'])
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true,
    ])
    ->setFinder($finder)
;
