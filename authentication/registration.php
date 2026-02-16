<?php
session_start();
require "db_connection.php";

$error = ""; // ADD THIS

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    }

    // Password length check
    elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters";
    }

    else {
        // Check duplicate email
        $check = $con->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Email already registered";
        }
        $check->close();
    }

    // Insert user ONLY if no error
    if (empty($error)) {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $con->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration successful! Please login.');
                    window.location='login.php';
                  </script>";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<!-- SHOW ERROR HERE -->
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password (min 8 chars)" required><br><br>
    <input type="submit" value="Register">
</form>

<a href="login.php">Already have an account? Login</a>

</body>
</html>
