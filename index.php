<?php

$db = './storage/location.txt';

if (isset($_POST['update'])) {
    $floor = $_POST['floor'];
    $part = $_POST['part'];
    $desc = $_POST['desc'];

    $newLocation = "$floor - $part ($desc)";
    $newTime = date('Y/m/d H:i:s');

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
    <title>NimaKoo</title>
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans+Condensed:300|Questrial" rel="stylesheet">
    <style>
        body {
            padding: 5% 0;
            margin: 0;
        }

        aside {
            float: left;
            width: 50%;
        }

        main {
            font-family: "Open Sans Condensed", Arial, sans-serif;
            text-align: center;
            padding-top: 30px;
            float: right;
            width: 50%;
        }

        img {
            width: 100%;
            height: auto;
        }

        header {
            margin-bottom: 50px;
        }

        header h1 {
            font-family: "Lobster", Arial, sans-serif;
            font-size: 5rem;
            margin: 0;
        }

        article {
            margin-bottom: 50px;
            background-color: rgb(230, 230, 230);
            padding: 30px 0;
        }
    </style>
</head>
<body>

<aside>
    <img src="alt.png" alt="Nima">
</aside>

<main>
    <header>
        <h1>NimaKoo</h1>
        <p>Approximate location of Nima</p>
    </header>

    <article>
        <p>Last Nima has been seen:</p>
        <p><?php echo $location . ' @ ' . $time ?></p>
    </article>

    <form action="index.php" method="post">
        <p>Update location:</p>
        <select name="floor" title="Floor">
            <option>Floor 1</option>
            <option>Floor 2</option>
            <option>Floor 3</option>
            <option>Floor 4</option>
            <option>Floor 5</option>
            <option>Roof</option>
            <option>GF</option>
            <option>Out</option>
        </select>
        <select name="part" title="Part">
            <option>Coffee Machine</option>
            <option>WC</option>
            <option>Meeting Room</option>
            <option>Left Side</option>
            <option>Right Side</option>
            <option>Other</option>
        </select>
        <input type="text" name="desc" placeholder="Description" title="Description">
        <button type="submit" name="update">Update</button>
    </form>
</main>

</body>
</html>