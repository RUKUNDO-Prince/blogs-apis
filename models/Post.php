<?php
    class Post {
        // DB STUFF
        private $conn;
        private $table = "posts";

        // POST PROPERTIES
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        // CONSTRUCTOR WITH DB
        public function __construct ($db) {
            $this -> conn = $db;
        }

        // GET POSTS
        public function read () {
            // CREATE QUERY
            $query = "SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM " . $this -> table . " p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC";
            
            // PREPARE STATEMENT
            $stmt = $this -> conn -> prepare($query);

            // EXECUTE QUERY
            $stmt -> execute();

            return $stmt;
        }

        // GET SINGLE POST
        public function read_single () {
            // CREATE QUERY
            $query = "SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM " . $this -> table . " p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1";

            // PREPARE STATEMENT
            $stmt = $this -> conn -> prepare($query);

            // BIND ID
            $stmt -> bindParam(1, $this -> id);

            // EXECUTE QUERY
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            // FETCH PROPERTIES
            $this -> title = $row["title"];
            $this -> body = $row["body"];
            $this -> author = $row["author"];
            $this -> category_id = $row["category_id"];
            $this -> category_name = $row["category_name"];
        }

        // CREATE A POST
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);

            // Execute query
            if($stmt->execute()) {
            return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // UPDATE A POST
        public function update() {
            // Create query
            $query = 'UPDATE ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {
            return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

        // DELETE A POST
        public function delete () {
            // CREATE QUERY
            $query = "DELETE FROM " . $this -> table . " WHERE id = :id";

            // PREPARE STATEMENT
            $stmt = $this->conn->prepare($query);

            // CLEAN DATA
            $this->id = htmlspecialchars(strip_tags($this->id));

            // BIND DATA
            $stmt->bindParam(':id', $this->id);

            // EXECUTE QUERY
            if($stmt->execute()) {
                return true;
            }
            // PRINT ERROR
            printf("Error: %s.\n", $stmt->error);
            return false;   
        }
    }
?>