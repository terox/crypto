<div class="overflow-auto md:overflow-visible header-sticky">
    <table id="order-status-table" class="table table-report sm:mt-2 font-medium" data-table-sort>
        <thead>
            <tr class="text-right">
                <th class="text-center">{{ __('order-status.wallet') }}</th>
                <th class="text-center">{{ __('order-status.product') }}</th>
                <th class="text-center">{{ __('order-status.platform') }}</th>
                <th class="text-center">{{ __('order-status.buy-operations') }}</th>
                <th class="text-center">{{ __('order-status.sell-operations') }}</th>
                <th class="text-center">{{ __('order-status.date-first') }}</th>
                <th class="text-center">{{ __('order-status.date-last') }}</th>
                <th class="text-center" title="{{ __('order-status.buy-price-average-description') }}">{{ __('order-status.buy-price-average') }}</th>
                <th class="text-center" title="{{ __('order-status.sell-price-average-description') }}">{{ __('order-status.sell-price-average') }}</th>
                <th class="text-center" title="{{ __('order-status.buy-value-description') }}">{{ __('order-status.buy-value') }}</th>
                <th class="text-center" title="{{ __('order-status.sell-value-description') }}">{{ __('order-status.sell-value') }}</th>
                <th class="text-center" title="{{ __('order-status.wallet-price-value-description') }}">{{ __('order-status.wallet-price-value') }}</th>
                <th class="text-center" title="{{ __('order-status.sell-pending-value-description') }}">{{ __('order-status.sell-pending-value') }}</th>
                <th class="text-center">{{ __('order-status.balance') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            <tr class="text-right">
                <td class="text-center">
                    @if ($row->wallet)
                    <a href="{{ route('wallet.update', $row->wallet->id) }}" class="block font-semibold whitespace-nowrap external">{{ $row->wallet->name }}</a>
                    @else
                    -
                    @endif
                </td>
                <td><a href="{{ route('exchange.detail', $row->product->id) }}" class="block text-center font-semibold whitespace-nowrap external">{{ $row->product->acronym }}</a></td>
                <td><a href="{{ $row->platform->url.$row->product->code }}" rel="nofollow noopener noreferrer" target="_blank" class="block text-center font-semibold whitespace-nowrap external">{{ $row->platform->name }}</a></td>

                <td class="text-center"><span class="block">@number($row->buy_count, 0)</span></td>
                <td class="text-center"><span class="block">@number($row->sell_count, 0)</span></td>

                <td><span class="block whitespace-nowrap">@datetime($row->date_first)</span></td>
                <td><span class="block whitespace-nowrap">@datetime($row->date_last)</span></td>

                <td><span class="block">@number($row->buy_average)</span></td>
                <td><span class="block">@number($row->sell_average)</span></td>

                <td><span class="block" title="{{ Html::orderBuySellTitle($row->buy) }}">@number($row->buy_value)</span></td>
                <td><span class="block" title="{{ Html::orderBuySellTitle($row->sell) }}">@number($row->sell_value)</span></td>

                @if ($row->wallet)
                <td><span class="block">@number($row->wallet->amount)</span></td>
                @else
                <td>-</td>
                @endif

                <td><span class="block">@number($row->sell_pending_value)</span></td>
                <td><span class="block">@number($row->balance, 2)</span></td>
            </tr>

            @endforeach

            <tr class="text-right">
                <td></td>
                <td colspan="2"></td>
                <td class="text-center"><span class="block">@number($list->sum('buy_count'), 0)</span></td>
                <td class="text-center"><span class="block">@number($list->sum('sell_count'), 0)</span></td>
                <td colspan="4"></td>
                <td><span class="block">@number($list->sum('buy_value'))</span></td>
                <td><span class="block">@number($list->sum('sell_value'))</span></td>
                <td colspan="2"></td>
                <td><span class="block">@number($list->sum('balance'))</span></td>
            </tr>
        </tbody>
    </table>
</div>
