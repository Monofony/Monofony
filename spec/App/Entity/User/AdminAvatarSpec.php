<?php

namespace spec\App\Entity\User;

use App\Entity\Media\File;
use App\Entity\User\AdminAvatar;
use PhpSpec\ObjectBehavior;

class AdminAvatarSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AdminAvatar::class);
    }

    function it_is_a_file(): void
    {
        $this->shouldHaveType(File::class);
    }

    function it_has_no_file_by_default(): void
    {
        $this->getFile()->shouldReturn(null);
    }

    function its_file_is_mutable(\SplFileInfo $file): void
    {
        $this->setFile($file);

        $this->getFile()->shouldReturn($file);
    }

    function it_has_no_path_by_defaut(): void
    {
        $this->getPath()->shouldReturn(null);
    }

    function its_path_is_mutable(): void
    {
        $this->setPath('avatar.png');

        $this->getPath()->shouldReturn('avatar.png');
    }
}
