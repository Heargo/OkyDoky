<?php

function set_community(?array $match) {
    $_SESSION["current_community"] = (int) $_POST['id'];
}
