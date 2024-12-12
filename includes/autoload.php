<?php

spl_autoload_register(function ($class) {
    // Convert the namespace to a directory structure
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // Split the class path into its parts
    $classParts = explode(DIRECTORY_SEPARATOR, $classPath);

    // Convert all parts to lowercase except the last one (class name)
    for ($i = 0; $i < count($classParts) - 1; $i++) {
        $classParts[$i] = strtolower($classParts[$i]);
    }

    // Rebuild the class path with the correct casing
    $classPath = implode(DIRECTORY_SEPARATOR, $classParts);

    // Full path to the class file
    $fullPath = __DIR__ . '/../' . $classPath . '.php';

    // Check if the file exists and require it
    if (file_exists($fullPath)) {
        require_once $fullPath;
        return;
    }
});
