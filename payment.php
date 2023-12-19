<?php
// Retrieve total price from URL parameter
$totalPrice = isset($_GET['totalPrice']) ? urldecode($_GET['totalPrice']) : 0.00;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    text-align: center;
    margin: 0;
}

.payment-form {
    max-width: 400px;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.heading-container {
    background-color: #ffc439;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
}

h1 {
    color: #003087;
    font-style: italic;
    margin: 0;
}

h1.paypal-heading {
    background-color: #ffc439;
    padding: 10px;
    border-radius: 8px;
    margin: 0;
}

label {
    display: block;
    margin-bottom: 8px;
    text-align: left;
    color: #333;
}

input, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 16px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

select {
    width: 100%;
}

button {
    background-color: #ffc439;
    color: #003087;
    padding: 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #e6b231;
}

#paymentStatus {
    margin-top: 20px;
    color: #003087;
}

.payment-total {
    color: #003087;
    font-style: italic;
    margin-top: 16px;
}

.container-div {
    display: flex;
    align-items: center;
    gap: 10px;
}

.container-div label {
    flex: 1;
    margin-right: 10px;
}

.container-div select {
    flex: 1;
}


    </style>
</head>
<body>

<div class="payment-form">
    <h1 class="paypal-heading">PAYPAL</h1>

    <p>Total Amount: $<?php echo number_format($totalPrice, 2); ?></p>

    <form id="creditCardForm" method="post" action="process_payment.php">
        <!-- Credit Card Number -->
        <label for="cardNumber">Card Number:</label>
        <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" required pattern="\d+" maxlength="16">


        <!-- Cardholder Name -->
        <label for="cardholderName">Cardholder Name:</label>
        <input type="text" id="cardholderName" name="cardholderName" placeholder="John Doe" required pattern="[A-Za-z ]+">
        <p id="cardholderNameError" style="color: red;"></p>

        <!-- Expiration Date -->
        <div style="display flex; align-items">
    <div>
        <label for="expiration_month">Expiration Date:</label>
        <select name="expiration_month" id="expiration_month" required>
            <?php
            for ($i = 1; $i <= 12; $i++) {
                $month = sprintf("%02d", $i);
                echo "<option value=\"$month\">$month</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <select name="expiration_year" id="expiration_year" required>
            <?php
            $currentYear = date("Y");
            for ($i = $currentYear; $i <= $currentYear + 10; $i++) {
                echo "<option value=\"$i\">$i</option>";
            }
            ?>
        </select>
    </div>
</div>



        <!-- Card Code (CVV) -->
        <label for="cardCode">Card Code (CVV):</label>
        <input type="text" id="cardCode" name="cardCode" placeholder="123" required pattern="\d+" maxlength="3">
        <p id="cardCodeError" style="color: red;"></p>

        <!-- Payment Status -->
        <input type="hidden" name="payment" value="success">

        <!-- Submit Button -->
        <button type="button" class="paypal-button" onclick="simulateCreditCardPayment()">Submit Payment</button>
    </form>
    <p id="paymentStatus"></p>
</div>


<script>
function simulateCreditCardPayment() {
    // Validate Cardholder Name
    const cardholderNameInput = document.getElementById("cardholderName");
    if (!validateCardholderName(cardholderNameInput)) {
        return; // Do not proceed with payment if validation fails
    }

    // Validate Card Code (CVV)
    const cardCodeInput = document.getElementById("cardCode");
    if (!validateCardCode(cardCodeInput)) {
        return; // Do not proceed with payment if validation fails
    }

    // Simulate a delay to mimic processing
    setTimeout(function() {
        // Update the payment status
        document.getElementById("paymentStatus").innerHTML = "Payment Successful! THANK YOU";

        // Redirect to cart.php after (1,2 seconds)
        setTimeout(function() {
            window.location.href = "cart.php";
        }, 1200);

    }, 1200);
}

// Validation for Cardholder 
document.getElementById("cardholderName").addEventListener("input", function() {
    validateCardholderName(this);
});

// Validation for Card Code (CVV)
document.getElementById("cardCode").addEventListener("input", function() {
    validateCardCode(this);
});

// Numeric input only for Card Number
document.getElementById("cardNumber").addEventListener("input", function() {
    this.value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
});

function validateCardholderName(input) {
    //check if input contains only letters and spaces
    if (!/^[A-Za-z ]+$/.test(input.value)) {
        document.getElementById("cardholderNameError").innerHTML = "Please enter only letters and spaces.";
        return false;
    } else {
        document.getElementById("cardholderNameError").innerHTML = "";
        return true;
    }
}

function validateCardCode(input) {
    // check if input contains only digits
    if (!/^\d+$/.test(input.value)) {
        document.getElementById("cardCodeError").innerHTML = "Please enter only numeric digits.";
        return false;
    } else {
        document.getElementById("cardCodeError").innerHTML = "";
        return true;
    }
}
</script>

</body>
</html>