<?php

/**
 * @param $className
 */
function davaxi_vcalendar_autoload($className)
{
    $classPath = explode('\\', $className);
    if ($classPath[0] != 'Davaxi') {
        return;
    }
    // Drop 'Davaxi', and maximum file path depth in this project is 1
    $classPath = array_slice($classPath, 1, 2);
    $filePath = dirname(__FILE__) . '/' . implode('/', $classPath) . '.php';
    if (file_exists($filePath)) {
        require_once($filePath);
    }
}
spl_autoload_register('davaxi_vcalendar_autoload');