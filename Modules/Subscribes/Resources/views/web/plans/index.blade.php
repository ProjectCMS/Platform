<div class="table-price">
    <div class="row">
        @foreach($subscribesCicles as $key => $item)
            @php
            dump($item->toArray());
                $amount = explode(',', $item->amount);
            @endphp
            <div class="col-md-3">
                <div class="item">
                    <div class="price-title">{{ $item->title }}</div>
                    <div class="price">
                        <strong class="prefix">R$</strong>
                        <div class="amount">{{ $amount[0] }} <span>,{{ $amount[1] }}</span>
                        </div>
                        @if($item->period->days == 0)
                            <p>/eterno</p>
                        @elseif($item->period->days > 0 && $item->period->days <= 7)
                            <p>/semanal</p>
                        @else
                            <p>/mensal</p>
                        @endif
                    </div>
                    <div class="text-center">
                        <div class="btn btn-outline-warning btn-block">Selecionar</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>