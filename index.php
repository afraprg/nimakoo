<?php

$db = './storage/location.txt';

if (isset($_POST['update'])) {
    $floor = isset($_POST['floor']) ? strip_tags($_POST['floor']) : '';
    $part = isset($_POST['part']) ? strip_tags($_POST['part']) : '';
    $desc = isset($_POST['desc']) ? strip_tags($_POST['desc']) : '';

    if (empty($floor) || strlen($floor) > 16 || strlen($part) > 32 || strlen($desc) > 32) {
        exit("Bad Request!");
    }

    $newLocation = $floor;
    if ($part) {
        $newLocation .= " - $part";
    }
    if ($desc) {
        $newLocation .= " ($desc)";
    }

    try {
        $date = new DateTime("now", new DateTimeZone('Asia/Tehran'));
        $newTime = $date->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        exit('Internal error.');
    }

    $data = "$newTime,$newLocation";
    file_put_contents($db, $data);
}

$content = file_get_contents($db);
$separator = strpos($content, ',');
$time = substr($content, 0, $separator);
$location = substr($content, $separator + 1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Approximate location of Nima">
    <title>NimaKoo | Approximate location of Nima</title>
    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: "Courier New", Arial, sans-serif;
            min-width: 800px;
        }

        aside {
            float: left;
            width: 50%;
        }

        aside img {
            width: 100%;
            height: auto;
        }

        main {
            text-align: center;
            padding-top: 30px;
            float: right;
            width: 50%;
        }

        main header {
            margin-bottom: 50px;
        }

        main header h1 {
            font-size: 5rem;
            margin: 0;
        }

        main article {
            margin-bottom: 50px;
            background-color: rgb(230, 230, 230);
            padding: 30px 0;
        }

        main article address {
            font-weight: bold;
        }

        main form {
            font-size: 16px;
        }
    </style>
</head>
<body>

<aside>
    <img src="nima.jpg" alt="Nima">
</aside>

<main>
    <header>
        <h1>NimaKoo</h1>
        <p>Approximate location of Nima</p>
    </header>

    <article>
        <p>Last Nima has been seen:</p>
        <address><?php echo $location . ' @ ' . $time ?></address>
    </article>

    <form action="index.php" method="post">
        <p>Update location:</p>
        <select name="floor" title="Floor" required>
            <option value="" disabled selected>[Select Floor]*</option>
            <option>GF</option>
            <option>Floor 1</option>
            <option>Floor 2</option>
            <option>Floor 3</option>
            <option>Floor 4</option>
            <option>Floor 5</option>
            <option>Roof</option>
            <option>Out</option>
        </select>
        <select name="part" title="Part">
            <option value="" disabled selected>[Select Part]</option>
            <option>Coffee Machine</option>
            <option>Meeting Room</option>
            <option>Samte Chap</option>
            <option>Samte Raast</option>
            <option>WC (Room be divar)</option>
            <option value="">Other</option>
        </select>
        <input type="text" name="desc" placeholder="Description" title="Description">
        <button type="submit" name="update">Update</button>
    </form>
</main>

</body>
</html>