$(document).ready(function() {
    $("a.voteButton").click(function(){
        var href = $(this).attr("href");
        href += " #voteLayer";
        $("#voteLayer").load(href, function(){ });

        return false;
    });
});