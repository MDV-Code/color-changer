<?php

// Establish database connection to the SQL server -- Datenbankverbindung zum SQL-Server herstellen

// Variables with login and server information -- Variablen mit Login und Serverinformationen
$servername = "localhost";
$server_username = "root";
$server_passwort = "your_password";
$dbname = "your_databasename";

// Establish connection --  Verbindung herstellen
$conn = new mysqli($servername, $server_username, $server_passwort, $dbname);

// Check connection -- Verbindung pruefen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update color in the database -- Farbe in der Datenbank updaten
if (isset($_POST['color'])) {
	$color = $_POST['color'];
	$stmt = $conn->prepare("UPDATE colors SET rgb = ?");
	$stmt->bind_param("s", $color);
	
	// Execute SQL -- SQL ausführen
    $stmt->execute();

    // Optional: Check result -- Optionale: Ergebnis überprüfen
    if ($stmt->affected_rows > 0) {
        echo "Color successfully updated.";
    } else {
        echo "No changes made.";
    }
	
	// Close statement -- Statement schließen
    $stmt->close(); 
}
	


// Retrieve color from the database -- Farbe aus der Datenbank abrufen
$colors = "SELECT * FROM colors WHERE rgb IS NOT NULL";
$result_colors = $conn->query($colors);

?>

<!DOCTYPE html>
<html lang="en">
<head>

	<link rel="stylesheet" href="./css/rgb.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color-changer</title>
	
</head>

<style>

<?php

if ($result_colors->num_rows > 0) {
    while ($row_colors = $result_colors->fetch_assoc()) {
		// CSS output -- CSS-Ausgabe
        echo ".rgb { color: " . htmlspecialchars($row_colors["rgb"]) ."}"; 
    }
} else {
	// Error message if no colors are available -- Fehlermeldung, falls keine Farben vorhanden sind
    echo "No colors found."; 
}

?>
</style>
<body>

	<h1 class="rgb">The color of this text can be changed permanently.</h1>

	<form method="post">
		<input id="color" type="text" name="farbe" placeholder="Enter color">
		<input type="submit" name="" value="Change color">
	</form>
	
	<br>
	<p><b>Example</b> for the input options for the color red:
	<p>Als Text: <b>Red</b>
	<p>Als Hex: <b>#FF0000</b>
	<p>Als RGB: <b>rgb(255,0,0)</b>
	<br>
	<p><b>Oder:</b>

<div class="button-container">

	<form method="post">
		<input id="color" type="hidden" name="farbe" value="red">
		<input type="submit" name="" value="Red">
	</form>

	<form method="post">
		<input id="color" type="hidden" name="farbe" value="blue">
		<input type="submit" name="" value="Blue">
	</form>

	<form method="post">
		<input id="color" type="hidden" name="farbe" value="green">
		<input type="submit" name="" value="Green">
	</form>

	<form method="post">
		<input id="color" type="hidden" name="farbe" value="magenta">
		<input type="submit" name="" value="Magenta">
	</form>

</div>


</body>
</html>
