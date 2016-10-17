<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'link_name'  => '技术博客',
                'link_title' => '私人谈论',
                'link_url'   => 'http://www.llovem.com',
                'link_order' => 1,
            ),
            array(
                'link_name'  => '学习不可以停止',
                'link_title' => 'idjdj ',
                'link_url'   => 'http://www.baidu.com',
                'link_order' => 2,
            ),
        );
        DB::table('links')->insert($data);
    }
}
