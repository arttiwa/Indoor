<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortest Path Finder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Enter your start point:</h1>
    <form method="post" action="process.php">
    <label for="start">Choose a start:</label>
    <select name="start" id="start">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select>
<p></p>
    <label for="end">Choose a end:</label>
    <select name="end" id="end">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select> <p></p>
    <input type="submit" value="Submit">
    </form>
</body>
</html>