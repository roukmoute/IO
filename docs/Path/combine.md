---
layout: default
---

###### [IO](../index.md) > [Path Class](../path.md)

# Path::combine Method (string, string)

Gets a value indicating whether the specified path string contains a root.

## Syntax

```php
public static function combine(string $path1, string $path2): string
```

### Parameters

```
path1
    Type: string

    The first path to combine.
```

```
path2
    Type: string

    The second path to combine.
```

```
Return Value
    Type: string
    
    The combined paths.
    If one of the specified paths is a zero-length string, 
    this method returns the other path. 
    If path2 contains an absolute path, this method returns path2.
```

### Exceptions

| Exception                 | Condition                                                                                         |
|---------------------------|---------------------------------------------------------------------------------------------------|
| \InvalidArgumentException | path1 or path2 contains one or more of the invalid characters defined in invalidPathChars method. |

### Remarks

If path1 is not a drive reference (that is, "C:" or "D:") and does not end with
a valid separator character as defined in 
DIRECTORY_SEPARATOR_CHAR, ALTDIRECTORY_SEPARATOR_CHAR, or VOLUME_SEPARATOR_CHAR, 
DIRECTORY_SEPARATOR is appended to path1 before concatenation.

If path2 does not include a root (for example, if path2 does not start with 
a separator character or a drive specification), the result is a concatenation 
of the two paths, with an intervening separator character. 
If path2 includes a root, path2 is returned.

The parameters are not parsed if they have white space. 
Therefore, if path2 includes white space (for example, " \file.txt "), 
the combine method appends path2 to path1 instead of returning only path2.

### Example

The following code example demonstrates a use of the combine method.

```php
<?php
use Roukmoute\IO\Path;

$path1 = "/usr/temp";
$path2 = "subdir/file.txt";
$path3 = "/usr/temp.txt";
$path4 = "";

$combination = Path::combine($path1, $path2);
echo $combination . PHP_EOL;

$combination = Path::combine($path1, $path3);
echo $combination . PHP_EOL;

$combination = Path::combine($path3, $path2);
echo $combination . PHP_EOL;

$combination = Path::combine($path4, $path2);
echo $combination . PHP_EOL;


// This code produces output similar to the following:
//
//  When you combine "/usr/temp" and "subdir/file.txt", the result is:
// "/usr/temp/subdir/file.txt"
//
//  When you combine "/usr/temp" and "/usr/temp.txt", the result is:
// "/usr/temp.txt"
//
//  When you combine "/usr/temp" and "subdir/file.txt", the result is:
// "/usr/temp.txt/subdir/file.txt"
//
//  When you combine "" and "subdir/file.txt", the result is:
// "subdir/file.txt"
```
