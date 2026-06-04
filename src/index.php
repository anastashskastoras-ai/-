
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Σύστημα Διαχείρισης</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <nav>
        <a href="index.php">Αρχική (Προβολή)</a>
        <a href="add_customer.php">Νέος Πελάτης</a>
        <a href="add_order.php">Νέα Παραγγελία</a>
    </nav>

    <h2>Λίστα Παραγγελιών & Πελατών</h2>
    <table>
        <tr>
            <th>Πελάτης</th>
            <th>Email</th>
            <th>Προϊόν</th>
            <th>Ποσότητα</th>
            <th>Ημερομηνία</th>
        </tr>
        <?php
        $sql = "SELECT customers.name, customers.email, orders.product, orders.quantity, orders.order_date 
                FROM orders 
                JOIN customers ON orders.customer_id = customers.id
                ORDER BY orders.order_date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td>" . htmlspecialchars($row["email"]) . "</td>
                        <td>" . htmlspecialchars($row["product"]) . "</td>
                        <td>" . htmlspecialchars($row["quantity"]) . "</td>
                        <td>" . htmlspecialchars($row["order_date"]) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Δεν βρέθηκαν παραγγελίες.</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>