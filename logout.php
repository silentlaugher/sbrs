<?php 
    include_once 'core/session.php';
    include_once 'core/utilities.php';

    session_destroy();
    redirectTo('index');
?>