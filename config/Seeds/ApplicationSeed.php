<?php
use Migrations\AbstractSeed;

/**
 * Application seed.
 */
class ApplicationSeed extends AbstractSeed
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
                'status' => 'active',
                'requested_amount' => 10,
                'requested_period' => 8,
                'approved_amount' => 0,
                'approved_period' => 0,
                'offer_id' => 1
            ],
            [
                'client_id' => 2,
                'status' => 'active',
                'requested_amount' => 5,
                'requested_period' => 3,
                'approved_amount' => 0,
                'approved_period' => 0,
                'offer_id' => 2
            ],
            [
                'client_id' => 1,
                'status' => 'active',
                'requested_amount' => 100,
                'requested_period' => 5,
                'approved_amount' => 0,
                'approved_period' => 0,
                'offer_id' => 1
            ],
            [
                'client_id' => 1,
                'status' => 'active',
                'requested_amount' => 5.5,
                'requested_period' => 12,
                'approved_amount' => 0,
                'approved_period' => 0,
                'offer_id' => 1
            ],
            [
                'client_id' => 3,
                'status' => 'active',
                'requested_amount' => 14.5,
                'requested_period' => 1,
                'approved_amount' => 0,
                'approved_period' => 0,
                'offer_id' => 1
            ],
            [
                'client_id' => 1,
                'status' => 'active',
                'requested_amount' => 12.3,
                'requested_period' => 2,
                'approved_amount' => 0,
                'approved_period' => 0,
                'offer_id' => 1
            ],
            [
                'client_id' => 3,
                'status' => 'active',
                'requested_amount' => 7.5,
                'requested_period' => 5,
                'approved_amount' => 0,
                'approved_period' => 0,
                'offer_id' => 1
            ]
        ];

        $table = $this->table('application');
        $table->insert($data)->save();
    }
}
