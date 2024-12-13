<?php ?>

<!DOCTYPE html>

<html lang="en">
<head>
    <link rel="stylesheet" href="..//styles/index.css">
</head>
<body>
    <input type="checkbox" id="menu-toggle" class="hidden-checkbox">
    <label for="menu-toggle" class="menu-btn">
        <img src="../icons/hamburger-menu-24-white.png" alt="Menu icon default" class="icon-default">
        <img src="../icons/hamburger-menu-24-colored.png" alt="Menu icon active" class="icon-active">
    </label>

    <div class="menu-wrapper">
        <nav class="menu">
            <ul id="menu-list">
            </ul>
        </nav>
    </div>
</body>
<script src="../scripts/header.js"></script>
<script src="../scripts/user-service.js"></script>
</html>