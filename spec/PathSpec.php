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
}
