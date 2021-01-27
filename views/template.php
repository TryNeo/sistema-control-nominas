<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo company;?></title>
    <?php include "./views/code/style.php";?>
</head>
<body>

    <?php 
    
        $requestsAjax = false;
        require_once "./controllers/viewsControllers.php";
        $instance_controller_view = new viewsControllers();
        $views = $instance_controller_view->get_views_controller();
        if ($views == "login" || $views == "404"){
            require_once "./views/contents/".$views."-view.php";
        }else{
    ?>
    <div class="dashboard-main-wrapper">
        <?php include "./views/code/header.php"; ?>
        <?php include "./views/code/navbar.php"; ?>
        <?php include "./views/contents/dashboard-view.php"; ?>

    </div>
    <?php }
    include "./views/code/scripts.php"; ?>
</body>
</html>