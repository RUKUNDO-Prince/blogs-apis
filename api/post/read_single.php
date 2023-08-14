<?php
    // HEADERS
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    include_once "../../config/Database.php";
    include_once "../../models/Post.php";

    // INSTANTIATE DB OBJECT & CONNECT
    $database = new Database();
    $db = $database -> connect();

    // INSTANTIATE BLOG POST OBJECT
    $post = new Post($db);

    // GET ID FROM URL
    $post -> id = isset($_GET["id"]) ? $_GET["id"] : die();

    // GET SINGLE POST
    $post -> read_single();

    // CREATE ARRAY
    $post_array = array(
        "id" => $post -> id,
        "title" => $post -> title,
        "body" => $post -> body,
        "author" => $post -> author,
        "category_id" => $post -> category_id,
        "category_name" => $post -> category_name
    );

    // MAKE JSON
    print_r(json_encode($post_array));
?>