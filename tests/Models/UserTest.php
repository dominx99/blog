<?php

namespace Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use dominx99\school\BaseTestCase;
use dominx99\school\DatabaseTrait;
use dominx99\school\Models\User;
use dominx99\school\Models\SocialProvider;

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
