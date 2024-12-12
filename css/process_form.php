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
        $host = 'localhost';
        $user = 'root'; // Update if using a different username
        $password = '@OwetaJacobEmmy440'; // Your MySQL password (if any)
        $database = 'portfolio'; // Replace with your database name
        $port = 3307; // Update to your MySQL port if necessary

        // Create MySQL connection
        $conn = new mysqli($host, $user, $password, $database, $port);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL query
        $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the parameters
            $stmt->bind_param("ssss", $name, $email, $subject, $message);

            // Execute the statement
            if ($stmt->execute()) {
                echo "Message sent successfully!";
            } else {
                echo "Error executing query: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing query: " . $conn->error;
        }

        // Close the connection
        $conn->close();
    } else {
        echo "All fields are required!";
    }
}
?>
