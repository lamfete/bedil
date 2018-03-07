</div> <!-- container -->

<footer class="footer">
    <div class="container">
        <p class="text-muted">© lamfete 2018</p>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/bootstrap/js/docs.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

<!-- DataTables JavaScript
================================================== -->
<!--<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/responsive/1.0.2/js/dataTables.responsive.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/dataTables.responsive.js"></script>

<!-- nprogress script -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/nprogress/nprogress.js"></script>

<!-- My script -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/myscript.js"></script>

<script>

// Show the progress bar 
NProgress.start();

// Increase randomly
// var interval = setInterval(function() { NProgress.inc(); }, 1000);        

// Trigger finish when page fully loaded
// jQuery(window).load(function () {
//     clearInterval(interval);
//     NProgress.done();
// });

// // Trigger bar when exiting the page
// jQuery(window).unload(function () {
//     NProgress.start();
// });

NProgress.done();

</script>

</body>
</html>