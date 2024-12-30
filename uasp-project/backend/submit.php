<?php
$servername = "mysql"; // Hostname sesuai dengan nama service di docker-compose
$username = "akso"; // Username database
$password = "akso"; // Password database
$dbname = "library"; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Memproses data jika method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data input
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $nim = isset($_POST['nim']) ? $conn->real_escape_string($_POST['nim']) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : '';
    $program = isset($_POST['program']) ? $conn->real_escape_string($_POST['program']) : '';

    if (!empty($name) && !empty($nim) && !empty($email) && !empty($phone) && !empty($program)) {
        // Menggunakan prepared statements untuk keamanan
        $stmt = $conn->prepare("INSERT INTO users (name, nim, email, phone, program) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $nim, $email, $phone, $program);

        if ($stmt->execute()) {
            echo "Data saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}

// Menutup koneksi
$conn->close();
?>
