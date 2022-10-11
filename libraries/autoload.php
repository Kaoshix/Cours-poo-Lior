<?php

spl_autoload_register(function($className) {
    // Controllers\ArticleController
    $className = str_replace('\\', '/', $className);
    require_once("libraries/$className.php");
});