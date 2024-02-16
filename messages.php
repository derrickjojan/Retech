<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

session_start();

$qry = mysqli_query($conn, "SELECT * FROM `tbl_message`");


if (isset($_POST['delete_message'])) {
    $emailToDelete = $_POST['email'];

    // Perform the SQL query to delete the message based on the email
    $deleteQuery = "DELETE FROM tbl_message WHERE email = '$emailToDelete'";
    $result = mysqli_query($conn, $deleteQuery);

    if ($result) {
        // Message deleted successfully
        header('Location: messages.php'); // Redirect back to the messages page
        exit();
    } else {
        // Handle the error
        echo "Error deleting message: " . mysqli_error($conn);
    }
}

?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us Chat</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;700&amp;display=swap");
        @import url("https://fonts.googleapis.com/css2?family=VT323&amp;display=swap");

        * {
            box-sizing: border-box;
            position: relative;
        }

        html,
        body {
            --colors-bg--300: #1e181e;
            --colors-primary--500: #e8615a;
            --colors-secondary--500: #2be4ea;
            --colors-tertiary--500: #fed33f;
            --colors-on_bg--500: var(--colors-primary--500);
            --colors-on_tertiary--500: var(--colors-bg--300);
            --fonts-primary: "Rajdhani", sans-serif;
            --fonts-secondary: "VT323", monospace;
            --ui-glow: 0 0 5px var(--colors-primary--500);
            --ui-glow-borders--500: 0 0 3px var(--colors-primary--500);
            --ui-glow-color: currentcolor;
            --ui-glow-text--dimmed: -9px -6px 40px var(--ui-glow-color);
            color: var(--colors-on_bg--500);
            font-family: var(--fonts-primary);
            font-size: 100%;
            line-height: 1.4;
            margin: 0;
            min-height: 100vh;
        }

        video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .app-skeleton {
            padding: 0 1rem;
            height: 100vh;
            max-width: 90em;
            margin: auto;
        }

        .app-header {
            align-items: center;
            display: flex;
            grid-area: header;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding: 1rem 0 0.5rem 0;
        }

        .app-header::after {
            background-color: var(--colors-primary--500);
            box-shadow: var(--ui-glow);
            bottom: 0;
            content: "";
            height: 2px;
            position: absolute;
            left: 0;
            width: 100%;
        }

        .app-header__anchor {
            padding: 0.5rem;
        }

        .app-header__anchor__text {
            font-family: var(--fonts-secondary);
            font-size: 1.25rem;
            letter-spacing: 0.035rem;
            text-shadow: var(--ui-glow-text);
            text-transform: uppercase;
        }

        .app-container {
            display: grid;
            grid-gap: 1rem;
            grid-template-areas: "a main main main side";
            grid-template-columns: 280px 1fr 1fr 1fr 1fr;
            height: calc(100% - 5.25rem);
        }


        .app-main {
            width: 150vh;
            grid-area: main;
        }

        .nav {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav__link {
            line-height: 1.4rem;
        }

        .nav__link__element+.nav__link__element {
            margin-left: 0.5rem;
        }



        .nav-section .nav__item+.nav__item {
            margin-top: 0.125rem;
        }

        .nav-section .nav__link {
            border: 1px solid #e8615a;
            border-radius: 3px;
            color: var(--colors-secondary--500);
            display: block;
            margin-bottom: -30px;
            font-family: var(--fonts-primary);
            padding: 0.5rem 0.75rem;
            transition: background-color 0.25s;
        }

        .nav-section .nav__link:focus,
        .nav-section .nav__link:hover {
            background-color: var(--colors-bg--300);
            border: 1px solid #5d2322;
        }

        .nav-section .nav__link--active,
        .nav-section .nav__link.nav__link--active:focus,
        .nav-section .nav__link.nav__link--active:hover {
            background-color: #391419;
            border-color: #9c3230;
        }

        .channel-link,
        .conversation-link {
            align-items: center;
            display: flex;
        }

        .channel-link__icon,
        .conversation-link__icon {
            margin-right: 0.75rem;
        }

        .channel-link__element+.channel-link__element,
        .conversation-link__element+.conversation-link__element {
            margin-left: 0.75rem;
        }

        .conversation-link__icon {}

        .conversation-link__icon::after {
            background-color: var(--colors-primary--500);
            border-radius: 50%;
            content: "";
            display: block;
            height: 0.5em;
            width: 0.5em;
        }

        .conversation-link--online .conversation-link__icon::after {
            background-color: var(--colors-active--500);
        }

        .channel-link--unread,
        .conversation-link--unread {
            font-weight: bold;
        }


        .message {
            padding-bottom: 1rem;
        }

        .message__body {
            background-color: var(--colors-bg--300);
            border: 1px solid var(--colors-tertiary--500);
            border-radius: 3px;
            margin-bottom: 8px;
            color: var(--colors-tertiary--500);
            padding: 0.75rem;
        }

        .message__footer {
            color: var(--colors-tertiary--500);
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .text-heading1,
        .text-heading2,
        .text-heading3,
        .text-heading4,
        .text-heading5,
        .text-heading6,
        .text-paragraph1 {
            margin: 0;
        }

        .segment-topbar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            min-height: 3.5rem;
        }

        .segment-topbar::after {
            background-color: var(--colors-primary--500);
            box-shadow: var(--ui-glow);
            bottom: 0;
            content: "";
            height: 1px;
            position: absolute;
            left: 0;
            width: 100%;
        }

        .segment-topbar__header {
            padding: 0.5rem 0.5rem;
            padding-top: 0;
        }

        .segment-topbar__overline {
            font-family: var(--fonts-secondary);
        }

        .segment-topbar__title {
            letter-spacing: 0.035em;
            text-shadow: var(--ui-glow-text--dimmed);
            text-transform: uppercase;
            font-size: x-large;
            font-weight: 600;
        }

        .segment-topbar__aside {
            align-self: flex-start;
            box-shadow: -6px -4px 24px rgba(156, 50, 48, 0.4);
        }

        .container {
            background-color: rgba(0, 0, 0, 0.9);
        }

        *::-webkit-scrollbar {
            height: .5rem;
            width: 10px;
        }

        *::-webkit-scrollbar-track {
            background-color: rgba(17, 11, 28, 0.9);
        }

        *::-webkit-scrollbar-thumb {
            background-color: black;
        }
        .btn{
            border:none;
            color:#2be4ea;
            background: transparent;
            position: absolute;
            right:5px;
            top:0px;
            font-size: 20px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <video autoplay loop muted>
        <source src="vid2.mp4" type="video/mp4">
    </video>
    <div class='container' id="root">
        <div class="app-skeleton">
            <header class="app-header">
                <div class="app-header__anchor"><span class="app-header__anchor__text"><a href="dashboard.php">
                            < Retech</span>
                </div></a>
            </header>
            <div class="app-container">
                <div class="app-a">
                    <div class="segment-topbar">
                        <div class="segment-topbar__header">
                            <h3 class="text-heading3 segment-topbar__title">Messages</h3>
                        </div>
                        <div class="segment-topbar__aside">
                            <div class="button-toolbar">
                            </div>
                        </div>
                    </div>
                    <div class="nav-section">

                        <div class="nav-section__body">
                            <?php
                            $query = "SELECT DISTINCT email FROM tbl_message";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $email = $row['email'];
                                    $qry = mysqli_query($conn, "SELECT * FROM tbl_message WHERE email = '$email'");
                                    $name = mysqli_fetch_assoc($qry)['name'];

                                    echo '<a class="nav__link" href=messages.php?email=' . $email . '><span class="conversation-link"><span class="conversation-link__icon"></span><span
            class="conversation-link__element">' . $name . '</span></span></a> ';

                                    echo '<form method="POST" action="">';
                                    echo '<input type="hidden" name="email" value="' . $email . '">';
                                    echo '<button type="submit" class="btn"name="delete_message"><i class="fa fa-trash"></i></button>';
                                    echo '</form>';
                                    echo '<br>';
                                }
                            } else {
                                echo '<span class="conversation-link"> NO Messages! </span><br>';
                            }
                            ?>


                        </div>
                    </div>
                </div>
                <div class="app-main">
                    <div class="channel-feed">
                        <div class="segment-topbar">
                            <div class="segment-topbar__header">
                                <?php
                                if (isset($_GET['email'])) {
                                    $selectedEmail = $_GET['email'];
                                    $query = "SELECT * FROM tbl_message WHERE email = '$selectedEmail'";
                                    $result = mysqli_query($conn, $query);
                                    $row = mysqli_fetch_assoc($result);
                                    $email = $row['email'];
                                    $phno = $row['number'];
                                    echo '<h4 class="text-heading4 segment-topbar__title">
                                        <span class="channel-link"><span class="channel-link__element">' . $email . '</span></span>
                                    </h4>';
                                    echo '<h4 class="text-heading4 segment-topbar__title">
                                    <span class="channel-link"><span class="channel-link__element">' . $phno . '</span></span>
                                </h4>';
                                }
                                ?>

                            </div>

                        </div>
                        <div class="channel-feed__body">
                            <div class="message">
                                <?php
                                if (isset($_GET['email'])) {
                                    $selectedEmail = $_GET['email'];
                                    $query = "SELECT * FROM tbl_message WHERE email = '$selectedEmail'";
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $name = $row['name'];
                                            $message = $row['message'];
                                            echo '<div class="message__body">';
                                            echo "<p>$name: $message</p>";
                                            echo '</div>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>