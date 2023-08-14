<?php
    // HEADERS
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

    include_once "../../config/Database.php";
    include_once "../../models/Post.php";

    // INSTANTIATE DB OBJECT & CONNECT
    $database = new Database();
    $db = $database -> connect();

    // INSTANTIATE BLOG POST OBJECT
    $post = new Post($db);

    // GET POSTED DATA
    $data = json_decode(file_get_contents("php://input"));

    // SET ID TO DELETE
    $post -> id = $data -> id;

    // DELETE A POST
    if ($post -> delete()) {
        echo json_encode(
            array("message" => "Post Deleted!")
        );
    } else {
        echo json_encode(
            array("message" => "Post Not Deleted!")
        );
    }
?>