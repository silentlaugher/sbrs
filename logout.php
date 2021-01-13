<?php 
    include_once 'core/session.php';

    session_destroy();
    redirectTo('index');
?>