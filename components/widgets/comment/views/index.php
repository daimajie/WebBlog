<?php
use yii\helpers\Url;
?>


<!--reply-->
<div class="post-content comment" id="comment_form">
    <form>
        <div class="comment-form ">
            <p class="input-name"> 评论文章</p>
            <textarea id="comment_input" placeholder=""></textarea>
        </div>
        <div class="comment-submit">
            <a id="comment_btn" href="javascript:;" class="button">发射</a>
        </div>
    </form>
</div>
<!--/reply-->
<!--comment-->
<div id="comments" class="comments-area">
    <div class="comments-wrapper text-center"><b>Loading...</b></div>
</div>

<!--reply template-->
<script id="reply_tpl" type="text/html">
<div class="input-group input-group-sm reply-form">
    <input type="text" class="form-control" id="reply_input">
    <span class="input-group-addon btn btn-default" id="reply_btn">点击提交</span>
</div>
</script>
<!--comment template-->
<script id="comments_tpl" type="text/html">
    <div class="comments-wrapper">
        {{if comments}}
        <ol class="comment-list">
            {{each comments $val $key}}
            <li id="comment-{{$key}}">
                <article>
                    <div class="comment-avatar">
                        <img src="{{$val.user.image}}" alt="no image">
                    </div>
                    <div class="comment-body">
                        <div class="meta-data">
                            <span class="comment-author">{{$val.user.username}}</span>
                            <span class="comment-date">{{$val.created_at}}</span>
                        </div>
                        <div class="comment-content">
                            <p>{{$val.comment}}</p>
                        </div>
                        <div data-id="{{$val.id}}" data-comment_id="{{$val.id}}" class="reply-wrap">
                            <a class="reply-btn" href="javascript:void(0);">回复</a>
                            {{if $val['owner']}}
                            <a class="reply-del" href="javascript:void(0);">删除</a>
                            {{/if}}
                        </div>
                    </div>
                </article>
                <ol class="children">
                    {{each $val.replys $v $k}}
                    <li class="comment byuser comment-author-tommy odd alt depth-2" id="comment-17">
                        <article>
                            <div class="comment-avatar">
                                <img src="{{$v.user.image}}" alt="image">
                            </div>
                            <div class="comment-body">
                                <div class="meta-data">
                                    <span class="comment-author">{{$v.user.username}}</span>
                                    <span class="comment-date">{{$v.created_at}}</span>

                                </div>
                                <div class="comment-content">
                                    <p>{{$v.comment}}</p>
                                </div>
                                <div data-id="{{$v.id}}" data-comment_id="{{$val.id}}" class="reply-wrap">
                                    <a class="reply-btn" href="javascript:void(0);">回复</a>
                                    {{if $v['owner']}}
                                    <a class="reply-del" href="javascript:void(0);">删除</a>
                                    {{/if}}
                                </div>

                            </div>
                        </article>
                    </li>
                    {{/each}}
                </ol>
            </li>
            {{/each}}
        </ol>
        <div class="post-navigation">
            {{@pagination}}
        </div>
        {{else}}
        暂无评论，快来抢占沙发吧。
        {{/if}}
    </div>
</script>

<script>
    function refreshCommentList(content_id, url){
        var requestUrl = url || "<?= Url::to(['get-comments'])?>";

        $.ajax({
            url : requestUrl,
            type : 'POST',
            data : {content_id : content_id},
            success : function( d ){
                var html = template('comments_tpl',d);
                $('#comments').html(html);
            }
        });
    }

    function sendComment(content_id, comment_id, comment, commentUrl, input, currentPage){
        $.ajax({
            url : commentUrl,
            type : 'POST',
            data : {content_id : content_id, comment_id : comment_id, comment : comment},
            success : function( d ){
                if( d.errno === 1 ){
                    $(input).val('');
                    //刷新评论列表
                    refreshCommentList(content_id, currentPage);
                }
                //提交失败
                layer.msg( d.errmsg );
                return;
            }
        });
    }

</script>

<?php
$commentUrl = Url::to(['comment', 'type'=>'blog']);
$delCommentUrl = Url::to(['delete-comment', 'type'=>'blog']);
$content_id = $article['content']['id'];
$jsStr = <<<STR
//初始化评论列表
refreshCommentList({$content_id});
var currentPage;

//提交评论
$('#comment_btn').on('click', function(){
    var content_id = "{$content_id}";
    var comment_id = 0;
    var comment = $.trim($('#comment_input').val());
    var commentUrl = "{$commentUrl}";
    var input = $('#comment_input');

    if( comment.length <= 0 ) return;
    
    sendComment(content_id, comment_id, comment, commentUrl, input);
    
});

//显示回复框
$(document).on('click', 'a.reply-btn', function(){
    var that = $(this),
        html = $('#reply_tpl').html();
        
    $('.reply-form').remove();
    
    that.closest('.reply-wrap').append(html);
    
    return false;
});

//提交回复
$(document).on('click', '#reply_btn', function(){
    var wrap = $('.reply-wrap');
    var content_id = "{$content_id}";
    var comment_id = wrap.data('comment_id');
    var comment = $(this).siblings("#reply_input").val();
    var commentUrl = "{$commentUrl}";
    var input = $(this).siblings('#reply_input');
    
    if( comment.length <= 0 ) return;
    sendComment(content_id, comment_id, comment, commentUrl, input, currentPage);
    
});

//删除回复
$(document).on('click', '.reply-del', function(){
    var id = $(this).closest('.reply-wrap').data('id');
    var content_id = "{$content_id}";
    
    layer.confirm('您确定要删除该评论吗？', {
      btn: ['确定','取消']
    }, function(){
        $.ajax({
            url : "{$delCommentUrl}",
            type : "POST",
            data : {content_id : content_id, id : id},
            success : function(d){
                if(d.errno === 0){
                    //刷新评论列表
                    refreshCommentList({$content_id}, currentPage);
                }
                layer.msg(d.errmsg);
            }
        });
      
    });
    return false;
});

//ajax分页
$(document).on('click', '#pagination a', function(){
    //loading
    $('#comments').html('<div class="comments-wrapper text-center"><b>Loading...</b></div>');
    
    //anchor
    var top = $('#comment_form').offset().top;
        $(window).scrollTop(top);
    
    //request
    currentPage = $(this).attr('href');
    refreshCommentList({$content_id}, currentPage);
    
    return false;
});




STR;
$this->registerJs($jsStr);

?>