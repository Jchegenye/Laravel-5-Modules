<?php

namespace App\Providers\Social;

use App\User;

class GoogleServiceProvider extends AbstractServiceProvider
{
   /**
     *  Handle Google response
     * 
     *  @return Illuminate\Http\Response
     */
    public function handle()
    {

        $user = $this->provider->stateless()->user([
            'name', 
            'email',
        ]);

        $existingUser = User::where('settings->google_id', $user->id)->first();

        if ($existingUser) {
            $settings = $existingUser->settings;

            if (! isset($settings['google_id'])) {
                $settings['google_id'] = $user->id;
                $existingUser->settings = $settings;
                $existingUser->save();
            }

            return $this->login($existingUser);
        }

        $newUser = $this->register([
            'name' => $user->name,
            'email' => $user->email,
            'settings' => [
                'google_id' => $user->id,                
            ]
        ]);        

        return $this->login($newUser);
    }       
}