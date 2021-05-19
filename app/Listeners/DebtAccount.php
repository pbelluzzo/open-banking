<?php

namespace App\Listeners;

use App\Events\ContractAccepted;
use App\Models\Accounts;
use App\Http\Controllers\AccountsController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DebtAccount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ContractAccepted  $event
     * @return void
     */
    public function handle(ContractAccepted $event)
    {
        $account = $event->contract->accounts;

        $this->debtAccount($account, $event->contract->amount_invested);
    }

    private function debtAccount(Accounts $account, $value)
    {
        $account->balance -= $value;
        $account->save();
    }
}
