<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h3>Upit za prodaju proizvoda</h3>

    <h4>Ime i prezime: <strong>{{ $cart_full_name }}</strong></h4>
    <h4>E-mail adresa: <strong>{{ $cart_email }}</strong></h4>
    <h4>Dodatna napomena:</h4>
    <p>{{ $cart_message_body }}</p>

    <hr>
    <div>
        <h4>Upit u vezi sljedećih proizvoda:</h4><br>
        {{ $cart_items }}
    </div>
</body>
</html>