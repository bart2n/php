<?php
require 'db.php';

// ---------------------------------------------------------------
// 1. Handle form submissions (POST requests)
// ---------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        if ($title !== '') {
            // The ? is a placeholder: never put user input directly into SQL.
            $stmt = $pdo->prepare('INSERT INTO todos (title) VALUES (?)');
            $stmt->execute([$title]);
        }
    } elseif ($action === 'toggle') {
        $stmt = $pdo->prepare('UPDATE todos SET done = NOT done WHERE id = ?');
        $stmt->execute([(int) $_POST['id']]);
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM todos WHERE id = ?');
        $stmt->execute([(int) $_POST['id']]);
    }

    // Redirect so refreshing the page doesn't submit the form again.
    header('Location: todos.php');
    exit;
}

// ---------------------------------------------------------------
// 2. Load all to-dos to display (GET request)
// ---------------------------------------------------------------
$todos = $pdo->query('SELECT * FROM todos ORDER BY created_at DESC')->fetchAll();

// Shortcut for safely printing text into HTML.
function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My To-Do List</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; }
        li { display: flex; align-items: center; gap: 8px; margin: 6px 0; }
        li span { flex: 1; }
        .done span { text-decoration: line-through; color: gray; }
        form { display: inline; }
    </style>
</head>
<body>
    <h1>My To-Do List</h1>

    <form method="post">
        <input type="hidden" name="action" value="add">
        <input type="text" name="title" placeholder="What do you need to do?" required autofocus>
        <button>Add</button>
    </form>

    <?php if (count($todos) === 0): ?>
        <p>Nothing to do yet. Add something above!</p>
    <?php else: ?>
        <ul>
            <?php foreach ($todos as $todo): ?>
                <li class="<?= $todo['done'] ? 'done' : '' ?>">
                    <form method="post">
                        <input type="hidden" name="action" value="toggle">
                        <input type="hidden" name="id" value="<?= $todo['id'] ?>">
                        <button><?= $todo['done'] ? '↩' : '✔' ?></button>
                    </form>
                    <span><?= e($todo['title']) ?></span>
                    <form method="post">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $todo['id'] ?>">
                        <button>✖</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
