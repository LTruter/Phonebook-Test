<?php
// Include the connection
$conn = require_once "db_conn.php";

// Declare the validate_var function above where it's used
function validate_var($first_name, $last_name, $email, $phone)
{
  // trim() removes whitespaces (spaces, tabs, newlines) from the beginning and end of the string
  // Validate first name
  if (empty(trim($first_name))) {
    return "Error: First name cannot be empty";
  }

  if (strlen($first_name) > 100) {
    return "Error: First name must not exceed 100 characters";
  }

  // Validate last name
  if (empty(trim($last_name))) {
    return "Error: Last name cannot be empty";
  }

  if (strlen($last_name) > 100) {
    return "Error: Last name must not exceed 100 characters";
  }

  // Validate email
  if (empty(trim($email))) {
    return "Error: Email cannot be empty";
  }

  if (strlen($email) > 100) {
    return "Error: Email must not exceed 100 characters";
  }

  // Validate phone number
  if (empty(trim($phone))) {
    return "Error: Phone number cannot be empty";
  }

  if (strlen($phone) > 10) {
    return "Error: Phone number must not exceed 10 digits";
  }

  // There are no errors
  return "";
}

// Variables for form message
$form_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Save the input data to variables
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];

  // Validate input data
  $form_msg = validate_var($first_name, $last_name, $email, $phone);

  // Proceed if there are no errors
  if (empty($form_msg)) {

    // SQL query to insert the contact
    $sql = "INSERT INTO contacts(first_name, last_name, email, phone) VALUES(?, ?, ?, ?)";

    // Prepare the query using the connection
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared correctly
    if ($stmt) {

      // Bind the parameters to the query
      $stmt->bind_param("ssss", $first_name, $last_name, $email, $phone);

      // Execute the query
      if ($stmt->execute()) {
        $form_msg = "Contact added successfully";
      } else {
        // Handle execution failure
        $form_msg = "Failed to insert: " . $stmt->error;
      }

      // Close the statement
      $stmt->close();
    } else {
      // Handle prepare failure
      $form_msg = "Statement failed to prepare: " . $conn->error;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylesheet.css">
  <title>Add Contact</title>
</head>

<body>
  <header id="page-header">
    <h1 id="site-name">My Phonebook</h1>
  </header>

  <main>
    <div class="form-container">
      <?php echo "<div class='form-message'>" . $form_msg . "</div>"; ?>
      <h2>User Information</h2>
      <form method="POST">
        <input type="text" name="first_name" placeholder="First Name" pattern="[A-Za-z][A-Za-z\s]*"
          title="Must only contain letters" required>
        <input type="text" name="last_name" placeholder="Last Name" pattern="[A-Za-z][A-Za-z\s]*"
          title="Must only contain letters" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="phone" placeholder="Phone" pattern="[0-9]{10}" title="Must only contain numbers"
          required>
        <button type="submit">Submit</button>
      </form>
    </div>
  </main>
</body>

</html>