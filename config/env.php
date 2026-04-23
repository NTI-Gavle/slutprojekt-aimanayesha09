<?php
/**
 * Load environment variables from a .env file.
 *
 * @param string $file Path to the .env file
 * @return array<string, string>
 */
function loadEnv(string $file): array
{
    $env = [];

    if (!file_exists($file)) {
        return $env;
    }

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '' || strpos($line, '#') === 0 || strpos($line, '=') === false) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }

    return $env;
}
