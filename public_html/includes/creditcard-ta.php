<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Credit Card Validation Demo</title>
</head>

<body>
    <div class="container-fluid" style="background-color: #909090; padding: 10px 0 10px 0; width: 420px;">
    
        <div class="creditCardForm">
            
            <div class="payment">
                <form>
                    <div class="form-group owner" style="display: inline-flex; margin: 0 0 10px 10px;">
                        <label for="owner" style="color: #fff; display: inline-flex; font-size: 15px;width: 125px;">Name on the card</label>
                        <input type="text" class="form-control" id="owner" placeholder="Name as it appears on the card" name="cardName" required="">
                        <span id="errorName" style="font-size: 12px; color: red;"></span>
                    </div>
                    <div class="form-group" id="card-number-field" style="display: inline-flex; margin: 0 0 10px 10px;">
                        <label for="cardNumber"style="color: #fff; display: inline-flex; font-size: 15px;width: 125px;">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="1111 2222 3333 4444" required="" style="width: 135px">
                        <span id="errorNumber" style="font-size: 12px; color: red;"></span>
                    </div>
                    <div class="form-group" id="expiration-date" style="display: inline-flex; margin: 0 0 10px 10px;">
                        <label style="color: #fff; display: inline-flex; font-size: 15px;width: 125px;">Expiration Date</label>
                        <select name="cardExpMonth">
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
                        <select name="cardExpYear">
                            <option value="20"> 2020</option>
                            <option value="21"> 2021</option>
                            <option value="22"> 2022</option>
                            <option value="23"> 2023</option>
                            <option value="24"> 2024</option>
                            <option value="25"> 2025</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group CVV" style="display: inline-flex; margin: 0 0 10px 10px;">
                        <label for="cvv" style="color: #fff; display: inline-flex; font-size: 15px;width: 125px;">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cardCvc" placeholder="555" required="" style="width: 30px">
                        <span id="errorCvv" style="font-size: 12px; color: red;"></span>
                    </div>
                    <br>
                    <div class="form-group" id="credit_cards" style="display: inline-flex; margin: 0 0 10px 10px;">
                        <img src="assets/images/visa.jpg" id="visa" style="margin-right: 10px;">
                        <img src="assets/images/mastercard.jpg" id="mastercard" style="margin-right: 10px;">
                        <img src="assets/images/amex.jpg" id="amex" style="margin-right: 10px;">
                    </div>
                    <div class="form-group" id="pay-now" style="margin: 0 0 10px 10px;">
                        <button type="submit" class="btn btn-default" id="confirm-purchase">Check card details</button>
                        <span id="detailsCorrect" style="font-size: 12px; color: green;"></span>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.payform.min.js" charset="utf-8"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
