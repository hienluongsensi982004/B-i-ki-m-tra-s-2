<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">PHP Example</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        <a class="nav-link" href="connect.php">Connect MySQL</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-3">
        <nav class="alert alert-primary" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
            aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách khóa học</li>
            </ol>
        </nav>

        <?php
        session_start();

        if (isset($_SESSION['server']) && isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['database'])) {
            $server = $_SESSION['server'];
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
            $database = $_SESSION['database'];

            // Kết nối tới database
            $conn = new mysqli($server, $username, $password, $database);

            // Kiểm tra kết nối
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Lấy danh sách các khóa học
            $sql = "SELECT * FROM courses";
            $result = $conn->query($sql);
        }
        ?>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="col">
                        <div class="card h-100">
                            <img src="' . $row['imageUrl'] . '" class="card-img-top" alt="Course Image">
                            <div class="card-body">
                                <h5 class="card-title">' . $row['title'] . '</h5>
                                <p class="card-text">' . $row['description'] . '</p>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="alert alert-warning">Không tìm thấy khóa học nào.</div>';
            }
            ?>
        </div>

        <hr>

        <form class="row" method="POST" enctype="multipart/form-data">
            <div class="col">
                <div class="form-floating mb-3">
                    <input value="data" type="text" class="form-control" id="filename" placeholder="File name" name="filename">
                    <label for="filename">Tên file</label>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Ghi file</button>
            </div>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $filename = $_POST['filename'] . ".txt";
            $content = "Danh sách khóa học:\n";

            // Lấy danh sách các khóa học
            $sql = "SELECT title, description FROM courses";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $content .= "Tên khóa học: " . $row['title'] . "\nMô tả: " . $row['description'] . "\n\n";
                }
            } else {
                $content .= "Không có khóa học nào.\n";
            }

            // Ghi nội dung vào file
            file_put_contents($filename, $content);
            echo '<div class="alert alert-success">Ghi file thành công: ' . $filename . '</div>';
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
