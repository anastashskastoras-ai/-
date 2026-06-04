<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Προσθήκη Πελάτη</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
<div class="container">
    <nav>
        <a href="index.php">Αρχική (Προβολή)</a>
        <a href="add_customer.php">Νέος Πελάτης</a>
        <a href="add_order.php">Νέα Παραγγελία</a>
    </nav>

    <h2>Καταχώρηση Νέου Πελάτη</h2>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Χρήση real_escape_string για βασική προστασία
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);

        $sql = "INSERT INTO customers (name, email, phone) VALUES ('$name', '$email', '$phone')";
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>Ο πελάτης καταχωρήθηκε επιτυχώς!</p>";
        } else {
            echo "<p style='color: red;'>Σφάλμα: " . $conn->error . "</p>";
        }
    }
    ?>

    <form method="POST" action="add_customer.php" onsubmit="return validateCustomerForm()">
        <label>Όνομα / Επωνυμία:</label>
        <input type="text" id="name" name="name" placeholder="π.χ. Βιομηχανία Α.Ε.">
        
        <label>Email:</label>
        <input type="email" id="email" name="email" placeholder="π.χ. info@company.gr">
        
        <label>Τηλέφωνο:</label>
        <input type="text" name="phone" placeholder="π.χ. 2101234567">
        
        <button type="submit">Αποθήκευση Πελάτη</button>
    </form>
</div>
</body>
</html>