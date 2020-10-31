<?php
$url_encode=urlencode(get_permalink());
$title_encode=urlencode(get_the_title()).'｜'.get_bloginfo('name');
?>
<script type="text/javascript">
jQuery(function($){
	$('.sns-share li a').click(function(){
	window.open(this.href,'popup','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=800,height=300');
	return false;
	});
});
</script>
<div class="sns-share">
	<ul>
	<!--Facebook-->
	<li class="facebook">
		<a href="//www.facebook.com/sharer.php?src=bm&u=<?php echo $url_encode;?>&t=<?php echo $title_encode;?>">
			<i class="fa fa-facebook"></i><span> facebook</span>
    	</a>
	</li>
	<!--Twitter-->
	<li class="tweet">
		<a href="//twitter.com/intent/tweet?url=<?php echo $url_encode ?>&text=<?php echo $title_encode ?>&tw_p=tweetbutton">
			<i class="fa fa-twitter"></i><span> Twitter</span>
		</a>
	</li>
	<!--はてなブックマーク-->
	<li class="hatena">
		<a href="//b.hatena.ne.jp/entry/<?php echo $url_encode ?>">
			<i class="fa fa-hatena"></i><span> はてブ</span>
		</a>
	</li>
	<li class="line">
		<a href="//timeline.line.me/social-plugin/share?url=<?php echo $url_encode; ?>" title="LINEでシェアする">
			<i class="fa c-fa-line"></i><span> LINE</span>
		</a>
	</li>
	</ul>
</div>