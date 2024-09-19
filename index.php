<?php
include './config/Database.php';

$database = new Database();
$db = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['long_url'])) {
    $url = $_POST['long_url'];

    $result = $database->insertUrl($url);

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

$urls = $database->getAllUrls();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL SHORTENER</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>URL Shortener</h1>
        <main>
            <section>
                <form action="" method="POST">
                    <input type="text" name="long_url" id="long_url" placeholder="eg: https://dotix.io/contact/">
                    <button type="submit" value="SHORTEN">Submit</button>
                </form>
            </section>

            <section class="urls">
                <?php foreach ($urls as $url) : ?>
                    <div class="url">
                        <div class="id"><?= $url['ID']; ?></div>
                        <div class="short_url">
                            <a href="http://localhost/r?c=<?= $url['ID']; ?>" target="_blank">
                                http://localhost/r?c=<?= $url['ID']; ?>
                            </a>
                        </div>
                        <div class="long_url">
                            <a href="<?= $url['long_url']; ?>" target="_blank"><?= $url['long_url']; ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </main>
    </div>
</body>

</html>