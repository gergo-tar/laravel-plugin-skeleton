<?php

namespace Configurator\Structure;

final class Docs
{
    public const string FOLDER = 'docs';

    public const string CHANGELOG_FILE_NAME = 'CHANGELOG.md';
    public const string LICENSE_FILE_NAME = 'LICENSE.md';
    public const string README_FILE_NAME = 'README.md';

    public const string CHANGELOG_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::CHANGELOG_FILE_NAME . '.stub';

    public const string LICENSE_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::LICENSE_FILE_NAME . '.stub';

    public const string README_STUB = Stub::PATH
        . '/' . self::FOLDER
        . '/' . self::README_FILE_NAME . '.stub';
}
