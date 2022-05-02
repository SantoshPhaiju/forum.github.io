<!-- Modal -->



<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login to iDiscuss</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/forum/partials/_handleLogin.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label"> Email </label>
                        <input type="email" class="form-control" id="loginEmail" name="loginEmail" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group my-2">
                        <label>Password</label>
                        <input type="password" name="loginPass" class="form-control" placeholder="" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <p class="my-2">Forget Password? <a href="recover_email.php">Click here</a></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


