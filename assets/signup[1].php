<?php
$host = "localhost"; // Change if different
$username = "root";  // Change if your MySQL username is different
$password = "";      // Change if your MySQL password is not empty
$dbname = "signup_db"; // Replace with your actual DB name

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $firstName = $_POST["firstname"];
  $lastName = $_POST["lastname"];
  $contact = $_POST["contact"];
  $address = $_POST["address"];
  $password = $_POST["password"];
  $confirmPassword = $_POST["confirm-password"];

  if ($password !== $confirmPassword) {
    echo "<script>alert('Passwords do not match');</script>";
  } else {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (email, firstname, lastname, contact, address, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $email, $firstName, $lastName, $contact, $address, $hashedPassword);

    if ($stmt->execute()) {
      echo "<script>alert('Signup successful! Redirecting to login...'); window.location.href='login.php';</script>";
    } else {
      echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('signupbg.webp');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .signup-container {
      background-color: rgba(255, 255, 255, 0.5);
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    .signup-container h2 {
      margin-bottom: 20px;
      text-align: center;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      color: #333;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 16px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      border-color: #007BFF;
      outline: none;
    }

    .signup-button {
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 10px;
    }

    .signup-button:hover {
      background-color: #218838;
    }

    .login-text {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: #555;
    }

    .login-text a {
      color: #007BFF;
      text-decoration: none;
    }

    .login-text a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="signup-container">
    <h2>Sign Up</h2>
    <form method="post" action="signup.php">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
      </div>

      <div class="form-group">
        <label for="firstname">First Name</label>
        <input type="text" id="firstname" name="firstname" required />
      </div>

      <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" id="lastname" name="lastname" required />
      </div>

      <div class="form-group">
        <label for="contact">Contact Number</label>
        <input type="tel" id="contact" name="contact" required />
      </div>

      <div class="form-group">
        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3" required></textarea>
      </div>

      <div class="form-group">
        <label for="password">Set Password</label>
        <input type="password" id="password" name="password" required />
      </div>

      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" required />
      </div>

      <button type="submit" class="signup-button">Create Account</button>
    </form>

    <div class="login-text">
      Already have an account? <a href="login.php">Login</a>
    </div>
  </div>
</body>
</html>
