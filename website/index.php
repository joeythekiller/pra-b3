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
                <h3>Afdeling 1</h3>