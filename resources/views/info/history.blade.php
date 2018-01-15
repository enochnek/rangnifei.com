@if (count($histories))

    <div class="box-zebra">
    @foreach($histories as $history)

        <div class="padding-md">
            <h4>第 {{ $history->item_history_season }} 赛季 &nbsp&nbsp&nbsp&nbsp<span class="sm grey">开始于{{ $history->item_history_start }} - 结束于 {{ $history->item_history_end }}</span></h4>

            <div class="box-horizon">
                <p class="md">参与人数: <strong class="blue">{{ $history->item_history_num }}</strong></p>
                <p class="md">赞助额度: <strong class="red">￥{{ $history->item_history_sum }}</strong></p>
            </div>

        </div>

    @endforeach
    </div>

    @endif