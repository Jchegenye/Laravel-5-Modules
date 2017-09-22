<?php

namespace App\Providers\Social;

use App\User;

class TwitterServiceProvider extends AbstractServiceProvider
{
   /**
     *  Handle Twitter response
     *
     *  @author Jackson Chegenye http://jchegenye.me
     *  @return Illuminate\Http\Response
     */
    public function handle()
    {

        $user = $this->provider->user([
            'name', 
            'email',
        ]);

        $existingUser = User::where('settings->twitter_id', $user->id)->first();

        if ($existingUser) {
            $settings = $existingUser->settings;

            if (! isset($settings['twitter_id'])) {
                $settings['twitter_id'] = $user->id;
                $existingUser->settings = $settings;
                $existingUser->save();
            }

            return $this->login($existingUser);
        }

        $newUser = $this->register([
            'name' => $user->name,
            'email' => $user->email,
            'settings' => [
                'twitter_id' => $user->id,                
            ]
        ]);        

        return $this->login($newUser);
    }       
}