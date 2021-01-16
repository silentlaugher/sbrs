<?php 
    include_once 'core/session.php';
    include_once 'partials/headers.php';
    include_once 'partials/nav.php';
    $page_title = "Edynak Security Based Registration System - Homepage -";
?>
    <main role="main" class="container">

    <div class="flag">
        <h1>Edynak Security Based Registration System</h1>
        <p class="lead">Powered by EdySmart<br><br> All you get is a functional, feature loaded, secure registration and authentication system.</p><hr>
        <?php if(!isset($_SESSION['username'])): ?>
        <p class="lead">You are currently not signed in <a href="login.php">Log in</a> Not yet a member? <a href="register.php">Register here</a></p>
        <?php else: ?>
        <p class="lead">You are currently signed in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?> <a href="logout.php">Sign out</a></p>
        <?php endif ?>
    </div>
    <!-- js files -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<?php include_once 'partials/footers.php'; ?>