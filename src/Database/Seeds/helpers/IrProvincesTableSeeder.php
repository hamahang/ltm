<?php
namespace Hamahang\LTM\Database\Seeds;

use Illuminate\Database\Seeder;

class IrProvincesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('ltm_ir_provinces')->delete();

        \DB::table('ltm_ir_provinces')->insert(array (
            0 =>
            array (
                'id' => 1,
                'uid' => 0,
                'version' => NULL,
                'name' => 'آذربایجان شرقی',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'uid' => 0,
                'version' => NULL,
                'name' => 'آذربایجان غربی',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'uid' => 0,
                'version' => NULL,
                'name' => 'اردبیل',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'uid' => 0,
                'version' => NULL,
                'name' => 'اصفهان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'uid' => 0,
                'version' => NULL,
                'name' => 'البرز',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'uid' => 0,
                'version' => NULL,
                'name' => 'ایلام',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'uid' => 0,
                'version' => NULL,
                'name' => 'بوشهر',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'uid' => 0,
                'version' => NULL,
                'name' => 'تهران',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            8 =>
            array (
                'id' => 9,
                'uid' => 0,
                'version' => NULL,
                'name' => 'چهارمحال و بختیاری',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            9 =>
            array (
                'id' => 10,
                'uid' => 0,
                'version' => NULL,
                'name' => 'خراسان جنوبی',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            10 =>
            array (
                'id' => 11,
                'uid' => 0,
                'version' => NULL,
                'name' => 'خراسان رضوی',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            11 =>
            array (
                'id' => 12,
                'uid' => 0,
                'version' => NULL,
                'name' => 'خراسان شمالی',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            12 =>
            array (
                'id' => 13,
                'uid' => 0,
                'version' => NULL,
                'name' => 'خوزستان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            13 =>
            array (
                'id' => 14,
                'uid' => 0,
                'version' => NULL,
                'name' => 'زنجان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            14 =>
            array (
                'id' => 15,
                'uid' => 0,
                'version' => NULL,
                'name' => 'سمنان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            15 =>
            array (
                'id' => 16,
                'uid' => 0,
                'version' => NULL,
                'name' => 'سیستان و بلوچستان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            16 =>
            array (
                'id' => 17,
                'uid' => 0,
                'version' => NULL,
                'name' => 'فارس',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            17 =>
            array (
                'id' => 18,
                'uid' => 0,
                'version' => NULL,
                'name' => 'قزوین',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            18 =>
            array (
                'id' => 19,
                'uid' => 0,
                'version' => NULL,
                'name' => 'قم',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            19 =>
            array (
                'id' => 20,
                'uid' => 0,
                'version' => NULL,
                'name' => 'کردستان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            20 =>
            array (
                'id' => 21,
                'uid' => 0,
                'version' => NULL,
                'name' => 'کرمان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            21 =>
            array (
                'id' => 22,
                'uid' => 0,
                'version' => NULL,
                'name' => 'کرمانشاه',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            22 =>
            array (
                'id' => 23,
                'uid' => 0,
                'version' => NULL,
                'name' => 'کهکلویه و بویراحمد',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            23 =>
            array (
                'id' => 24,
                'uid' => 0,
                'version' => NULL,
                'name' => 'گلستان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            24 =>
            array (
                'id' => 25,
                'uid' => 0,
                'version' => NULL,
                'name' => 'گیلان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            25 =>
            array (
                'id' => 26,
                'uid' => 0,
                'version' => NULL,
                'name' => 'لرستان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            26 =>
            array (
                'id' => 27,
                'uid' => 0,
                'version' => NULL,
                'name' => 'مازندران',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            27 =>
            array (
                'id' => 28,
                'uid' => 0,
                'version' => NULL,
                'name' => 'مرکزی',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            28 =>
            array (
                'id' => 29,
                'uid' => 0,
                'version' => NULL,
                'name' => 'هرمزگان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            29 =>
            array (
                'id' => 30,
                'uid' => 0,
                'version' => NULL,
                'name' => 'همدان',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
            30 =>
            array (
                'id' => 31,
                'uid' => 0,
                'version' => NULL,
                'name' => 'یزد',
                'description' => NULL,
                'created_at' => '2018-01-03 11:40:19',
                'updated_at' => '2018-01-03 11:40:19',
                'deleted_at' => NULL,
            ),
        ));


    }
}
