<?php

function set_community(?string $match) {
    User::current_user()->current_community = $_POST['id'];
}
