<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cars";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
   die("Połączenie z bazą danych się nie powiodło: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_brand = $_POST['car_brand'];
    $car_model = $_POST['car_model'];
    $car_color = $_POST['car_color'];
    $car_production_date = $_POST['car_production_date'];
    $car_first_registration_date = $_POST['car_first_registration_date'];

    if (empty($car_brand) || empty($car_model) || empty($car_color) || empty($car_production_date) || empty($car_first_registration_date)) {
        echo "Wszystkie pola są wymagane!";
    } elseif (strtotime($car_production_date) > strtotime($car_first_registration_date)) {
        echo "Data produkcji nie może być nowsza niż data pierwszej rejestracji!";
    } else {

        $production_year = date('Y', strtotime($car_production_date));
        $current_year = date('Y');
        $car_age = $current_year - $production_year;

        $sql = "INSERT INTO car (car_brand, car_model, car_color, car_production_date, car_first_registration_date, car_age)
                VALUES ('$car_brand', '$car_model', '$car_color', '$car_production_date', '$car_first_registration_date', $car_age)";
        if ($conn->query($sql) === TRUE) {
            echo "Nowy rekord został dodany pomyślnie!";
        } else {
            echo "Błąd: " . $sql . "<br>" . $conn->error;
        }
    }
 }
 $conn->close();
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj samochód</title>
</head>
<body>
<h1>Dodaj nowy samochód</h1>
<form method="POST" action="">
    <label for="car_brand">Marka:</label><br>
    <input type="text" name="car_brand" id="car_brand"><br><br>
    <label for="car_model">Model:</label><br>
    <input type="text" name="car_model" id="car_model"><br><br>
    <label for="car_color">Kolor:</label><br>
    <input type="text" name="car_color" id="car_color"><br><br>
    <label for="car_production_date">Data produkcji (YYYY-MM-DD):</label><br>
    <input type="date" name="car_production_date" id="car_production_date"><br><br>
    <label for="car_first_registration_date">Data pierwszej rejestracji (YYYY-MM-DD):</label><br>
    <input type="date" name="car_first_registration_date" id="car_first_registration_date"><br><br>
    <input type="submit" value="Zapisz">
</form>
</body>
</html>




