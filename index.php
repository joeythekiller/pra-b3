<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>website-pro-test</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>website pro</h1>
        <nav>
            <a href="extra/login.php">Inloggen</a>
            <a href="#">Dashboard</a>
            <a href="#settings">Instellingen</a>
        </nav>
    </header>


    <section id="settings"><button onclick="toggleDarkMode()">Donkere modus</button> </section>

    <?php
// Include database connection
require_once 'C:\laragon\www\website\backend\config.php';
require_once 'C:\laragon\www\website\backend\conn.php';

// Handle form submission
if (isset($_POST['submit_message'])) {
    $message = trim($_POST['message']);
    
    if (!empty($message)) {
        try {
            $stmt = $conn->prepare("INSERT INTO messages (message) VALUES (:message)");
            $stmt->bindParam(':message', $message);
            $stmt->execute();
            
            // Redirect to prevent form resubmission
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Get messages from database
$messages = [];
try {
    $stmt = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
<center>
    <title>Berichten Pagina</title>

</head>
<body>
    <h1>Berichten</h1>
    
    <button class="new-message-btn" onclick="toggleForm()">Nieuw Bericht</button>
    
    <div id="messageForm" class="message-form">
        <form method="post" action="">
            <textarea name="message" placeholder="Type uw bericht hier..." required></textarea>
            <button type="submit" name="submit_message">Versturen</button>
            <button type="button" onclick="toggleForm()">Annuleren</button>
        </form>
    </div>
    
    <div class="messages">
        <?php if (count($messages) > 0): ?>
            <?php foreach ($messages as $message): ?>
                <div class="message-box">
                    <div class="message-date"><?php echo date('d-m-Y H:i', strtotime($message['created_at'])); ?></div>
                    <div><?php echo nl2br(htmlspecialchars($message['message'])); ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Er zijn nog geen berichten.</p>
        <?php endif; ?>
    </div>

    </center>
    <script>
        function toggleForm() {
            var form = document.getElementById('messageForm');
            if (form.style.display === 'block') {
                form.style.display = 'none';
            } else {
                form.style.display = 'block';
            }
        }
    </script>
</body>
</html>

    
   <!-- Dashboard -->
    <section id="dashboard">
        <h2>Dashboard</h2>
        <div class="board">
            <div class="column">
                <h3>Afdeling 1</h3>
                <ul>
                    <li>Taak 1</li>
                    <li>Taak 2</li>
                </ul>
            </div>
            <div class="column">
                <h3>Afdeling 2</h3>
                <ul>
                    <li>Taak 3</li>
                    <li>Taak 4</li>
                </ul>
        </div>
        </div>
    </section>

  
    <section id="afdelingen">
        <h2>Afdelingen</h2>
        <div class="afdelingen-list">
            <div class="afdeling">
                <h3>Afdeling 1</h3> /* margin-top: blablabla;