<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \App\User::create([
//           'name'=>'罗东',
//            'email'=>'13548362638@qq.com',
//            'password'=>bcrypt('111111')
//        ]);
        //结合模型工厂实现
        factory(\App\User::class, 10)->create();
        //填充后更新【save】表中的第一 二 三条数据
        $user = \App\User::find(1);
        $user->name = '罗东';
        $user->email = '1559980806@qq.com';
        $user->password = bcrypt('111111');
        $user->is_admin = true;
        $user->save();
        $user = \App\User::find(2);
        $user->name = 'IU';
        $user->email = '2300071698@qq.com';
        $user->password = bcrypt('admin888');
        $user->save();
        $user = \App\User::find(3);
        $user->name = 'IU的fans';
        $user->email = 'hdcms@houdunren.com';
        $user->password = bcrypt('admin888');
        $user->save();
    }
}
