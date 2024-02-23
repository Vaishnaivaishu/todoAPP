<?php
include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_todo'])) {
    $todo_text = $_POST['todo_text'];

    $sql = "INSERT INTO todos (user_id, todo_text) VALUES ('$user_id', '$todo_text')";

    if ($conn->query($sql) === TRUE) {
        header("Location: tasks.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete_todo'])) {
    $todo_id = $_GET['delete_todo'];

    $sql = "DELETE FROM todos WHERE id='$todo_id' AND user_id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: tasks.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM todos WHERE user_id='$user_id'";
$result = $conn->query($sql);

if ($result === FALSE) {
    echo "Error fetching todos: " . $conn->error;
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #7995b5;
            margin: 0;
            padding: 0;
        }
    
        .task-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
    
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    
        .task-header h2 {
            margin: 0;
        }
    
        .task-form {
            display: flex;
        }
    
        .task-form input[type="text"] {
            flex: 1;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
    
        .task-form input[type="submit"] {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    
        .task-form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    
        .task-list {
            list-style-type: none;
            padding: 0;
        }
    
        .task-item {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
    
        .task-item span {
            flex: 1;
        }
    
        .task-item button {
            padding: 5px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    
        .task-item button:hover {
            background-color: #c82333;
        }
    </style>
    
</head>
<body>
    <div class="img">
    <div class="container">
    <div class="box">
              
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1><br>
        <h2>To-Do List:</h2><br>
        <form method="POST">
            <div class="input-group">
                <div class="input-field">
            <input type="text" name="todo_text" placeholder="Enter new task" required>
        </div>
<div class="input-field">
            <button type="submit" class="input-submit" name="add_todo">Add Todo</button>
</div>
            </div>
        </form>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>{$row['todo_text']} <a href=tasks.php?delete_todo={$row['id']}'>Delete</a></li>";
                }
            } else {
                echo "<li>No todos yet.</li>";
            }
            ?>
        </ul>
        <a href="logout.php">Logout</a>
    </div>
    </div>
    </div>
</body>
</html>
