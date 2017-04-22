---
layout: default
---

###### [IO](../index.md) > [Path Class](../path.md)

# Path::changeExtension Method (string, string)

Performs operations on String instances that contain file or directory path information.  
These operations are performed in a cross-platform manner.

## Syntax

```php
public static function changeExtension(string $path, string $extension): string
```

### Parameters

```
$path
    Type: string

    The path information to modify.
    The path cannot contain any of the characters defined in invalidPathChars method.
```

```
$extension
    Type: string

    The new extension (with or without a leading period).
    Specify null to remove an existing extension from path. 
```

```
Return Value
    Type: string
    The modified path information.
```

### Exceptions

| Exception                 | Condition                                                                               |
|---------------------------|-----------------------------------------------------------------------------------------|
| \InvalidArgumentException | path contains one or more of the invalid characters defined in invalidPathChars method. |

### Remarks

If neither path nor extension contains a period (.), changeExtension method 
adds the period.

The extension parameter can contain multiple periods and any valid path 
characters, and can be any length.
If extension is null, the returned string contains the contents of path with 
the last period and all characters following it removed.

If extension is an empty string, the returned path string contains the contents 
of path with any characters following the last period removed.

If path does not have an extension and extension is not null, the returned 
string contains path followed by extension.

If extension is not null and does not contain a leading period, the period 
is added.

If path contains a multiple extension separated by multiple periods, the 
returned string contains the contents of path with the last period and all 
characters following it replaced by extension.
For example, if path is "\Dir1\examples\pathtests.csx.txt" and extension 
is "cs", the modified path is "\Dir1\examples\pathtests.csx.cs".

It is not possible to verify that the returned results are valid in all scenarios.
For example, if path is empty, extension is appended.

### Example

The following code example demonstrates a use of the changeExtension method.

```php
<?php
use Roukmoute\IO\Path;

$goodFileName = "C:\\mydir\\myfile.com.extension";
$badFileName = "C:\\mydir\\";

$result = Path::changeExtension($goodFileName, ".old");
echo $result . PHP_EOL;

$result = Path::changeExtension($goodFileName, "");
echo $result . PHP_EOL;

$result = Path::changeExtension($badFileName, ".old");
echo $result . PHP_EOL;

// This code produces output similar to the following:
//
// changeExtension("C:\\mydir\\myfile.com.extension", ".old") returns "C:\mydir\myfile.com.old"
// changeExtension("C:\\mydir\\myfile.com.extension", "") returns "C:\mydir\myfile.com."
// changeExtension("C:\mydir\", ".old") returns "C:\mydir\.old"
```
