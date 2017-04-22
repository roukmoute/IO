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
}
