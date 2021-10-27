<?php include("includes/admin_header.php") ?>
<?php
if (admin_logged_in()) {
    redirect("index.php");
}
?>
<?php include("includes/admin_navigation.php") ?>
<div class="row">
    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <?php display_message();  ?>
            <?php validasi_admin_login(); ?>
            <div class="panel panel-info">
                <div class="panel-heading">
                     <div class="panel-title text-center">Login Admin</div>
                </div>
                <div style="padding-top:30px" class="panel-body">
                    <div style="display:none" 
                            id="login-alert" 
                            class="alert alert-danger col-sm-12">
                    </div>
                    <form id="loginform" 
                            class="form-horizontal" 
                            role="form" 
                            method="post" 
                            role="form" 
                            style="display: block;">
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-user"></i>
                            </span>
                            <input type="text" 
                                class="form-control" 
                                name="admin_email" 
                                value="" placeholder="admin" required="required">
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-lock">
                                </i>
                            </span>
                            <input id="login-password" 
                                    type="password" 
                                    class="form-control" 
                                    name="password" 
                                    placeholder="password" 
                                    required="required">
                        </div>
                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                                <button id="btn-login" 
                                        type="submit" 
                                        class="btn btn-success">
                                        Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("includes/admin_footer.php") ?>