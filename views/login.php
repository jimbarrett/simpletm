<?php

require('includes/head.php');

?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php 
                if($message) {
            ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $message; ?>
                    </div>
            <?php
                }
            ?>
            <div class="panel panel-primary" id="loginPanel">
                <div class="panel-heading text-center">You must be logged in to continue.</div>
                <div class="panel-body">
                    <?php 
                        if($error) {
                    ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $error; ?>
                        </div>
                    <?php
                        }
                    ?>
                    <form action="/login" method="POST">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required/>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Log In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 

require('includes/foot.php');

?>