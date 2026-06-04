script.js
function validateCustomerForm() {
    let name = document.getElementById('name').value;
    let email = document.getElementById('email').value;
    
    if (name.trim() === "" || email.trim() === "") {
        alert("Παρακαλώ συμπληρώστε το όνομα και το email!");
        return false; 
    }
    return true; 
}

function validateOrderForm() {
    let customer = document.getElementById('customer_id').value;
    let product = document.getElementById('product').value;
    let quantity = document.getElementById('quantity').value;
    
    if (customer === "" || product.trim() === "" || quantity <= 0) {
        alert("Παρακαλώ επιλέξτε πελάτη, εισάγετε προϊόν και ποσότητα μεγαλύτερη του μηδενός.");
        return false;
    }
    return true;
}