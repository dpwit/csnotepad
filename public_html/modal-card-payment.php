<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Credit Card Validation Demo</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets-card-payments/css/styles.css">
    <link rel="stylesheet" type="text/css" href="assets-card-payments/css/demo.css">
</head>

<body>
    <div class="container-fluid">
        
        <div class="creditCardForm">
            
            <div class="payment">
                <form>
                    <div class="form-group owner">
                        <label for="owner">Name on card</label>
                        <input type="text" class="form-control" id="owner">
                    </div>
                    <div class="form-group" id="card-number-field">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber">
                    </div>
                    <div class="form-group" id="expiration-date">
                        <label>Expiration Date</label>
                        <select>
                            <option value="01">January</option>
                            <option value="02">February </option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <select>
                            <option value="20"> 2020</option>
                            <option value="21"> 2021</option>
                            <option value="22"> 2022</option>
                            <option value="23"> 2023</option>
                            <option value="24"> 2024</option>
                            <option value="25"> 2025</option>
                            <option value="26"> 2026</option>
                            <option value="27"> 2027</option>
                        </select>
                    </div>
                    <div class="form-group CVV">
                        <label for="cvv">CVC</label>
                        <input type="text" class="form-control" id="cvv">
                    </div>
                    
                    <div class="form-group" id="credit_cards">
                        <img src="assets-card-payments/images/visa.jpg" id="visa">
                        <img src="assets-card-payments/images/mastercard.jpg" id="mastercard">
                        <img src="assets-card-payments/images/amex.jpg" id="amex">
                    </div>
                    <div class="form-group" id="pay-now">
                        <button type="submit" class="btn btn-default" id="confirm-purchase">Confirm</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="assets-card-payments/js/jquery.payform.min.js" charset="utf-8"></script>
    <script src="assets-card-payments/js/script.js"></script>
</body>

</html>
