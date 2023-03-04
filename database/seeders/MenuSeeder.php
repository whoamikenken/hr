<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Menus

        Menu::factory()->create([
            'root' => '0',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            }, 
            'order' => function () {
                $maxOrder = Menu::where('root','=','0')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Dashboard',
            'link' => 'home',
            'icon' => 'motherboard',
            'description' => "Visual display of all of your data"
        ]);

        Menu::factory()->create([
            'root' => '0',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root','=','0')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'User Management',
            'link' => 'user/user',
            'icon' => 'person-badge',
            'description' => "User management add and edit permission"
        ]);

        Menu::factory()->create([
            'root' => '0',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '0')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Employee List',
            'link' => 'user/employee',
            'icon' => 'person-rolodex',
            'description' => "List of Employee"
        ]);

        Menu::factory()->create([
            'root' => '0',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => '98',
            'title' => 'System Setup',
            'link' => '',
            'icon' => '',
            'description' => ""
        ]);

        Menu::factory()->create([
            'root' => '0',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => '99',
            'title' => 'System Configuration',
            'link' => '',
            'icon' => '',
            'description' => ""
        ]);

        Menu::factory()->create([
            'root' => '5',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root','=','6')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'User type',
            'icon' => 'people',
            'link' => 'user/usertype',
            'description' => "Creating new usertype"
        ]);

        Menu::factory()->create([
            'root' => '5',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '6')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Table Picker',
            'link' => 'config/tablecolumn',
            'icon' => 'wrench-adjustable-circle',
            'description' => "Modification of setup column."
        ]);

        Menu::factory()->create([
            'root' => '4',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '5')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Announcement',
            'link' => 'setup/announcement',
            'icon' => 'inboxes',
            'description' => "Creating new announcement"
        ]);

        Menu::factory()->create([
            'root' => '4',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '5')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Schedule List',
            'link' => 'setup/schedule',
            'icon' => 'people',
            'description' => "Creating new schedule"
        ]);

        Menu::factory()->create([
            'root' => '4',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '5')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Batch Scheduling',
            'link' => 'setup/batchscheduling',
            'icon' => 'people',
            'description' => "Creating new schedule in batch"
        ]);

        Menu::factory()->create([
            'root' => '4',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '5')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Office',
            'link' => 'setup/office',
            'icon' => 'people',
            'description' => "Creating new Offices"
        ]);

        Menu::factory()->create([
            'root' => '4',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '5')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Department',
            'link' => 'setup/department',
            'icon' => 'people',
            'description' => "Creating new Department"
        ]);

        Menu::factory()->create([
            'root' => '0',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '0')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'My Profile',
            'link' => 'user/profile',
            'icon' => 'people',
            'description' => "Employee Profile"
        ]);
        
        Menu::factory()->create([
            'root' => '0',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '0')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Attendance',
            'link' => 'attendance',
            'icon' => 'calendar-week',
            'description' => "Visual display of all of your attendance"
        ]);

        Menu::factory()->create([
            'root' => '0',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '0')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'My Work Request',
            'link' => 'wfh/wfh',
            'icon' => 'file-earmark-richtext',
            'description' => "List of work requests"
        ]);

        Menu::factory()->create([
            'root' => '0',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '0')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Manage Work Request',
            'link' => 'wfh/wfh_manage',
            'icon' => 'card-checklist',
            'description' => "List of work requests"
        ]);

        Menu::factory()->create([
            'root' => '0',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '0')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Employee Logs',
            'link' => 'logs/web_logs',
            'icon' => 'person-lines-fill',
            'description' => "List of employee logs"
        ]);

        Menu::factory()->create([
            'root' => '0',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '0')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Employee Attendance',
            'link' => 'logs/attendance',
            'icon' => 'person-lines-fill',
            'description' => "List of employee attendance"
        ]);

        Menu::factory()->create([
            'root' => '5',
            'menu_id' => function () {
                $max = Menu::count('id'); // returns 0 if no records exist.
                return $max + 1;
            },
            'order' => function () {
                $maxOrder = Menu::where('root', '=', '6')->count('order'); // returns 0 if no records exist.
                return $maxOrder + 1;
            },
            'title' => 'Work Parameter',
            'link' => 'config/workpara',
            'icon' => 'pin-map',
            'description' => "Setup for work parameter"
        ]);

    }
}
