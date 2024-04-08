<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $users = [
            [
                'username' => 'INP Name 1',
                'email' => 'inp1@gmail.com',
                'user_type' => 'inp',
            ],
            [
                'username' => 'INP Name 2',
                'email' => 'inp2@gmail.com',
                'user_type' => 'inp',
            ],
            [
                'username' => 'INP Name 3',
                'email' => 'inp3@gmail.com',
                'user_type' => 'inp',
            ],
            [
                'username' => 'INP Name 4',
                'email' => 'inp4@gmail.com',
                'user_type' => 'inp',
            ],
            [
                'username' => 'INP Name 5',
                'email' => 'inp5@gmail.com',
                'user_type' => 'inp',
            ],
            [
                'username' => 'INP Name 6',
                'email' => 'inp6@gmail.com',
                'user_type' => 'inp',
            ],
            [
                'username' => 'INP Name 7',
                'email' => 'inp7@gmail.com',
                'user_type' => 'inp',
            ],
            [
                'username' => 'INP Name 8',
                'email' => 'inp8@gmail.com',
                'user_type' => 'inp',
            ],
            [
                'username' => 'INP Name 9',
                'email' => 'inp9@gmail.com',
                'user_type' => 'inp',
            ],
            [
                'username' => 'INP Name 10',
                'email' => 'inp10@gmail.com',
                'user_type' => 'inp',
            ],
            [
                'username' => 'Student Name 1',
                'email' => 'student1@gmail.com',
                'user_type' => 'student',
            ],
            [
                'username' => 'Student Name 2',
                'email' => 'student2@gmail.com',
                'user_type' => 'student',
            ],
            [
                'username' => 'Student Name 3',
                'email' => 'student3@gmail.com',
                'user_type' => 'student',
            ],
            [
                'username' => 'Student Name 4',
                'email' => 'student4@gmail.com',
                'user_type' => 'student',
            ],
            [
                'username' => 'Student Name 5',
                'email' => 'student5@gmail.com',
                'user_type' => 'student',
            ],
            [
                'username' => 'Student Name 6',
                'email' => 'student6@gmail.com',
                'user_type' => 'student',
            ],
            [
                'username' => 'Student Name 7',
                'email' => 'student7@gmail.com',
                'user_type' => 'student',
            ],
            [
                'username' => 'Student Name 8',
                'email' => 'student8@gmail.com',
                'user_type' => 'student',
            ],
            [
                'username' => 'Teacher',
                'email' => 'teacher@gmail.com',
                'user_type' => 'teacher',
            ],
        ];
        

        foreach($users as $user)
        {
            $add =  new User;
            $add->username = $user['username'];
            $add->email = $user['email'];
            $add->user_type = $user['user_type'];
            $add->password = bcrypt('123456');
            $add->save();
        }

    }
}
