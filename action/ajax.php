<?php

function set_community(?array $match) {
    $_SESSION["current_community"] = $_POST['id'];
}
