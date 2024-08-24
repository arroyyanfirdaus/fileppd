<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>2024</span>
        </div>
    </div>
</footer>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form id="logout-form" action=".t" method="POST">
                    <input type="hidden" name="_token" value="CcBWaHLXLAI4BHyfGfL5lzDnGEoqba4PrUCvet6P"> <button
                        class="btn btn-primary" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../assets/dist/jquery/jquery.min.js"></script>
<script src="../assets/dist/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/dist/jquery.easing/jquery.easing.min.js"></script>