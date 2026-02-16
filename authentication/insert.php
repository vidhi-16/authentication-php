<!DOCTYPE html>
<html>
<head>
<title>Insert New User</title>
</head>
<body>
<h1>Insert New User</h1>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<label for="name">Name:</label><br>
<input type="text" id="name" name="name" required><br><br>
<label for="email">Email:</label><br>
<input type="email" id="email" name="email" required><br><br>
<label for="password">Password:</label><br>
<input type="password" id="password" name="password" required><br><br>
<input type="submit" value="Submit">
</form>
</body>
</html>
