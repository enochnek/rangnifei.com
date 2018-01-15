<div class="dialog container-hg" style="top: 100px;" data-dialog="dialog">
        <div class="box depth-3 cmg-mdb">
            <div class="subw">
            <h4>历史公告</h4>
            <a href="javascript:;" id="close" onclick="$.cancel('dialog');" class="fright gt">×</a></div>
            <div class="vert-lg cmg-mdb auto">
                <ul>
                        @foreach ($announcements as $announcement)
                        <li>
                            <div class="bgr bgr-grey">
                                <p class="sm">{{$announcement->created_at}}
                                    @if($announcement->item_anno_private)
                                            <span class="grey tn">仅赞助人可见</span></p>
                                    @endif
                                </p>
                                <strong class="sm">{{$announcement->item_anno_content}}</strong>
                            </div>
                            <hr>
                        </li>
                            @endforeach
                </ul>
            </div>


            <div class="vertmg-sm">
                <i class="hr"></i>
            </div>
            @if($is)
            <strong class="bg">发布新公告</strong>
            <div class="subw">
                <input type="text" name="announcementContent" class="col-9">
                <button class="red" data-itemid="{{$itemid}}" name="publishAnnouncement">发布公告</button>
            </div>

            <div class="sub">
                <input name="private"  type="checkbox">
                <label for="private"> 内部公告 - 仅已赞助人可看到</label>
            </div>
                @endif
        </div></div>

<script>

    publishAnnouncement();

</script>