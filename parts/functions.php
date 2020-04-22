<?php

function isConnected(){
    return isset($_SESSION['user']);
}