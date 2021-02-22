<?php

function set_community(?array $match) {
    User::current_user()->current_community = $_POST['id'];
}
