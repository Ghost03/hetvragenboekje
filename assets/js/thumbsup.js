 $(function()
{
    var thumb = $(".thumbs-up");

    thumb.hover( function()
    {
        $(this).attr("src", "assets/img/up-active.png");
    });

    thumb.mouseleave( function()
    {
        $(this).attr("src", "assets/img/up.png");
    });

    thumb.on("click", function() {
        
        var answer = $(this).parent().find('span').attr('data-answer');
        var question = $(this).parent().find('span').attr('data-question');
        var user = $(this).parent().find('span').attr('data-user');

        $(this).attr("src", "assets/img/up-active.png");

        $.ajax({
            url:'thumbsup',
            type:'get',
            data:{'a': answer, 'q' : question, 'u' : user},
            success: function (data) {
                var thumbsup = parseInt(thumb.parent().find('span').attr('data-thumb')) + 1;
                thumb.parent().find('span').html(thumbsup);
                location.reload();
            }
        });

    });
});