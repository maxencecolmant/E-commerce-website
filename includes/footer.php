  <script src="assets/static/dist/jquery/jquery.min.js"></script>
  <script src="assets/static/dist/semantic-ui/semantic.min.js"></script>
  <script>
    $(document)
    .ready(function() {
            // fix menu when passed
            $('.masthead')
            .visibility({
                once: false,
                onBottomPassed: function() {
                    $('.fixed.menu').transition('fade in');
                },
                onBottomPassedReverse: function() {
                    $('.fixed.menu').transition('fade out');
                }
            })
            ;

            // create sidebar and attach to menu open
            $('.ui.sidebar')
            .sidebar('attach events', '.toc.item')
            ;
        })
    ;
</script>
</body>
</html>
