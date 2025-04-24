<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Event Booking</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url(bookingb.jpg);
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .booking-container {
      background-color: rgba(255, 255, 255, 0.5);
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
    }

    .booking-container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      color: #333;
      font-weight: bold;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      border-color: #007BFF;
      outline: none;
    }

    .submit-button {
      width: 100%;
      padding: 12px;
      background-color: #007BFF;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 10px;
    }

    .submit-button:hover {
      background-color: #0056b3;
    }

    .note {
      font-size: 13px;
      color: #777;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <div class="booking-container">
    <h2>Book Your Event</h2>
    <form action="booking.php" method="POST">
      <div class="form-group">
        <label for="distribution">Event Distribution</label>
        <input type="text" id="distribution" name="distribution" required />
      </div>

      <div class="form-group">
        <label for="date">Event Date</label>
        <input type="date" id="date" name="date" required />
      </div>

      <div class="form-group">
        <label for="budget">Event Budget</label>
        <input type="number" id="budget" name="budget" required />
      </div>

      <div class="form-group">
        <label for="functions">Functions</label>
        <input type="text" id="functions" name="functions" placeholder="e.g. Wedding, Birthday, Corporate" required />
      </div>

      <div class="form-group">
        <label for="about">Tell Us About the Event</label>
        <textarea id="about" name="about" rows="4" required></textarea>
      </div>

      <div class="form-group">
        <label for="hear">How Did You Hear About Us?</label>
        <select id="hear" name="hear" required>
          <option value="">-- Select --</option>
          <option value="social-media">Social Media</option>
          <option value="google">Google Search</option>
          <option value="friend">Friend/Referral</option>
          <option value="ad">Online Advertisement</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div class="form-group">
        <label for="consultation">Schedule Online Consultation <span class="note">(Optional)</span></label>
        <input type="datetime-local" id="consultation" name="consultation" />
      </div>

      <button type="submit" class="submit-button">Submit Booking</button>
    </form>
  </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'db_config.php'; // Replace with your database connection

  $distribution = $_POST['distribution'];
  $date = $_POST['date'];
  $budget = $_POST['budget'];
  $functions = $_POST['functions'];
  $about = $_POST['about'];
  $hear = $_POST['hear'];
  $consultation = $_POST['consultation'];

  $stmt = $conn->prepare("INSERT INTO bookings (distribution, event_date, budget, functions, about, heard_from, consultation_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssissss", $distribution, $date, $budget, $functions, $about, $hear, $consultation);

  if ($stmt->execute()) {
    echo "<script>alert('Booking submitted successfully!'); window.location.href='booking.php';</script>";
  } else {
    echo "<script>alert('Error: " . $stmt->error . "');</script>";
  }

  $stmt->close();
  $conn->close();
}
?>
</body>
</html>
