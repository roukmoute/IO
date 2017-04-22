---
layout: default
---

###### [IO](../index.md) > [Path Class](../path.md)

# Path::isPathRooted Method (string)

Gets a value indicating whether the specified path string contains a root.

## Syntax

```php
public static function isPathRooted(string $path): bool
```

### Parameters

```
$path
    Type: string

    The path to test. 
```

```
Return Value
    Type: bool
    
    true if path contains a root; otherwise, false.
```

### Exceptions

| Exception                 | Condition                                                                               |
|---------------------------|-----------------------------------------------------------------------------------------|
| \InvalidArgumentException | path contains one or more of the invalid characters defined in invalidPathChars method. |

### Remarks

The isPathRooted method returns true if the first character is a directory
separator character such as "\", or if the path starts with a drive letter 
and colon (:). 
For example, it returns true for path strings such as "\\MyDir\\MyFile.txt", 
"C:\\MyDir", or "C:MyDir". 
It returns false for path strings such as "MyDir".

This method does not verify that the path or file name exists.

### Example

The following code example demonstrates a use of the isPathRooted method.

```php
<?php
use Roukmoute\IO\Path;

$filename = "C:\\mydir\\myfile.ext";
$relativePath = "mydir\\sudir\\";

$result = Path::isPathRooted($filename);
var_dump($result);

$result = Path::isPathRooted($relativePath);
var_dump($result);

// This code produces output similar to the following:
//
// isPathRooted("C:\\mydir\\myfile.ext") returns true
// isPathRooted("mydir\\sudir\\") returns false
```
