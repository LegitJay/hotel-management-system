<?php
require_once "database.php";

class User {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Register User
    public function registerUser($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO log_in (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        return $stmt->execute();
    }

    // Login User & Start Session
    public function loginUser($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM log_in WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result && password_verify($password, $result['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            return true;    
        }
        return false;
    }

    // Check if User is Logged In
    public function isLoggedIn() {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    }

    // Logout User
    public function logoutUser() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    // Save Booking
    public function booking($loginID, $arrivalD, $departureD, $adult, $child) {
        $stmt = $this->db->prepare("INSERT INTO booking (loginID, arrivalD, departureD, adult, child) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issii", $loginID, $arrivalD, $departureD, $adult, $child);
        return $stmt->execute();
    }

    // Get User Info (arrival and departure)
    public function getUserInfo() {
        if (!isset($_SESSION['id'])) {
            return null; 
        }
        $loginID = $_SESSION['id'];
        $stmt = $this->db->prepare("SELECT arrivalD, departureD FROM booking WHERE loginID = ?");
        $stmt->bind_param("i", $loginID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Insert Guest Information
    public function completion($loginID, $guestName, $phone, $age, $address, $payment, $specialRequest) {
        $stmt = $this->db->prepare("INSERT INTO guest_info (loginID, guest_name, phone, age, address, payment, special_request) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            echo "Error in prepare statement: " . $this->db->error;
            return false;
        }
        $stmt->bind_param("ississs", $loginID, $guestName, $phone, $age, $address, $payment, $specialRequest);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error executing query: " . $stmt->error;
            return false;
        }
    }

    // Get the room description
    public function bookRoom($loginID, $roomName, $price) {
        $stmt = $this->db->prepare("INSERT INTO room_type (loginID, room_name, price) VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $loginID, $roomName, $price);
        
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $stmt->error;
        }
        return false;
    }

    // Get User Info by Login ID
    public function getUserInfoByLoginID($loginID) {
        $stmt = $this->db->prepare("SELECT 
            booking.arrivalD, booking.departureD, booking.adult, booking.child, booking.status,
            guest_info.guest_name, guest_info.phone, guest_info.age, guest_info.address, guest_info.payment, guest_info.special_request,
            room_type.room_name, room_type.price,
            log_in.username, log_in.email
        FROM booking
        JOIN guest_info ON guest_info.loginID = booking.loginID
        JOIN room_type ON room_type.loginID = booking.loginID
        JOIN log_in ON log_in.id = booking.loginID
        WHERE booking.loginID = ?");

        $stmt->bind_param("i", $loginID);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
}

    // Update Booking
    public function updateBooking($loginID, $guestName, $phone, $address, $specialRequest, $arrivalD, $departureD, $adult, $child) {
        $sql_booking = "UPDATE booking SET arrivalD = ?, departureD = ?, adult = ?, child = ? WHERE loginID = ?";
        $stmt_booking = $this->db->prepare($sql_booking);
        $stmt_booking->bind_param("ssiii", $arrivalD, $departureD, $adult, $child, $loginID);
        $stmt_booking->execute();

        $sql_guest_info = "UPDATE guest_info SET guest_name = ?, phone = ?, address = ?, special_request = ? WHERE loginID = ?";
        $stmt_guest_info = $this->db->prepare($sql_guest_info);
        $stmt_guest_info->bind_param("ssssi", $guestName, $phone, $address, $specialRequest, $loginID);
        $stmt_guest_info->execute();
        return true;
}

    // Delete Booking
    public function deleteBooking($loginID) {
        $this->db->begin_transaction();

        try {
            $sql1 = "DELETE FROM guest_info WHERE loginID = ?";
            $stmt1 = $this->db->prepare($sql1);
            $stmt1->bind_param("i", $loginID);
            if (!$stmt1->execute()) {
                throw new Exception("Error deleting guest information: " . $stmt1->error);
            }

            $sql2 = "DELETE FROM booking WHERE loginID = ?";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->bind_param("i", $loginID);
            if (!$stmt2->execute()) {
                throw new Exception("Error deleting booking information: " . $stmt2->error);
            }

            $sql3 = "DELETE FROM room_type WHERE loginID = ?";
            $stmt3= $this->db->prepare($sql3);
            $stmt3->bind_param("i", $loginID);
            if (!$stmt3->execute()) {
                throw new Exception("Error deleting room type" . $stmt3->error);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get all bookings for admin
    public function getAllBookingsWithDetails() {
        $sql = "SELECT 
                booking.arrivalD, booking.departureD, booking.adult, booking.child, booking.status,
                guest_info.guest_name, guest_info.phone, guest_info.age, guest_info.address, guest_info.payment, guest_info.special_request,
                room_type.room_name, room_type.price,
                booking.loginID,
                log_in.username, log_in.email
            FROM booking
            JOIN guest_info ON guest_info.loginID = booking.loginID
            JOIN room_type ON room_type.loginID = booking.loginID
            JOIN log_in ON log_in.id = booking.loginID
            ORDER BY booking.loginID, booking.arrivalD";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
        die("Prepare failed: (" . $this->db->errno . ") " . $this->db->error);
    }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
}

    public function updateBookingStatus($loginID, $status) {
        $stmt = $this->db->prepare("UPDATE booking SET status = ? WHERE loginID = ?");
        $stmt->bind_param("si", $status, $loginID);
        return $stmt->execute();
}
}
?>
