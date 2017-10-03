<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;

use App\Model\Admin\UserPermission;

class GeneratePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel5modules:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate system permissions';

    /**
     * Create a new command instance.
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
     */
    public function handle(Request $code)
    {

        $this->info('Generating system permissions ...!');

        $file = app_path().'/Yaml/permissions.yml';

        if ( ! file_exists($file))
        {
            $this->error('The file permissions.yml does not exist!');
        }
        else{
            //Load the YAML file and parse it.
            $array = Yaml::parse(file_get_contents($file));

            foreach ($array as $key => $value) {
                $name = $key;
                //Lets loop through the value array to get the other details.
                $pid = $value['pid'];
                $machine_name = $value['name'];
                $description = $value['description'];

                //We need to check if we already stored this permission.
                $permission = UserPermission::where('machine_name','=',$machine_name)->first();

                //Only create a new permission if it doesn't existing.
                if (empty($permission)) {
                    $this->info('Permissions does not exist. We are creating some ...');

                    $new_permission = new UserPermission;

                    $new_permission->pid = $pid;
                    $new_permission->name = $name;
                    $new_permission->machine_name = $machine_name;
                    $new_permission->description = $description;

                    $new_permission->save();

                    $this->info('New permissions:'.$name.' generated');

                }else{

                    $this->info('Permissions exist. We are updating them ...!');

                    $new_permission = UserPermission::where('machine_name','=',$machine_name)->first();

                    $new_permission->name = $name;
                    $new_permission->machine_name = $machine_name;
                    $new_permission->description = $description;

                    $new_permission->save();

                }
            }
        }

    }
}
