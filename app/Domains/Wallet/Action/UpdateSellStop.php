<?php declare(strict_types=1);

namespace App\Domains\Wallet\Action;

use App\Domains\Wallet\Action\Traits\DataSellStop as DataSellStopTrait;
use App\Domains\Wallet\Model\Wallet as Model;

class UpdateSellStop extends ActionAbstract
{
    use DataSellStopTrait;

    /**
     * @return \App\Domains\Wallet\Model\Wallet
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->store();
        $this->trailingStop();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataSellStop();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkSellStop();
    }

    /**
     * @return void
     */
    protected function store(): void
    {
        $this->row->processing = false;

        $this->row->sell_stop = $this->data['sell_stop'];

        $this->row->sell_stop_amount = $this->data['sell_stop_amount'];
        $this->row->sell_stop_reference = $this->data['sell_stop_reference'];

        $this->row->sell_stop_max_exchange = $this->data['sell_stop_max_exchange'];
        $this->row->sell_stop_max_value = $this->data['sell_stop_max_value'];
        $this->row->sell_stop_max_percent = $this->data['sell_stop_max_percent'];
        $this->row->sell_stop_max_at = $this->data['sell_stop_max_at'];

        $this->row->sell_stop_min_exchange = $this->data['sell_stop_min_exchange'];
        $this->row->sell_stop_min_value = $this->data['sell_stop_min_value'];
        $this->row->sell_stop_min_percent = $this->data['sell_stop_min_percent'];
        $this->row->sell_stop_min_at = $this->data['sell_stop_min_at'];

        $this->row->save();
    }

    /**
     * @return void
     */
    protected function trailingStop(): void
    {
        if (empty($this->row->platform->trailing_stop)) {
            return;
        }

        $this->trailingStopOrderCancel();
        $this->trailingStopOrderCreate();
    }

    /**
     * @return void
     */
    protected function trailingStopOrderCancel(): void
    {
        if ($this->row->sell_stop) {
            return;
        }

        $this->factory('Order')->action()->cancelOpen($this->row->product);
    }

    /**
     * @return void
     */
    protected function trailingStopOrderCreate(): void
    {
        if (empty($this->row->sell_stop)) {
            return;
        }

        $this->factory()->action()->sellStopTrailingCreate();
    }
}
