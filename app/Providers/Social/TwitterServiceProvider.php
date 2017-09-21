<?php

namespace App\Providers\Social;

use App\User;

class TwitterServiceProvider extends AbstractServiceProvider
{
   /**
     *  Handle Twitter response
     * 
     *  @return Illuminate\Http\Response
     */
    public function handle()
    {
        /*$user = $this->provider->fields([
                    'first_name', 
                    'last_name', 
                    'email', 
                    'gender', 
                    'verified',                    
                ])->user();*/
        $user = $this->provider->user(
            [
                'first_name', 
                'last_name', 
                'email', 
                'gender', 
                'verified',                    
            ]
        );

        //$existingUser = User::where('settings->twitter_id', $user->id)->first();

        $existingUser = User::where('email', $user->email)->first();

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
            /*'first_name' => $user->user['first_name'],
            'last_name' => $user->user['last_name'],*/
            'name' => $user->user['first_name'] . ' ' . $user->user['last_name'],
            'email' => $user->email,
            'gender' => ucfirst($user->user['gender']),
            'settings' => [
                'twitter_id' => $user->id,                
            ]
        ]);        

        return $this->login($newUser);
    }       
}