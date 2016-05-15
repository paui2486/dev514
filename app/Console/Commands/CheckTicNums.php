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
        $tickets_info = DB::table('orders_detail')
                            ->select(array(
                                'act_tickets.id', 'act_tickets.total_numbers', 'act_tickets.left_over',
                                DB::raw("sum(orders_detail.sub_topic_number) as sold")
                            ))
                            ->leftJoin('orders', 'orders.id', '=', 'orders_detail.order_id')
                            ->leftJoin('act_tickets', 'orders_detail.sub_topic_id', '=', 'act_tickets.id')
                            ->where('orders.status', 2)
                            ->orWhere('orders.ExpireDate', '>=', date('Y-m-d H:i:s'))
                            ->groupBy('act_tickets.id')
                            ->get();

        foreach ($tickets_info as $ticket) {
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
