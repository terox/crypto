<?php declare(strict_types=1);

namespace App\Domains\Wallet\Action;

use App\Domains\Order\Model\Order as OrderModel;
use App\Domains\Platform\Model\Platform as PlatformModel;
use App\Domains\Product\Model\Product as ProductModel;
use App\Domains\Wallet\Model\Wallet as Model;
use App\Domains\Wallet\Service\Logger\BuySellStop as BuySellStopLogger;

class SellStopLoss extends ActionAbstract
{
    /**
     * @var \App\Domains\Order\Model\Order
     */
    protected OrderModel $order;

    /**
     * @var \App\Domains\Platform\Model\Platform
     */
    protected PlatformModel $platform;

    /**
     * @var \App\Domains\Product\Model\Product
     */
    protected ProductModel $product;

    /**
     * @var bool
     */
    protected bool $executable;

    /**
     * @return \App\Domains\Wallet\Model\Wallet
     */
    public function handle(): Model
    {
        $this->platform();
        $this->product();
        $this->executable();
        $this->log();

        if ($this->executable === false) {
            return $this->row;
        }

        $this->start();
        $this->order();
        $this->sync();
        $this->update();
        $this->finish();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function platform(): void
    {
        $this->platform = $this->row->platform;
        $this->platform->userPivotLoad($this->auth);
    }

    /**
     * @return void
     */
    protected function product(): void
    {
        $this->product = $this->row->product;
        $this->product->setRelation('platform', $this->platform);
    }

    /**
     * @return void
     */
    protected function executable(): void
    {
        $this->executable = (bool)$this->platform->userPivot
            && ($this->row->processing === false)
            && $this->row->enabled
            && $this->row->crypto
            && $this->row->amount
            && $this->row->sell_stoploss
            && $this->row->sell_stoploss_exchange
            && $this->row->sell_stoploss_at
            && $this->row->sell_stoploss_executable
            && ($this->row->amount >= $this->product->quantity_min);
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        BuySellStopLogger::set('wallet-sell-stop-loss', $this->row, $this->executable);
    }

    /**
     * @return void
     */
    protected function start(): void
    {
        $this->row->processing = true;
        $this->row->save();
    }

    /**
     * @return void
     */
    protected function order(): void
    {
        $this->orderCreate();
        $this->orderUpdate();
    }

    /**
     * @return void
     */
    protected function orderCreate(): void
    {
        $this->order = $this->factory('Order')->action([
            'type' => 'MARKET',
            'side' => 'sell',
            'amount' => $this->row->amount,
        ])->create($this->product);
    }

    /**
     * @return void
     */
    protected function orderUpdate(): void
    {
        $this->order->wallet_id = $this->row->id;
        $this->order->save();
    }

    /**
     * @return void
     */
    protected function sync(): void
    {
        $this->syncOrder();
        $this->syncWallet();
    }

    /**
     * @return void
     */
    protected function syncOrder(): void
    {
        $this->factory('Order')->action()->syncByProduct($this->product);
    }

    /**
     * @return void
     */
    protected function syncWallet(): void
    {
        $this->factory()->action()->syncOne();
    }

    /**
     * @return void
     */
    protected function update(): void
    {
        $this->updateOrder();

        if (empty($this->order->filled)) {
            return;
        }

        $this->updateSellStopLoss();
    }

    /**
     * @return void
     */
    protected function updateOrder(): void
    {
        $this->order = OrderModel::findOrFail($this->order->id);
    }

    /**
     * @return void
     */
    protected function updateSellStopLoss(): void
    {
        $this->row->sell_stoploss = false;
        $this->row->sell_stoploss_executable = false;
    }

    /**
     * @return void
     */
    protected function finish(): void
    {
        $this->row->processing = false;
        $this->row->save();
    }
}
