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

    //  BLOG POST QUERY
    $result = $post -> read();

    // GET ROW COUNT
    $num = $result -> rowCount();

    // CHECK IF ANY POSTS
    if ($num > 0) {
        // POST ARRAY
        $posts_arr = array();
        $posts_arr["data"] = array();

        while ($row = $result -> fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $post_item = array(
                "id" => $id,
                "title" => $title,
                "body" => html_entity_decode($body),
                "author" => $author,
                "category_id" => $category_id,
                "category_name" => $category_name
            );

            // PUSH TO DATA
            array_push($posts_arr['data'], $post_item);
        }

        // TURN TO JSON & OUTPUT
        echo json_encode($posts_arr);
    } else {
        // NO POST
        echo json_encode(
            array("message" => "No Posts Found")
        );
    }
?>