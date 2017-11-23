<?php

include_once("function.php");
include_once("../config/PDO_config.php");
if (!FuncClient_IsLogin()) {
    FuncClient_LocationLogin();
}


//$buy_id = $_GET['id'];



var_dump($_POST);