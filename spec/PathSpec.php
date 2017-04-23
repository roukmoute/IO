<?php

namespace spec\Roukmoute\IO;

use PhpSpec\ObjectBehavior;
use Roukmoute\IO\Path;

class PathSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Path::class);
    }

    public function it_changes_extension_with_linux_directory_separator()
    {
        $this::changeExtension("/etc/usb_mode-switch.d/myfile.com.extension", "old")
             ->shouldBe("/etc/usb_mode-switch.d/myfile.com.old");
    }

    public function it_changes_extension_with_linux_directory_separator_and_without_path_extension()
    {
        $this::changeExtension("/etc/usb_mode-switch.d/", "old")
             ->shouldBe("/etc/usb_mode-switch.d/.old");
    }

    public function it_removes_extension_with_linux_directory_separator_and_without_extension()
    {
        $this::changeExtension("/etc/usb_mode-switch.d/myfile.com.extension")
             ->shouldBe("/etc/usb_mode-switch.d/myfile.com");
    }

    public function it_changes_nothing_with_linux_directory_separator_without_extension_and_without_path_extension()
    {
        $this::changeExtension("/etc/usb_mode-switch.d/")
             ->shouldBe("/etc/usb_mode-switch.d/");
    }

    public function it_changes_extension_with_windows_directory_separator()
    {
        $this::changeExtension("C:\\mydir\\myfile.com.extension", "old")
             ->shouldBe("C:\\mydir\\myfile.com.old");
    }

    public function it_changes_extension_with_windows_directory_separator_and_without_path_extension()
    {
        $this::changeExtension("C:\\mydir\\", "old")
             ->shouldBe("C:\\mydir\\.old");
    }

    public function it_removes_extension_with_windows_directory_separator_and_without_extension()
    {
        $this::changeExtension("C:\\mydir\\myfile.com.extension")
             ->shouldBe("C:\\mydir\\myfile.com");
    }

    public function it_changes_nothing_with_windows_directory_separator_without_extension_and_without_path_extension()
    {
        $this::changeExtension("C:\\mydir\\")
             ->shouldBe("C:\\mydir\\");
    }

    public function it_changes_extension_with_macos_directory_separator()
    {
        $this::changeExtension("MacVolume:System Folder\\myfile.com.extension", "old")
             ->shouldBe("MacVolume:System Folder\\myfile.com.old");
    }

    public function it_changes_extension_with_macos_directory_separator_and_without_path_extension()
    {
        $this::changeExtension("MacVolume:System Folder\\", "old")
             ->shouldBe("MacVolume:System Folder\\.old");
    }

    public function it_removes_extension_with_macos_directory_separator_and_without_extension()
    {
        $this::changeExtension("MacVolume:System Folder\\myfile.com.extension")
             ->shouldBe("MacVolume:System Folder\\myfile.com");
    }

    public function it_changes_nothing_with_macos_directory_separator_without_extension_and_without_path_extension()
    {
        $this::changeExtension("MacVolume:System Folder\\")
             ->shouldBe("MacVolume:System Folder\\");
    }

    public function it_throws_if_path_has_illegal_character()
    {
        foreach (Path::INVALID_PATH_ASCII as $ascii) {
            $path = "my" . chr($ascii) . "file.com.extension";

            $this
                ->shouldThrow(new \InvalidArgumentException("'$path': This file name is not valid."))
                ->during("changeExtension", [$path]);
        }
    }

    public function it_gets_invalidPathChars()
    {
        $this::invalidPathChars()->shouldBeArray();
    }

    public function it_confirms_a_path_rooted()
    {
        $this::isPathRooted("C:\\mydir\\myfile.ext")->shouldBe(true);
        $this::isPathRooted("C:MyDir")->shouldBe(true);
        $this::isPathRooted("\\myPc\\mydir\\myfile")->shouldBe(true);
    }

    public function it_does_not_confirm_a_path_rooted()
    {
        $this::isPathRooted("mydir\\sudir\\")->shouldBe(false);
    }

    public function it_combines_two_simple_strings()
    {
        $this::combine("c:\\temp", "subdir\\file.txt")
             ->shouldBe("c:\\temp" . DIRECTORY_SEPARATOR . "subdir\\file.txt");
    }

    public function it_combines_two_complex_strings_into_a_path()
    {
        $this::combine("c:^*&)(_=@#'\\^&#2.*(.txt", "subdir\\file.txt")
             ->shouldBe("c:^*&)(_=@#'\\^&#2.*(.txt" . DIRECTORY_SEPARATOR . "subdir\\file.txt");
    }

    public function it_combines_without_first_path()
    {
        $this::combine("", "usb_mode-switch.d/myfile.com.extension")
             ->shouldBe("usb_mode-switch.d/myfile.com.extension");
    }

    public function it_combines_without_second_path()
    {
        $this::combine("MacVolume:System Folder\\", "")->shouldBe("MacVolume:System Folder\\");
    }

    public function it_combines_with_an_absolute_second_path()
    {
        $this::combine("MacVolume:System Folder\\", "C:\\mydir\\")->shouldBe("C:\\mydir\\");
    }

    public function it_combines_without_directory_separator()
    {
        $this::combine("/etc/usb_mode-switch.d", "subdir/myfile.com")
             ->shouldBe("/etc/usb_mode-switch.d" . DIRECTORY_SEPARATOR . "subdir/myfile.com");
    }
}
