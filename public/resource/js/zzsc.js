$(document).ready(function(){
	var $liCur = $(".menu ul .cur"),
	  curP = $liCur.position().left,
	  curW = $liCur.outerWidth(true),
	  $slider = $(".curBg"),
	  $navBox = $(".menu");
	 $targetEle = $(".menu ul li a"),
	$slider.animate({
	  "left":curP,
	  "width":90
	});
	$targetEle.mouseenter(function () {
	  var $_parent = $(this).parent(),
		_width = $_parent.outerWidth(true),
		posL = $_parent.position().left;
	  $slider.stop(true, true).animate({
		"left":posL,
		"width":_width
	  }, "fast");
	});
	$navBox.mouseleave(function (cur, wid) {
	  cur = curP;
	  wid = curW;
	  $slider.stop(true, true).animate({
		"left":cur,
		"width":wid
	  }, "fast");
	});
})
