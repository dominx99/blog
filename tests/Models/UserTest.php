<?php

namespace Tests\Unit\Models;

use dominx99\school\BaseTestCase;
use dominx99\school\DatabaseTrait;
use dominx99\school\Models\SocialProvider;
use dominx99\school\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserTest extends BaseTestCase
{
    use DatabaseTrait;

    public function testThatUserCanHaveManySocialProviders()
    {
        $user = new User();

        $this->assertInstanceOf(HasMany::class, $user->socialProviders());
        $this->assertInstanceOf(SocialProvider::class, $user->socialProviders()->getRelated());
    }
}
