<?php ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Categories | Expense Tracker</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles/index.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="index-page-container">
            <div class="title">Categories</div>
            <table class="index-table">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="table-pagination">
            </div>
            <div class="add-category">
                <a href="#" class="add-link">Add New Category</a>
            </div>
        </div>
        <script src="../scripts/category-list.js"></script>
        <script src="../scripts/common.js"></script>
        <script src="../scripts/navbar.js"></script>
        <script src="../scripts/user-service.js"></script>
    </body>
</html>
