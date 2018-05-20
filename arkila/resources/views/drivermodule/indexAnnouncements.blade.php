
<script>
    $(".see-more").click(function() {
        $(".announcement-title").text($(this).data("title"));
        $(".announcement-body").text($(this).data("announcement"));
    });
</script>