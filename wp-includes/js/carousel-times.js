$(".content > div").hide();//you can ignore this
$(".carousel > a").live('click', function() {
    $(".content > div").hide();//hide all divs
    $(".content > div").eq($(this).index()).show();//display curresponding div to the clicked anchor
});