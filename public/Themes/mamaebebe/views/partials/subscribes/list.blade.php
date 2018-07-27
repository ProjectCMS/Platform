<div class="table-price">
    <div class="row">
        @foreach($subscribesCicles as $key => $item)
            @php
                $amount = explode(',', $item->amount);
            @endphp
            <div class="col-md-3">
                <div class="item">
                    <div class="price-title">{{ $item->title }}</div>
                    <div class="price">
                        <strong class="prefix">R$</strong>
                        <div class="amount">{{ $amount[0] }} <span>,{{ $amount[1] }}</span>
                        </div>
                        <p>/{{ $item->period->title }}</p>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('web.subscribes.plan', $item->id) }}" class="btn btn-outline-warning btn-block">Selecionar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>