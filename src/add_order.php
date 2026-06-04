<?php 
include 'db.php'; 

// Κατάλογος προϊόντων
$products_catalog = [
    "Βιομηχανικός Κινητήρας V8" => 2500,
    "Ανταλλακτικό Φίλτρο Αέρα" => 150,
    "Ιμάντας Μεταφοράς (10m)" => 320,
    "Δοχείο Λιπαντικού (50L)" => 85,
    "Πίνακας Αυτοματισμού" => 1200
];
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Νέα Παραγγελία - Premium UI</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* --- ΝΕΟ PREMIUM STYLING ΓΙΑ ΤΑ DROPDOWNS --- */
        .premium-label {
            font-size: 18px;
            color: #0056b3;
            margin-top: 20px;
            margin-bottom: 8px;
            display: block;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .premium-select {
            width: 100%;
            padding: 16px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            background-color: #fcfcfc;
            border: 2px solid #b3d4fc;
            border-radius: 10px;
            appearance: none; /* Κρύβει το εργοστασιακό βελάκι */
            /* Βάζουμε δικό μας όμορφο μπλε βελάκι (SVG) */
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%230056b3%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 15px top 50%;
            background-size: 16px auto;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .premium-select:hover {
            border-color: #0056b3;
            box-shadow: 0 6px 12px rgba(0,86,179,0.15);
            transform: translateY(-2px); /* Ανασηκώνεται ελαφρώς */
        }

        .premium-select:focus {
            outline: none;
            border-color: #28a745; /* Γίνεται πράσινο όταν το επιλέγεις */
            box-shadow: 0 0 0 4px rgba(40,167,69,0.2);
            background-color: #fff;
        }

        .premium-input {
            width: 100%;
            padding: 16px;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid #ddd;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .premium-input:focus {
            border-color: #17a2b8;
            outline: none;
            box-shadow: 0 0 0 4px rgba(23,162,184,0.2);
        }

        /* Υπόλοιπα Στυλ (Καλάθι κλπ) */
        .cart-section { margin-top: 40px; padding: 20px; background-color: #f8f9fa; border: 2px dashed #0056b3; border-radius: 12px; }
        .cart-table { width: 100%; margin-top: 15px; background: white; border-collapse: collapse; }
        .cart-table th, .cart-table td { padding: 12px; text-align: center; border: 1px solid #dee2e6; }
        .cart-table th { background-color: #0056b3; color: white; font-size: 16px; }
        .remove-btn { background-color: #dc3545; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: 0.2s;}
        .remove-btn:hover { background-color: #c82333; transform: scale(1.05); }
        .add-btn { background-color: #28a745; color: white; padding: 15px; border-radius: 8px; font-size: 18px; font-weight: bold; cursor: pointer; margin-top: 20px; width: 100%; border: none; transition: 0.3s; box-shadow: 0 4px 6px rgba(40,167,69,0.2);}
        .add-btn:hover { background-color: #218838; transform: translateY(-2px); }
        .total-box { margin-top: 20px; padding: 20px; background-color: #e9ecef; border-left: 6px solid #28a745; font-size: 22px; border-radius: 8px; text-align: right; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; font-weight: bold; font-size: 16px;}
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;}
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;}
    </style>
</head>
<body>
<div class="container">
    <nav>
        <a href="index.php">🏠 Αρχική (Προβολή)</a>
        <a href="add_customer.php">📋 Νέος Πελάτης</a>
        <a href="add_order.php">✉️ Νέα Παραγγελία</a>
    </nav>

    <h2 style="border-bottom: 2px solid #eee; padding-bottom: 10px;">Δημιουργία Παραγγελίας</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customer_id = (int)$_POST['customer_id'];
        $products = isset($_POST['products']) ? $_POST['products'] : [];
        $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];

        if (empty($products)) {
            echo "<div class='alert alert-danger'>❌ Το καλάθι είναι άδειο! Προσθέστε προϊόντα.</div>";
        } else {
            $success_count = 0;
            $errors = [];
            for ($i = 0; $i < count($products); $i++) {
                $product = $conn->real_escape_string($products[$i]);
                $quantity = (int)$quantities[$i];
                $sql = "INSERT INTO orders (customer_id, product, quantity) VALUES ($customer_id, '$product', $quantity)";
                if ($conn->query($sql) === TRUE) {
                    $success_count++;
                } else {
                    $errors[] = $conn->error;
                }
            }
            if (count($errors) == 0) {
                echo "<div class='alert alert-success'>✅ Η παραγγελία καταχωρήθηκε! Αποθηκεύτηκαν $success_count εγγραφές.</div>";
            } else {
                echo "<div class='alert alert-danger'>❌ Υπήρξαν σφάλματα.</div>";
            }
        }
    }
    ?>

    <form method="POST" action="add_order.php" id="orderForm" onsubmit="return validateCartSubmit()">
        
        <label class="premium-label">👤 1. Επιλογή Πελάτη</label>
        <select name="customer_id" id="customer_id" class="premium-select" required>
            <option value="">-- Πατήστε εδώ για επιλογή --</option>
            <?php
            $sql = "SELECT id, name FROM customers";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                }
            }
            ?>
        </select>
        
        <label class="premium-label">📦 2. Επιλογή Προϊόντος</label>
        <select id="productSelect" class="premium-select">
            <option value="" data-price="0">-- Πατήστε εδώ για κατάλογο --</option>
            <?php
            foreach ($products_catalog as $prod_name => $price) {
                echo "<option value='" . htmlspecialchars($prod_name) . "' data-price='$price'>" . htmlspecialchars($prod_name) . " - " . $price . "€</option>";
            }
            ?>
        </select>
        
        <label class="premium-label">🔢 3. Ποσότητα (Τεμάχια)</label>
        <input type="number" id="quantityInput" class="premium-input" min="1" value="1">
        
        <button type="button" class="add-btn" onclick="addToCart()">➕ Προσθήκη στο Καλάθι 🛒</button>

        <div class="cart-section">
            <h3 style="margin-top:0; color: #0056b3;">🛒 Το Καλάθι σας</h3>
            <table class="cart-table" id="cartTable">
                <thead>
                    <tr>
                        <th>Προϊόν</th>
                        <th>Ποσότητα</th>
                        <th>Τιμή</th>
                        <th>Σύνολο</th>
                        <th>Ενέργεια</th>
                    </tr>
                </thead>
                <tbody id="cartBody">
                    <tr><td colspan='5' style="color: #777;">Το καλάθι είναι άδειο. Επιλέξτε προϊόντα από πάνω.</td></tr>
                </tbody>
            </table>
            
            <div class="total-box">
                Γενικό Σύνολο: <strong style="color: #28a745;"><span id="grandTotal">0</span> €</strong>
            </div>
            
            <div id="hiddenInputsContainer"></div>

            <button type="submit" style="width: 100%; font-size: 20px; background-color: #0056b3; color: white; padding: 18px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 15px; transition: 0.3s;">🚀 Ολοκλήρωση Παραγγελίας</button>
        </div>
    </form>
</div>

<script>
// (Η JavaScript παραμένει ίδια, κάνει άψογα τη δουλειά της)
let cart = []; 
function addToCart() {
    let select = document.getElementById("productSelect");
    let qtyInput = document.getElementById("quantityInput");
    if (select.selectedIndex === 0) { alert("Παρακαλώ επιλέξτε προϊόν!"); return; }
    let name = select.value;
    let price = parseFloat(select.options[select.selectedIndex].getAttribute("data-price"));
    let qty = parseInt(qtyInput.value);
    if (qty < 1 || isNaN(qty)) { alert("Εισάγετε έγκυρη ποσότητα!"); return; }
    let existingItem = cart.find(item => item.name === name);
    if (existingItem) { existingItem.qty += qty; } else { cart.push({ name: name, price: price, qty: qty }); }
    select.selectedIndex = 0; qtyInput.value = 1; renderCart();
}
function removeFromCart(index) { cart.splice(index, 1); renderCart(); }
function renderCart() {
    let tbody = document.getElementById("cartBody");
    let hiddenContainer = document.getElementById("hiddenInputsContainer");
    let grandTotal = 0;
    tbody.innerHTML = ""; hiddenContainer.innerHTML = "";
    if (cart.length === 0) {
        tbody.innerHTML = "<tr><td colspan='5' style='color: #777;'>Το καλάθι είναι άδειο. Επιλέξτε προϊόντα από πάνω.</td></tr>";
        document.getElementById("grandTotal").innerText = "0"; return;
    }
    cart.forEach((item, index) => {
        let rowTotal = item.price * item.qty; grandTotal += rowTotal;
        let tr = `<tr><td>${item.name}</td><td>${item.qty}</td><td>${item.price} €</td><td><strong>${rowTotal} €</strong></td><td><button type="button" class="remove-btn" onclick="removeFromCart(${index})">🗑️ Αφαίρεση</button></td></tr>`;
        tbody.innerHTML += tr;
        hiddenContainer.innerHTML += `<input type="hidden" name="products[]" value="${item.name}">`;
        hiddenContainer.innerHTML += `<input type="hidden" name="quantities[]" value="${item.qty}">`;
    });
    document.getElementById("grandTotal").innerText = grandTotal.toLocaleString("el-GR");
}
function validateCartSubmit() {
    if (cart.length === 0) { alert("Δεν μπορείτε να ολοκληρώσετε άδεια παραγγελία. Προσθέστε κάτι στο καλάθι!"); return false; }
    return true;
}
</script>
</body>
</html>