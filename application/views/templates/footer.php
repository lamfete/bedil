</div> <!-- container -->

<footer class="footer">
    <div class="container">
    <p class="text-muted">Place sticky footer content here.</p>
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
<script type="text/javascript" src="assets/DataTables/DataTables-1.10.16/js/jquery.dataTables.js"></script>
<!-- <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script> -->

<script>
$(document).ready(function() {
    
    $('#table_user').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true,
        "searching": true,
        "ajax": {
            url: '<?php echo base_url('userexec/get_user'); ?>',
            type: 'POST'
        }
    });
} );
</script>

</body>
</html>