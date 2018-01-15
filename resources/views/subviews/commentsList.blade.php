@foreach($comments as $comment)

<div class="pd-md">

    <div class="chori fwidth">
        <img class="avatar mg-rmd" src="{{ $comment->user->avatar }}">
        <div style="width: 600px;">
            <p class="nop bold">{{ $comment->user->username }}<span class="greyf fright">{{ $comment->created_at }}</span></p>
            <p class="nop twoline">{{ $comment->item_comment_content }}</p>
        </div>
    </div>
</div>

@endforeach
<div class="tcdPageCode fright">
</div>

<div class="pd-md">

    <div class="chori fwidth">
        <img class="avatar mg-rmd" src="images/default.jpg">
        <div style="width: 600px;">
            <p class="nop bold">username<span class="greyf fright">2017-02-02 16:40:30</span></p>
            <p class="nop twoline">text content</p>
        </div>
    </div>
</div>
