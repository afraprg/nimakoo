<?php

$db = './storage/location.txt';

$floors = ['GF', 'Floor 1', 'Floor 2', 'Floor 3', 'Floor 4', 'Floor 5', 'Roof', 'Out'];
$parts = [
    'Sar-e Jash',
    'Coffee Machine',
    'Meeting Room',
    'Samt-e Chap',
    'Samt-e Raast',
    'Tah-e Tah',
    'Kenar-e Dar',
    'Tu Saf-e WC',
    'WC (Room be Divar)',
    'Posht-e Panjereh',
];

if (isset($_POST['update'])) {
    $floor = isset($_POST['floor']) ? strip_tags($_POST['floor']) : null;
    if (in_array($floor, $floors) == false) {
        exit("Bad Request!");
    }

    $part = isset($_POST['part']) ? strip_tags($_POST['part']) : null;
    if ($part && in_array($part, $parts) == false) {
        exit("Bad Request!");
    }

    $newLocation = $floor;
    if ($part) {
        $newLocation .= " ($part)";
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

        main footer {
            margin-top: 30px;
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
            <?php foreach ($floors as $floor) echo "<option>$floor</option>" ?>
        </select>
        <select name="part" title="Part">
            <option value="" selected>[Select Part]</option>
            <?php foreach ($parts as $part) echo "<option>$part</option>" ?>
        </select>
        <button type="submit" name="update">Update</button>
    </form>

    <footer>Copyleft &copy; <?php echo date('Y') ?> by people who usually look for Nima!</footer>
</main>

</body>
</html>