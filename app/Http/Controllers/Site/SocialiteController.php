<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Socialite;
use Google;
use SearchConsole;

class SocialiteController extends Controller
{
    /**
     * Google認証へリダイレクト
     */
    public function redirect()
    {
        return Socialite::driver('google')
                        ->scopes(config('google.scopes'))
                        ->with([
                            'access_type'     => config('google.access_type'),
                            'approval_prompt' => config('google.approval_prompt'),
                        ])
                        ->redirect();
    }

    /**
     * Google認証からのcallback。追加サイトリストを表示
     *
     * @param Request $request
     *
     * @return \Response
     *
     * @throws \Exception
     */
    public function callback(Request $request)
    {
        if (!request()->has('code')) {
            return redirect('/');
        }

        /**
         * @var \Laravel\Socialite\Two\User $user
         */
        $user = Socialite::driver('google')->user();

        //        dd($user);

        $access_token = $user->token;
        $refresh_token = $user->refreshToken;
        $expires_in = $user->expiresIn;
        $created = now()->getTimestamp();

        $token = compact(['access_token', 'refresh_token', 'expires_in', 'created']);

        $list_sites = SearchConsole::setAccessToken($token)->listSites();

        $sites = collect();

        foreach ($list_sites->siteEntry as $site) {
            if ($site->permissionLevel !== 'siteUnverifiedUser') {
                $sites->push([
                    'url'        => $site->siteUrl,
                    'permission' => $site->permissionLevel,
                ]);
            }
        }

        return view('sites.list')->with(compact(['sites', 'access_token', 'refresh_token']));
    }
}
