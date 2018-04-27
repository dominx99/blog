<?php

namespace Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use dominx99\school\BaseTestCase;
use dominx99\school\DatabaseTrait;
use dominx99\school\Models\User;
use dominx99\school\Models\SocialProvider;

class SocialProviderTest extends BaseTestCase
{
    use DatabaseTrait;

    public function testThatUserCanHaveManySocialProviders()
    {
        $socialProvider = new SocialProvider();

        $this->assertInstanceOf(BelongsTo::class, $socialProvider->user());
        $this->assertInstanceOf(User::class, $socialProvider->user()->getRelated());
    }
}
