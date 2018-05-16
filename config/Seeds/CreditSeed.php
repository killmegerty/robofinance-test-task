<?php
use Migrations\AbstractSeed;

/**
 * Credit seed.
 */
class CreditSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'client_id' => 1,
                'application_id' => 1,
                'status' => 'active'
            ],
            [
                'client_id' => 1,
                'application_id' => 3,
                'status' => 'active'
            ],
            [
                'client_id' => 1,
                'application_id' => 4,
                'status' => 'active'
            ],
            [
                'client_id' => 3,
                'application_id' => 5,
                'status' => 'active'
            ],
            [
                'client_id' => 1,
                'application_id' => 6,
                'status' => 'active'
            ],
            [
                'client_id' => 3,
                'application_id' => 7,
                'status' => 'active'
            ]
        ];

        $table = $this->table('credit');
        $table->insert($data)->save();
    }
}
