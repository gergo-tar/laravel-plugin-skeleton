<?php

namespace Configurator\Structure;

use Configurator\ConfiguratorGlobals;

final class Composer
{
    public const string FILE_NAME = 'composer.json';
    public const string STUB = Stub::PATH . '/' . self::FILE_NAME . '.stub';
    public const bool IS_COMPOSER_INSTALL_ENABLED = true;

    /**
     * Get the full path to composer.json using the global base path.
     */
    public static function getFilePath(): string
    {
        return rtrim(ConfiguratorGlobals::getBasePath(), '/') . '/' . self::FILE_NAME;
    }

    /**
     * Retrieve the contents of composer.json as an associative array.
     * @return array<string, mixed> The decoded composer.json data
     */
    public static function getComposerJson(): array
    {
        $json = file_get_contents(self::getFilePath());
        if ($json === false) {
            return [];
        }
        $data = json_decode($json, true);
        if (!is_array($data)) {
            return [];
        }
        $filtered = [];
        foreach ($data as $k => $v) {
            if (is_string($k)) {
                $filtered[$k] = $v;
            }
        }
        return $filtered;
    }

    /**
     * Get the corresponding Testbench version for a given Laravel version.
     * @param string $laravelVersion The Laravel version string (e.g. '^10.0', '11.0', '12.0')
     * @return string The corresponding Testbench version string
     */
    public static function getTestbenchVersion(string $laravelVersion): string
    {
        $verNum = preg_replace('/[^0-9]+/', '', $laravelVersion);

        if ($verNum === '10') {
            return '8.*';
        }

        if ($verNum === '11') {
            return '9.*';
        }

        if ($verNum === '12') {
            return '10.*';
        }

        return '8.*';
    }

    /**
     * Remove multiple development dependencies from composer.json.
     *
     * @param array<int, string> $names List of package names to remove
     */
    public static function removeComposerDeps(array $names): void
    {
        $data = self::getComposerJson();
        if (isset($data['require-dev']) && is_array($data['require-dev'])) {
            $devDependencies = array_keys($data['require-dev']);
            if (empty($devDependencies)) {
                return;
            }
            foreach ($devDependencies as $name) {
                if (in_array($name, $names, true)) {
                    unset($data['require-dev'][$name]);
                }
            }
            self::updateComposerJson($data);
        }
    }

    /**
     * Remove a script from composer.json.
     * @param string $scriptName The name of the script to remove
     */
    public static function removeComposerScript(string $scriptName): void
    {
        $data = self::getComposerJson();
        if (isset($data['scripts']) && is_array($data['scripts'])) {
            unset($data['scripts'][$scriptName]);
            self::updateComposerJson($data);
        }
    }

    /**
     * Update the composer.json file with new data.
     * @param array<string, mixed> $data The data to write to composer.json
     */
    public static function updateComposerJson(array $data): void
    {
        $json = json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
        if ($json === false) {
            throw new \RuntimeException('Failed to encode composer.json data to JSON.');
        }
        file_put_contents(self::getFilePath(), $json);
    }
}
