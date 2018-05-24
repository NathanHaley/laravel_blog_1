<footer class="blog-footer" style="margin-top: 3em;">
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="#" id="return-to-top">Back to top</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
            <div class="col">
            </div>
            <div class="col">
            </div>
        </div>
    </div>
    <p class="text-right small pb-0 mb-0" style="position: relative; bottom: -2em; right: 2em">&#169; 2018 Nathan Haley</p>
</footer>

@yield('scripts')
<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="/js/vendor/popper.min.js"></script>
<script src="/js/vendor/holder.min.js"></script>
<script>
    Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
    });

    $('#return-to-top').click(function() {
        $('body,html').animate({
            scrollTop : 0
        }, 500);
    });
</script>
</body>
</html>
