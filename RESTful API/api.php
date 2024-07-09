Step 3: RESTful API (api.php)
Create a file named api.php to handle the API requests.


<?php
header("Content-Type: application/json");

include 'db.php';

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        // Retrieve items
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            get_item($id);
        } else {
            get_items();
        }
        break;
    case 'POST':
        // Insert item
        insert_item();
        break;
    case 'PUT':
        // Update item
        $id = intval($_GET["id"]);
        update_item($id);
        break;
    case 'DELETE':
        // Delete item
        $id = intval($_GET["id"]);
        delete_item($id);
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_items() {
    global $conn;
    $query = "SELECT * FROM items";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($response);
}

function get_item($id) {
    global $conn;
    $query = "SELECT * FROM items WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $response = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($response);
}

function insert_item() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    $title = $data["title"];
    $description = $data["description"];
    $query = "INSERT INTO items (title, description) VALUES (:title, :description)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    if ($stmt->execute()) {
        $response = array('status' => 1, 'status_message' => 'Item Added Successfully.');
    } else {
        $response = array('status' => 0, 'status_message' => 'Item Addition Failed.');
    }
    echo json_encode($response);
}

function update_item($id) {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    $title = $data["title"];
    $description = $data["description"];
    $completed = $data["completed"];
    $query = "UPDATE items SET title = :title, description = :description, completed = :completed WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':completed', $completed);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        $response = array('status' => 1, 'status_message' => 'Item Updated Successfully.');
    } else {
        $response = array('status' => 0, 'status_message' => 'Item Updation Failed.');
    }
    echo json_encode($response);
}

function delete_item($id) {
    global $conn;
    $query = "DELETE FROM items WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        $response = array('status' => 1, 'status_message' => 'Item Deleted Successfully.');
    } else {
        $response = array('status' => 0, 'status_message' => 'Item Deletion Failed.');
    }
    echo json_encode($response);
}
?>
