<?php

namespace App\Console\Commands;

use DB;
use Log;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class checkTicNums extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkTicNums';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Turn Back the missing Tickets';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tickets = DB::table('act_tickets')->select(array('id', 'total_numbers', 'left_over'))->get();



        foreach ($tickets as $ticket) {
          # code...
            $sold = DB::table('orders_detail')
                      ->leftJoin('orders', 'orders.id', '=', 'orders_detail.order_id')
                      ->where('orders_detail.sub_topic_id', $ticket->id)
                      ->where('orders.status', 2)
                      ->sum('sub_topic_number');

            $unclear = DB::table('orders_detail')
                      ->leftJoin('orders', 'orders.id', '=', 'orders_detail.order_id')
                      ->where('orders_detail.sub_topic_id', $ticket->id)
                      ->where('orders.status', '!=', 2)
                      ->where('orders.ExpireDate', '>=', date('Y-m-d H:i:s'))
                      ->sum('sub_topic_number');
            $ticket->sold = $sold + $unclear;
        }

        DB::table('orders')
            ->where('status', '!=', 2)
            ->where('ExpireDate', '<', date('Y-m-d H:i:s'))
            ->update(array( 'status'=> 1 ));

        foreach ($tickets as $ticket) {
            $left_over = $ticket->total_numbers - $ticket->sold;
            if ($left_over < 0) {
                Log::error("Ticket Numbers error: " . $ticket->id . " have $left_over...");
                $left_over = 0;
            }

            DB::table('act_tickets')->where('id', $ticket->id)
              ->update(array(
                  'left_over'    => $left_over,
                  'ticket_start' => DB::raw('ticket_start'),
              ));
        }
    }
}
