<?php

declare(strict_types=1);

namespace Configurator;

use SplFileInfo;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

final class ConfigUtil
{
    /**
     * Ask a question and return the user's input.
     * @param string $question The question to present
     * @param string|int $default The default answer if none is provided
     * @return string The user's answer or the default
     */
    public static function ask(string $question, string|int $default = ''): string
    {
        $answer = readline($question . ($default ? " [{$default}]" : '') . ': ');

        if ($answer === false || trim($answer) === '') {
            return (string) $default;
        }

        return $answer;
    }

    /**
     * Present a choice question to the user and return the selected option.
     * @param string $question The question to present
     * @param array<string|int, string> $options The available options as key => label
     * @param string|int $default The default option key
     * @return string The selected option label
     */
    public static function choice(string $question, array $options, string|int $default = ''): string
    {
        self::writeln($question);
        foreach ($options as $key => $option) {
            self::writeln("  [{$key}] " . $option);
        }
        $answer = self::ask('Select option', $default);
        $result = $options[$answer] ?? ($options[$default] ?? reset($options));
        return is_string($result) ? $result : '';
    }

    /**
     * Ask a yes/no confirmation question.
     * @param string $question The question to present
     * @param bool $default The default answer if none is provided
     * @return bool True for 'yes', false for 'no'
     */
    public static function confirm(string $question, bool $default = false): bool
    {
        $answer = self::ask($question . ' (yes/no)', $default ? 'yes' : 'no');
        return strtolower($answer) === 'yes' || strtolower($answer) === 'y';
    }

    /**
     * Copy a file to a destination, creating the folder if needed.
     * @param string $sourceFile Source file path
     * @param string $destination Destination file path
     * @param string|null $folder Optional folder to create if not exists
     * @return bool True if copy succeeded, false otherwise
     */
    public static function copyFileToDestination(
        string $sourceFile,
        string $destination,
        ?string $folder = null
    ): bool {
        if ($folder !== null) {
            self::createDirectoryIfNotExists($folder);
        }

        return copy($sourceFile, $destination);
    }

    /**
     * Create a directory if it does not already exist.
     * @param string $path The directory path to create
     */
    public static function createDirectoryIfNotExists(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0o755, true);
        }
    }

    /**
     * Delete a file if it exists.
     * @param string $filePath The path to the file
     */
    public static function deleteFileIfExists(string $filePath): void
    {
        if (is_file($filePath)) {
            unlink($filePath);
        }
    }

    /**
     * Recursively delete a folder and its contents.
     * @param string $folderPath Absolute path to the folder
     */
    public static function deleteFolderRecursively(string $folderPath): void
    {
        if (!is_dir($folderPath)) {
            return;
        }

        $iterator = new RecursiveDirectoryIterator($folderPath, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file instanceof SplFileInfo) {
                if ($file->isDir()) {
                    rmdir($file->getPathname());
                    continue;
                }
                unlink($file->getPathname());
            }
        }
        rmdir($folderPath);
    }

    /**
     * Process conditional blocks in a file, including or excluding them based on the conditions array.
     *
     * @param string $file The path to the file to process
     * @param array<string, bool> $conditions An associative array of feature => enabled (bool)
     */
    public static function processConditionalBlocks(string $file, array $conditions): void
    {
        $content = file_get_contents($file);

        foreach ($conditions as $feature => $enabled) {
            $pattern = "/:if_{$feature}(.*?):endif_{$feature}/s";
            if ($enabled) {
                // Keep the block, just remove the markers
                $content = preg_replace_callback($pattern, function ($matches) {
                    return isset($matches[1]) ? trim($matches[1]) : '';
                }, (string) $content);
                continue;
            }
            // Remove the whole block
            $content = preg_replace($pattern, '', (string) $content);
        }
        file_put_contents($file, (string) $content);
    }

    /**
     * Replace multiple strings in a file.
     * @param string $file The path to the file
     * @param array<string, string> $replacements An associative array of search => replace pairs
     */
    public static function replaceInFile(string $file, array $replacements): void
    {
        $contents = file_get_contents($file);
        if ($contents === false) {
            return;
        }
        file_put_contents(
            $file,
            str_replace(
                array_keys($replacements),
                array_values($replacements),
                $contents
            )
        );
    }

    /**
     * Execute a shell command and return the trimmed output.
     * @param string $command The command to execute
     * @return string The trimmed output of the command
     */
    public static function run(string $command): string
    {
        $output = [];
        $exitCode = 0;
        exec($command, $output, $exitCode);
        return trim(implode(PHP_EOL, $output));
    }

    /**
     * Safely delete a file if it exists.
     * @param string $filename The path to the file to delete
     */
    public static function safeUnlink(string $filename): void
    {
        if (file_exists($filename) && is_file($filename)) {
            unlink($filename);
        }
    }

    /**
     * Convert a string to a URL-friendly slug.
     * @param string $subject The input string
     * @param string $separator The separator to use in the slug
     * @return string The slugified string
     */
    public static function slug(string $subject, string $separator = '-'): string
    {
        // Replace all non-alphanumeric characters with the separator
        $slug = preg_replace('/[^\pL\pN]+/u', $separator, $subject);
        // Collapse multiple separators
        $slug = preg_replace('/' . preg_quote($separator, '/') . '+/', $separator, (string) $slug);
        // Trim separators from ends and lowercase
        return strtolower(trim((string) $slug, $separator));
    }

    /**
     * Convert a string to TitleCase.
     * @param string $subject The input string
     * @return string The TitleCased string
     */
    public static function titleCase(string $subject): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $subject)));
    }

    /**
     * Write a line to the console with a newline.
     * @param string $line The line to write
     */
    public static function writeln(string $line): void
    {
        echo $line . PHP_EOL;
    }
}
