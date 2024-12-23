<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('db_connection.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center">Add New Movie</h1>
        <form action="add_movie.php" method="POST">
            <div class="mb-3">
                <label for="movie_name" class="form-label">Movie Name</label>
                <input type="text" class="form-control" id="movie_name" name="movie_name" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
            </div>
            <div class="mb-3">
                <label for="release_date" class="form-label">Release Date</label>
                <input type="date" class="form-control" id="release_date" name="release_date" required>
            </div>
            <div class="mb-3">
                <label for="poster_url" class="form-label">Poster URL</label>
                <input type="text" class="form-control" id="poster_url" name="poster_url" required>
            </div>
            <div class="mb-3">
                <label for="download_link" class="form-label">Download Link</label>
                <input type="text" class="form-control" id="download_link" name="download_link" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Movie</button>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // স্যানিটাইজড ডাটা
        $movie_name = htmlspecialchars($_POST['movie_name']);
        $genre = htmlspecialchars($_POST['genre']);
        $release_date = htmlspecialchars($_POST['release_date']);
        $poster_url = htmlspecialchars($_POST['poster_url']);
        $download_link = htmlspecialchars($_POST['download_link']);

        // ডুপ্লিকেট চেক
        $sql_check = "SELECT * FROM movies WHERE movie_name = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $movie_name);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "<p class='text-center text-warning'>This movie already exists in the database!</p>";
        } else {
            // নতুন ডাটা যোগ করা
            $sql = "INSERT INTO movies (movie_name, genre, release_date, poster_url, download_link) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $movie_name, $genre, $release_date, $poster_url, $download_link);

            if ($stmt->execute()) {
                echo "<p class='text-center text-success'>Movie added successfully!</p>";
            } else {
                echo "<p class='text-center text-danger'>Error: " . $stmt->error . "</p>";
            }
            $stmt->close();
        }
        $stmt_check->close();
    }
    ?>

    <footer class="text-center bg-dark text-white py-3">
        <p>&copy; 2025 Latest Movie Link. All rights reserved.</p>
    </footer>
</body>
</html>