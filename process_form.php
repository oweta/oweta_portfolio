<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Process the form only if it was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the POST variables are set and sanitize them
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

    // Validate form inputs
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // Your MySQL connection details
        $host = 'sql108.infinityfree.com'; // Your MySQL Hostname
        $user = 'if0_37905611';           // Your MySQL Username
        $password = 'Zj7H7APeztxxYTp';    // Your MySQL Password
        $database = 'if0_37905611_portfolio_db'; // Your Database Name

        // Create MySQL connection
        $conn = new mysqli($host, $user, $password, $database);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL query
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");

        if ($stmt) {
            // Bind parameters (s for string type)
            $stmt->bind_param("ssss", $name, $email, $subject, $message);

            // Execute statement
            if ($stmt->execute()) {
                // Success message
                echo "<script>
                    alert('Your message has been sent successfully!');
                    window.location.href = 'index.html'; // Redirect back to the form page
                </script>";
            } else {
                // Error message if execution fails
                echo "Error executing query: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            // Error preparing the query
            echo "Error preparing query: " . $conn->error;
        }

        // Close the connection
        $conn->close();
    } else {
        // Display validation error
        echo "<script>alert('All fields are required!');</script>";
    }
}
?>
