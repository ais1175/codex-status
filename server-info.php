<?php
require_once('./config.php');
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $serverIP . "/players.json");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$json;
$serverStatus = 0;

$output = curl_exec($curl);

if (curl_exec($curl) === false){
    $serverStatus = 1;
    echo '<script> console.log("Curl error: ' . curl_error($curl) . '")</script>';
} elseif (!empty(curl_exec($curl)) && !empty($output)) {
    $serverStatus = 2;
    $json = json_decode($output, TRUE, 512, JSON_BIGINT_AS_STRING);
} else {
    $serverStatus = 0;
    echo '<script> console.log("Curl error: ' . curl_error($curl) . '")</script>';
}

curl_close($curl);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Background color for the entire page */
            margin: 0;
            padding: 0;
        }

        .server-info-container {
            background-color: white; /* Background color for the server info container */
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .server-stat-title {
            margin-top: 20px;
        }

        .server-stat {
            padding: 10px;
            border-radius: 10px;
            margin: 10px;
            font-size: 18px;
            background-color: #f0f0f0; /* Background color for server info boxes */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Box shadow */
        }

        /* Style for the "Online Players" section */
        .online-players-container {
            background-color: #f0f0f0; /* Background color for online players container */
            margin-top: 20px;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Style for the "Online Players" text (without square box) */
        .online-players-text {
            color: #333; /* Text color for the "Online Players" text */
            font-size: 18px;
        }

        /* Style for player info boxes */
        .player-card {
            background-color: white; /* Background color for player info box */
            margin: 10px;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Style for player info text */
        .player-info {
            margin: 5px 0;
            font-size: 16px;
        }
    </style>
    <title>Server Info</title>
</head>
<body>
    <div class="server-info-container">
        <div class="server-stat-title"><h4>Server status:</h4></div>
        <?php if ($serverStatus === 2){ echo '<div class="server-stat ellipse-green">Online</div>'; } elseif ($serverStatus === 1) { echo '<div class="server-stat ellipse-red">Offline</div>'; } else { echo '<div class="server-stat ellipse-grey">Loading</div>'; } ?>
        <div class="server-stat-title"><h4>Online Players:</h4></div>
        <?php if ($serverStatus === 2){ echo '<div class="server-stat ellipse-indigo">' . count($json) . '</div>'; } else { echo '<div class="server-stat ellipse-grey">0</div>'; } ?>
        <div class="server-stat-title"><h4>IP Address:</h4></div>
        <!-- <div class="server-stat ellipse-grey"><?php echo $serverIP;?></div> -->
    </div>
    <?php
    if ($serverStatus === 2){
        echo '<div class="online-players-container">
                <div class="online-players-text"><h4>Online Players:</h4></div>
                <div class="player-card-container">';
        foreach ($json as $player) {
            echo '
                <div class="player-card">
                    <div class="player-info">ID: ' . $player['id'] . '</div>
                    <div class="player-info '; if ($player["ping"] <= 100){ echo 'ping-green'; } elseif ($player['ping'] >= 101 && $player['ping'] <= 200) { echo 'ping-yellow'; } else { echo 'ping-red'; } echo '">Ping: ' . $player['ping'] . '</div>
                    <div class="player-info">Name: ' . $player['name'] . '</div>
                </div>
            ';
        }
        echo '</div>
            </div>';
    }
    ?>
</body>
</html>
