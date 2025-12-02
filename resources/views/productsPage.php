<?php
    include("header.html");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Short description of page">

        <!-- Resources -->
        <link rel="stylesheet" href="../css/Main.css">
    </head>
    <body>
        <h1>products page</h1>
        <form action="" method="post">
                <label>Category: </label>
                <select name="cuisine">
                    <option value="">All</option>
                    <option value="tool">tool</option>
                    <option value="electric">electric</option>
                </select>
                <input type="submit" value="apply filters"/>
            </form>
    </body>
</html>