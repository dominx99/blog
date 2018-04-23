<?php

namespace dominx99\school\Controllers;

use dominx99\school\Auth\Auth;
use dominx99\school\Models\SocialProvider;
use dominx99\school\Models\User;

/**
 * @property $avaibleProviders
 */
class SocialiteController extends Controller
{
    public function auth($request)
    {
        $route = $request->getAttribute('route');
        $provider = $route->getArgument('provider');

        if (!in_array($provider, $this->avaibleProviders)) {
            return 'Incorect provider';
        }

        $response = $this->socialite->driver($provider)->redirect();
        $response->send();
    }

    public function handle($request, $response)
    {
        $route = $request->getAttribute('route');
        $provider = $route->getArgument('provider');

        if (!in_array($provider, $this->avaibleProviders)) {
            return 'Incorect provider';
        }

        try {
            $socialUser = $this->socialite->driver($provider)->user();
        } catch (\Exception $e) {
            return $response->withRedirect($this->router->pathFor('home'));
        }

        $socialProvider = SocialProvider::where('provider_id', $socialUser->getId())->first();

        if (!$socialProvider) {
            $user = User::firstOrCreate([
                'email' => $socialUser->getEmail(),
                'name' => $socialUser->getName()
            ]);

            $user->socialProviders()->create([
                'provider_id' => $socialUser->getId(),
                'provider' => $provider
            ]);
        } else {
            $user = $socialProvider->user;
        }

        Auth::authorize($user->id);

        return $response->withRedirect($this->router->pathFor('dashboard'));
    }
}
