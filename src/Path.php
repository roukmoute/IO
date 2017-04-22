<?php

namespace Roukmoute\IO;

use DusanKasan\Knapsack\Collection;

/**
 * Provides methods for processing directory strings.
 * The methods will handle most string operations.
 */
class Path
{
    /**
     * Platform specific directory separator character.
     * This is backslash ('\') on Windows, slash ('/') on Unix, and colon (':') on Mac.
     */
    const DIRECTORY_SEPARATOR_CHAR = '\\';

    /**
     * Platform specific alternate directory separator character.
     * This is backslash ('\') on Unix, and slash ('/') on Windows and MacOS.
     */
    const ALTDIRECTORY_SEPARATOR_CHAR = '/';

    /**
     * Platform specific volume separator character.
     * This is colon (':') on Windows and MacOS, and slash ('/') on Unix.
     *
     * This is mostly useful for parsing paths like
     * "c:\windows" or "MacVolume:System Folder".
     */
    const VOLUME_SEPARATOR_CHAR = ':';

    const INVALID_PATH_ASCII = [
        0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
        11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
        21, 22, 23, 24, 25, 26, 27, 28, 29, 30,
        31, 34, 60, 62, 124
    ];

    /**
     * Changes the extension of a path string.
     *
     * If path is null, the function returns null.
     *
     * @param string $path      The path information to modify.
     *                          The path cannot contain any of the characters
     *                          defined in invalidPathChars.
     *                          If it does not contain a file extension,
     *                          the new file extension is appended to the path.
     * @param string $extension The new extension (with or without a leading period).
     *                          Specify null to remove an existing extension from path.
     *                          If it is null, any existing extension is removed from path.
     *
     * @return string           A file path with the same root, directory,
     *                          and base name parts as path,
     *                          but with the file extension changed
     *                          to the specified extension.
     */
    public static function changeExtension(string $path, string $extension = null): string
    {
        self::checkInvalidPathChars($path);

        $newPath = $path;
        $pathLength = mb_strlen($path);

        for ($i = $pathLength; --$i >= 0;) {
            $character = $path[$i];

            if ($character == '.') {
                $newPath = mb_substr($newPath, 0, $i);
                break;
            }

            if (in_array(
                $character,
                [
                    self::DIRECTORY_SEPARATOR_CHAR,
                    self::ALTDIRECTORY_SEPARATOR_CHAR,
                    self::VOLUME_SEPARATOR_CHAR,
                ]
            )) {
                break;
            }
        }

        if ($extension !== null && $pathLength !== 0) {
            if (mb_strlen($extension) === 0 || $extension[0] !== '.') {
                $newPath .= ".";
            }
            $newPath .= $extension;
        }

        return $newPath;
    }

    /**
     * Gets an array containing the characters that are not allowed in path names.
     */
    public static function invalidPathChars(): array
    {
        return Collection::from(self::INVALID_PATH_ASCII)
                         ->map(
                             function (string $ascii) {
                                 return chr($ascii);
                             }
                         )
                         ->toArray();
    }

    /**
     * Check if contains one or more of the invalid characters
     * defined in invalidPathChars.
     */
    private static function checkInvalidPathChars(string $path): void
    {
        if (self::hasIllegalCharacter($path)) {
            throw new \InvalidArgumentException("'$path': This file name is not valid.");
        }
    }

    /**
     * Indicates if the given path contains invalid characters.
     * (", <, >, or any ASCII char whose integer representation
     * is in the range of 0 through 31)
     */
    private static function hasIllegalCharacter(string $path): bool
    {
        return Collection::from(self::INVALID_PATH_ASCII)
                         ->some(
                             function (string $ascii) use ($path): bool {
                                 return strpos($path, chr($ascii));
                             }
                         );
    }
}
