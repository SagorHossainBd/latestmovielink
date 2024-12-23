<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Movie Link</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background animation */
        body {
            background: linear-gradient(135deg, #ff9a9e, #fad0c4, #a1c4fd, #c2e9fb);
            background-size: 300% 300%;
            animation: bg-animation 6s infinite alternate;
            font-family: 'Arial', sans-serif;
        }
        @keyframes bg-animation {
            0% { background-position: 0% 50%; }
            50% { background-position: 50% 50%; }
            100% { background-position: 100% 50%; }
        }

        /* Navbar */
        .navbar {
            background: rgba(0, 0, 0, 0.7);
        }
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #f4d03f !important;
        }

        /* Movie Card */
        .card img {
            width: 100%;
            height: auto;
            object-fit: contain;
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 5px;
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
        }
        .card-text {
            color: #555;
        }

        /* Footer */
        footer {
            background: rgba(0, 0, 0, 0.8);
            color: #ecf0f1;
            text-align: center;
            padding: 15px 0;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <?php include('db_connection.php'); ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">Latest Movie Link</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html">HOME</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Movie List -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Latest Movies</h1>
        <div class="row">
            <?php
            // Fetch movies securely
            $stmt = $conn->prepare("SELECT movie_name, genre, release_date, poster_url, download_link FROM movies");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='col-md-4 mb-4'>
                        <div class='card shadow'>
                            <img src='" . htmlspecialchars($row['poster_url']) . "' 
                                 class='card-img-top' 
                                 alt='" . htmlspecialchars($row['movie_name']) . " Poster' 
                                 onerror=\"this.src='default-poster.jpg';\">
                            <div class='card-body'>
                                <h5 class='card-title'>" . htmlspecialchars($row['movie_name']) . "</h5>
                                <p class='card-text'>Genre: " . htmlspecialchars($row['genre']) . "</p>
                                <p class='card-text'>Release Date: " . htmlspecialchars($row['release_date']) . "</p>
                                <a href='" . htmlspecialchars($row['download_link']) . "' class='btn btn-primary'>Download</a>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p class='text-center'>No movies found!</p>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-white py-3">
        <p>&copy; 2025 Latest Movie Link. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>