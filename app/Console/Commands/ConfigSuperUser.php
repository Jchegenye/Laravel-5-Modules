<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;

use App\User;
use App\ReusableCodes\DateFormats;
use App\ReusableCodes\GenerateVerificationCode;


class ConfigSuperUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel5modules:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate system superuser';

    /**
     * ConfigSuperUser constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @param Request $code
     */
    public function handle(Request $code)
    {
        $this->info('Initializing superuser ...!');

        $file = app_path().'/Yaml/InitializeSuperUser.yml';

        if ( ! file_exists($file))
        {
            $this->error('The file InitializeSuperUser.yml does not exist!');
        }
        else{
            //Load the YAML file and parse it.
            $array = Yaml::parse(file_get_contents($file));

            foreach ($array as $key => $value) {
                $name = $key;

                //Lets loop through the value array to get the other details.
                $root_name = $value['name'];
                $root_uid = $value['uid'];
                $root_username = $value['username'];
                $root_email = $value['email'];
                $root_password = $value['password'];

                //Check if Root user already exists
                $query = User::where('email','=',$root_email)->first();

                //Also fetch the permissions
                $permissions = $this->getAllPermissions();

                //Get Custom Dates class we had we created
                $date = new DateFormats();
                $Date1 = $date->date();

                //Get the auto-generated code from a class we created
                $new_code = new GenerateVerificationCode();
                $code = $new_code->generateVerifyCode($code);

                //Only create a superuser non existing.
                if (empty($query)) {
                    $this->info('Superuser does not exist. We are creating one ...');

                        $user = new User;

                            $user->name = $root_name;
                            $user->uid = $root_uid;
                            $user->username = $root_username;
                            $user->email = $root_email;
                            $user->password = Hash::make($root_password);

                            //CHANGE - Fetch this from permissions "name" as displayed in yaml
                            $user->role = [
                                'member_role',
                                'access_to_members_list',
                                'access_to_member_profile',
                                'access_to_admin_routes',
                                'access_to_workbench',
                                'can_give_permissions',
                                'can_approve_a_member',
                                'can_lock_user',
                                'can_delete_an_account',
                            ];

                            /*$user->user_status = 'member';*/
                            $user->signed_date = $Date1['Date1'];
                            $user->verification_token = $code;
                            $user->confirmation_code = '0';

                        $user->save();

                    $this->info('Superuser created ' . $name);
                }else{
                    $this->info('Superuser exists. We are updating permissions ...');

                    $user = User::where('email','=','chegenyejackson@gmail.com')->first();
                    
                    $user->uid = $root_uid;

                    //CHANGE - Fetch this from permissions "name" as displayed in yaml
                    $user->role = [
                        'member_role',
                        'access_to_members_list',
                        'access_to_member_profile',
                        'access_to_admin_routes',
                        'access_to_workbench',
                        'can_give_permissions',
                        'can_approve_a_member',
                        'can_lock_user',
                        'can_delete_an_account',
                    ];
                    /*$user->user_status = 'member';*/
                    $user->save();

                }
            }
        }
    }


    public function getAllPermissions(){


    }
}
