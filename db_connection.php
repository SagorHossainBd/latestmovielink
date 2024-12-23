<?php
$servername = "sql302.infinityfree.com";
$username = "if0_37937217"; // Replace with your DB username
$password = "L0YKLcmznbOW5l"; // Replace with your DB password
$dbname = "if0_37937217_movies_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data to avoid SQL injection
    $movie_name = $conn->real_escape_string($_POST['movie_name']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $release_date = $conn->real_escape_string($_POST['release_date']);
    $poster_url = $conn->real_escape_string($_POST['poster_url']);
    $download_link = $conn->real_escape_string($_POST['download_link']);  // New field for download link

    // Prepare SQL query
    $sql = "INSERT INTO movies (movie_name, genre, release_date, poster_url, download_link) 
            VALUES (?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sssss", $movie_name, $genre, $release_date, $poster_url, $download_link);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<p class='text-center text-success'>Movie added successfully!</p>";
        } else {
            echo "<p class='text-center text-danger'>Error: " . $stmt->error . "</p>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<p class='text-center text-danger'>Error preparing statement: " . $conn->error . "</p>";
    }
}
?>