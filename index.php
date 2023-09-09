<?php
include('./config.php');
error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="FiveM CodeX">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: <?php echo $backgroundColor; ?>;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: <?php echo $headerBackgroundColor; ?>;
            color: <?php echo $headerTextColor; ?>;
            padding: 20px 0;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: fadeInDown 1s ease 0.5s both;
        }

        .logo {
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100px;
            margin: 0 auto;
            animation: fadeIn 1s ease 1.5s both;
        }

        .main-content {
            background-color: <?php echo $contentBackgroundColor; ?>;
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: popIn 0.5s ease 2.5s both;
        }

        .server-stat-title {
            margin-top: 20px;
        }

        .server-stat {
            padding: 10px;
            border-radius: 10px;
            margin: 10px;
            font-size: 18px;
            background-color: <?php echo $serverInfoBoxBackgroundColor; ?>;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Add fading effect for buttons */
        .buttons {
            display: flex;
            align-items: center;
            animation: fadeInOut 2s ease 3s both alternate infinite;
        }

        .button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            margin: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .button:hover {
            background-color: <?php echo $buttonHoverBackgroundColor; ?>;
        }

        .server-info-link {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        /* Discord image button */
        .discord-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: transparent;
            border: none;
            cursor: pointer;
            width: 48px;
            height: 48px;
            z-index: 1001;
        }

        .discord-button img {
            display: block;
            width: 100%;
            height: 100%;
        }

        /* Discord iframe container */
        .discord-iframe-container {
            position: fixed;
            top: 0;
            right: -350px;
            width: 350px;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            transition: right 0.5s ease;
        }

        .discord-iframe {
            width: 100%;
            height: 100%;
        }

        /* Keyframe animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes popIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeInOut {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
    </style>
    <title>Server Info</title>
</head>
<body>
    <div class="header">
        <div class="buttons">
            <a href="<?php echo $websiteLink; ?>" class="button"><?php echo $websiteButtonText; ?></a>
        </div>
        <a href="<?php echo $serverJoinLink; ?>" target="_blank">
            <img class="logo" src="<?php echo $logoPath; ?>" alt="Logo">
        </a>
        <div class="buttons">
            <a href="<?php echo $discordLink; ?>" class="button"><?php echo $discordButtonText; ?></a>
        </div>
    </div>
    <div class="main-content">
        <section class="server-info" id="server-status">
            <a href="<?php echo $serverInfoLink; ?>" class="server-info-link">
                <div class="server-stat-title"><h4>Server status:</h4></div>
                <div class="server-stat">Loading</div>
            </a>
            <div class="server-stat-title"><h4>Online Players:</h4></div>
            <div class="online-players">
                <div class="server-stat">0</div>
            </div>
            <div class="server-stat-title"><h4>IP Address:</h4></div>
            <div class="server-stat"><?php echo $serverIP; ?></div>
        </section>
    </div>
    <!-- Discord image button -->
    <div class="discord-button" id="discordButton">
        <img src="<?php echo $discordIconPath; ?>" alt="Discord">
    </div>
    <!-- Discord iframe container -->
    <div class="discord-iframe-container" id="discordContainer">
        <div class="discord-iframe">
            <iframe src="<?php echo $discordWidgetURL; ?>" width="<?php echo $discordIframeWidth; ?>" height="<?php echo $discordIframeHeight; ?>" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
        </div>
    </div>

    <script>
        const discordButton = document.getElementById('discordButton');
        const discordContainer = document.getElementById('discordContainer');

        let discordVisible = false;

        discordButton.addEventListener('click', () => {
            if (!discordVisible) {
                discordContainer.style.right = '0';
            } else {
                discordContainer.style.right = '<?php echo $discordIframeRight; ?>px';
            }
            discordVisible = !discordVisible;
        });
    </script>
</body>
</html>
<script>
$(document).ready(function() {
    $("#server-status").load("<?php echo $serverInfoScript; ?>");
    var intervalId = window.setInterval(function() {
        $("#server-status").load("<?php echo $serverInfoScript; ?>");
    }, <?php echo $updateFrequency; ?>);
});
</script>
