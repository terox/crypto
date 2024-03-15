<div class="whitespace-nowrap">
    <div class="box p-2">
        <div class="flex px-2 pb-2 items-center">
            <div class="percent-pill {{ ($result < 0) ? 'bg-theme-24' : 'bg-theme-10' }}">
                {{ $current_exchange_percent }}% @icon(($result < 0) ? 'chevron-down' : 'chevron-up', 'w-4 h-4')
            </div>

            <div class="relative text-lg sm:text-xl font-bold ml-3 overflow-auto">
                <a href="{{ route('wallet.update', $row->id) }}">{{ $row->name }}</a>
                - <a href="{{ route('exchange.detail', $row->product_id) }}"class="text-gray-500">{{ $row->product->name }}</a>
                <a href="{{ $row->platform->url.$row->product->code }}" class="text-gray-400" rel="nofollow noopener noreferrer" target="_blank">- {{ $row->platform->name }}</a>
            </div>
        </div>

        <div class="lg:flex">
            <div class="flex flex-1 flex-wrap text-center">
                <div class="flex-1 p-2">
                    <div class="text-gray-600 text-xs">{{ __('wallet-stat.current_exchange') }}</div>
                    <div class="text-base" title="@numberString($current_exchange)">@number($current_exchange)</div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.current_value') }}</div>
                    <div class="text-base" title="@numberString($current_value)">@number($current_value)</div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.amount') }}</div>
                    <div class="text-base" title="@numberString($amount)">@number($amount)</div>
                </div>

                <div class="flex-1 p-2">
                    <div class="text-gray-600 text-xs">{{ __('wallet-stat.buy_exchange') }}</div>
                    <div class="text-base" title="@numberString($buy_exchange)">@number($buy_exchange)</div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.buy_value') }}</div>
                    <div class="text-base" title="@numberString($buy_value)">@number($buy_value)</div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.result') }}</div>
                    <div class="text-base {{ ($result >= 0) ? 'text-theme-10' : 'text-theme-24' }} font-bold">@number($result)</div>
                </div>
            </div>

            @if ($sell_stop_amount && $sell_stop_min_exchange && $sell_stop_min_exchange)

            <div class="flex flex-1 flex-wrap text-center p-2 border-t lg:border-t-0 lg:border-l border-gray-300 border-dashed">
                <div class="flex-1 p-2">
                    <div class="text-gray-600 text-xs"><a href="javascript:;" data-toggle="modal" data-target="#wallet-update-sell-stop-modal-{{ $row->id }}">{{ __('wallet-stat.sell_stop') }}</a></div>

                    <div class="flex items-center justify-center">
                        <div class="text-base {{ $sell_stop ? 'text-theme-10' : 'text-theme-24' }}">{{ $sell_stop ? __('wallet-stat.sell_stop_enabled') : __('wallet-stat.sell_stop_disabled') }}</div>
                    </div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.sell_stop_min_exchange') }} ({{ $sell_stop_min_percent }}%)</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $sell_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $sell_stop_min_at }}">@number($sell_stop_min_exchange)</div>

                        <div class="{{ ($sell_stop_min_exchange_percent >= 0) ? 'text-theme-10' : 'text-theme-24' }} flex text-xs font-medium">
                            <span>{{ $sell_stop_min_exchange_percent }}%</span>
                        </div>
                    </div>

                    @if ($sell_stop_min_value)

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.sell_stop_min_value') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $sell_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $sell_stop_amount }}x{{ $sell_stop_min_exchange }}">@number($sell_stop_min_value)</div>

                        <div class="{{ ($sell_stop_min_value_difference >= 0) ? 'text-theme-10' : 'text-theme-24' }} flex text-xs font-medium">
                            <span>@number($sell_stop_min_value_difference, 2)</span>
                        </div>
                    </div>

                    @endif

                    @if ($sell_stop_min_at)

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.sell_stop_min_at') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $sell_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $sell_stop_min_at }}">@datetime($sell_stop_min_at)</div>
                    </div>

                    @endif

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.sell_stop_reference') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2" title="{{ $sell_stop_reference }}">@number($sell_stop_reference)</div>
                    </div>
                </div>

                <div class="flex-1 p-2">
                    <div class="text-gray-600 text-xs">{{ __('wallet-stat.sell_stop_amount') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base" title="@numberString($sell_stop_amount)">@number($sell_stop_amount)</div>
                    </div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.sell_stop_min_exchange') }} ({{ $sell_stop_min_percent }}%)</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $sell_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $sell_stop_min_at }}">@number($sell_stop_min_exchange)</div>

                        <div class="{{ ($sell_stop_min_exchange_percent >= 0) ? 'text-theme-10' : 'text-theme-24' }} flex text-xs font-medium">
                            <span>{{ $sell_stop_min_exchange_percent }}%</span>
                        </div>
                    </div>

                    @if ($sell_stop_min_value)

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.sell_stop_min_value') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $sell_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $sell_stop_amount }}x{{ $sell_stop_min_exchange }}">@number($sell_stop_min_value)</div>
                        <div class="{{ ($sell_stop_min_value_difference >= 0) ? 'text-theme-10' : 'text-theme-24' }} flex text-xs font-medium">
                            <span>@number($sell_stop_min_value_difference, 2)</span>
                        </div>
                    </div>

                    @if ($sell_stop_min_at)

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.sell_stop_min_at') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $sell_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $sell_stop_min_at }}">@datetime($sell_stop_min_at)</div>
                    </div>

                    @endif

                    @endif
                </div>
            </div>

            @endif

            @if ($buy_stop_amount && $buy_stop_min_exchange && $buy_stop_min_exchange)

            <div class="flex flex-1 flex-wrap text-center p-2 border-t lg:border-t-0 lg:border-l border-gray-300 border-dashed">
                <div class="flex-1 p-2">
                    <div class="text-gray-600 text-xs"><a href="javascript:;" data-toggle="modal" data-target="#wallet-update-buy-stop-modal-{{ $row->id }}">{{ __('wallet-stat.buy_stop') }}</a></div>

                    <div class="flex items-center justify-center">
                        <div class="text-base {{ $buy_stop ? 'text-theme-10' : 'text-theme-24' }}">{{ $buy_stop ? __('wallet-stat.buy_stop_enabled') : __('wallet-stat.buy_stop_disabled') }}</div>
                    </div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.buy_stop_min_exchange') }} ({{ $buy_stop_min_percent }}%)</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $buy_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $buy_stop_min_at }}">@number($buy_stop_min_exchange)</div>
                        <div class="{{ ($buy_stop_min_exchange_percent <= 0) ? 'text-theme-24' : 'text-theme-10' }} flex text-xs font-medium">
                            <span>{{ $buy_stop_min_exchange_percent }}%</span>
                        </div>
                    </div>

                    @if ($buy_stop_min_value)

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.buy_stop_min_value') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $buy_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $buy_stop_amount }}x{{ $buy_stop_min_exchange }}">@number($buy_stop_min_value)</div>
                        <div class="{{ ($buy_stop_min_value_difference <= 0) ? 'text-theme-10' : 'text-theme-24' }} flex text-xs font-medium">
                            <span>@number($buy_stop_min_value_difference, 2)</span>
                        </div>
                    </div>

                    @endif

                    @if ($buy_stop_min_at)

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.buy_stop_min_at') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $buy_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $buy_stop_min_at }}">@datetime($buy_stop_min_at)</div>
                    </div>

                    @endif

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.buy_stop_reference') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2" title="{{ $buy_stop_reference }}">@number($buy_stop_reference)</div>
                    </div>
                </div>

                <div class="flex-1 p-2">
                    <div class="text-gray-600 text-xs">{{ __('wallet-stat.buy_stop_amount') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base" title="@numberString($buy_stop_amount)">@number($buy_stop_amount)</div>
                    </div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.buy_stop_min_exchange') }} ({{ $buy_stop_min_percent }}%)</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $buy_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $buy_stop_min_at }}">@number($buy_stop_min_exchange)</div>
                        <div class="{{ ($buy_stop_min_exchange_percent <= 0) ? 'text-theme-24' : 'text-theme-10' }} flex text-xs font-medium">
                            <span>{{ $buy_stop_min_exchange_percent }}%</span>
                        </div>
                    </div>

                    @if ($buy_stop_min_value)

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.buy_stop_min_value') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $buy_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $buy_stop_amount }}x{{ $buy_stop_min_exchange }}">@number($buy_stop_min_value)</div>
                        <div class="{{ ($buy_stop_min_value_difference <= 0) ? 'text-theme-10' : 'text-theme-24' }} flex text-xs font-medium">
                            <span>@number($buy_stop_min_value_difference, 2)</span>
                        </div>
                    </div>

                    @endif

                    @if ($buy_stop_min_at)

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.buy_stop_min_at') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $buy_stop_min_at ? 'text-theme-10' : '' }}" title="{{ $buy_stop_min_at }}">@datetime($buy_stop_min_at)</div>
                    </div>

                    @endif
                </div>
            </div>

            @endif

            @if ($sell_stoploss_exchange && ($current_value > 1))

            <div class="flex flex-1 flex-wrap text-center p-2 border-t lg:border-t-0 lg:border-l border-gray-300 border-dashed">
                <div class="flex-1 p-2">
                    <div class="text-gray-600 text-xs">{{ __('wallet-stat.sell_stoploss') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base {{ $sell_stoploss ? 'text-theme-10' : 'text-theme-24' }}">{{ $sell_stoploss ? __('wallet-stat.sell_stoploss_enabled') : __('wallet-stat.sell_stoploss_disabled') }}</div>
                    </div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.sell_stoploss_exchange') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $sell_stoploss_at ? 'text-theme-10' : '' }}" title="{{ $sell_stoploss_at }}">@number($sell_stoploss_exchange)</div>
                        <div class="{{ ($sell_stoploss_exchange_percent < 0) ? 'text-theme-24' : 'text-theme-10' }} flex text-xs font-medium">
                            <span>{{ $sell_stoploss_exchange_percent }}%</span>
                        </div>
                    </div>
                </div>

                <div class="flex-1 p-2">
                    <div class="text-gray-600 text-xs">{{ __('wallet-stat.sell_stoploss_amount') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base">@number($amount)</div>
                    </div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.sell_stoploss_value') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base {{ $sell_stoploss_at ? 'text-theme-10' : '' }}" title="{{ $amount }}x{{ $sell_stoploss_exchange }}">@number($sell_stoploss_value)</div>
                    </div>
                </div>
            </div>

            @endif

            @if ($buy_market_amount && $buy_market_exchange)

            <div class="flex flex-1 flex-wrap text-center p-2 border-t lg:border-t-0 lg:border-l border-gray-300 border-dashed">
                <div class="flex-1 p-2">
                    <div class="text-gray-600 text-xs"><a href="javascript:;" data-toggle="modal" data-target="#wallet-update-buy-market-modal-{{ $row->id }}">{{ __('wallet-stat.buy_market') }}</a></div>

                    <div class="flex items-center justify-center">
                        <div class="text-base {{ $buy_market ? 'text-theme-10' : 'text-theme-24' }}">{{ $buy_market ? __('wallet-stat.buy_market_enabled') : __('wallet-stat.buy_market_disabled') }}</div>
                    </div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.buy_market_exchange') }} ({{ $buy_market_percent }}%)</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base mr-2 {{ $buy_market_at ? 'text-theme-10' : '' }}" title="{{ $buy_market_at }}">@number($buy_market_exchange)</div>
                        <div class="{{ ($buy_market_exchange_percent < 0) ? 'text-theme-24' : 'text-theme-10' }} flex text-xs font-medium">
                            <span>{{ $buy_market_exchange_percent }}%</span>
                        </div>
                    </div>
                </div>

                <div class="flex-1 p-2">
                    <div class="text-gray-600 text-xs">{{ __('wallet-stat.buy_market_amount') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base">@number($buy_market_amount)</div>
                    </div>

                    <div class="text-gray-600 text-xs mt-2">{{ __('wallet-stat.buy_market_value') }}</div>

                    <div class="flex items-center justify-center">
                        <div class="text-base {{ $buy_market_at ? 'text-theme-10' : '' }}" title="{{ $buy_market_amount }}x{{ $buy_market_exchange }}">@number($buy_market_value)</div>
                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>
</div>

@include ('domains.wallet.molecules.wallet-update-buy-stop-modal')
@include ('domains.wallet.molecules.wallet-update-buy-market-modal')
@include ('domains.wallet.molecules.wallet-update-sell-stop-modal')
