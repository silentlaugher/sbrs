<?php 
?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">E-SBRS</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                        <?php if(!isset($_SESSION['username'])): ?>
                            <li><a href="#about">About</a></li>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                            <li><a href="#contact">Contact</a></li>
                        <?php else: ?>
                            <li><a href="#">My Profile</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        <?php endif ?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
