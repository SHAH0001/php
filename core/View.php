<?php

namespace Core;

class View
{
    public static function render($template, array $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/views/$template" . '.php';

        if (is_readable($file)) {
            require_once $file;
        } else {
            throw new \Exception("View $template not found.");
        }
    }
}