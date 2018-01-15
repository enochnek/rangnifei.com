<div class="dialog depth-3 col-3" style="top: 100px; height: 520px; opacity: 1;" data-dialog="dialog">
    <a href="javascript:;" id="close" onclick="$.cancel('dialog');" class="fright gt">×</a>
    <div class="cmg-mdb">
        <h4>修改状态</h4>
        <p class="md">当前状态: <strong class="red">{{$currentStatus}}</strong></p>
        <select name="status" data-itemid="{{$itemid}}" class="col-8">
            <option value="0">请选择更改状态</option>
            <option value="1">可参与</option>
            {{--<option value="2">已完成(可参与)</option>--}}
            {{--<option value="3">已完成</option>--}}
            <option value="4">已暂停</option>
            <option value="5">已结束</option>
            <option value="6">新赛季预热</option>
        </select>
        <button class="red" name="saveStatus">保存</button>

        <h4>状态说明</h4>
        <p class="sm">审核中: 该项目正在审核, 审核通过后变为正常可参与状态</p>
        <p class="sm">正常可参与: 项目接受任何的赞助, 并会展示在推荐页面</p>
        <p class="sm">暂停项目: 暂时不接受赞助, 并无法展示在首页中... 最大暂停15天, 15天未恢复正常, 项目自动变为结束状态</p>
        <p class="sm">已完成(可参与): 众筹赛类型已达到目标金额, 但仍可以接受赞助</p>
        <p class="sm">已完成: 众筹赛类型已达到目标金额, 无法接受赞助, 即将结算</p>
        <p class="sm">已结束: 项目该赛季已结束, 结束当天起需等待3天才能重新开启新赛季</p>
        <p class="sm">新赛季预热: 项目预热, 无法赞助但会展示在推荐列表, 预热最大7天, 7天为恢复正常, 项目自动变为结束状态</p>
    </div>
</div>
<script>initUpdate();</script>