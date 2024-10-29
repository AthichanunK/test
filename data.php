<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = "sql12.freesqldatabase.com";
$dbUsername = "sql12741546";
$dbPassword = "KAexfLWQSP";
$dbname = "sql12741546";
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

if (isset($_GET['year'])) {
    $year = intval($_GET['year']);
    $sql = "
        SELECT inv.Year, inv.P, inv.PE, inv.CPI, inv.R, inv.RLONG, sn.PE AS PE_SNP500
        FROM investment inv
        LEFT JOIN snp500 sn ON inv.Year = sn.Year
        WHERE inv.Year = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $year);
} else {
    $startYear = isset($_GET['startYear']) ? intval($_GET['startYear']) : 1900;
    $endYear = isset($_GET['endYear']) ? intval($_GET['endYear']) : 2100;
    
    $sql = "
        SELECT inv.Year, inv.P, inv.PE, inv.CPI, inv.R, inv.RLONG, sn.PE AS PE_SNP500
        FROM investment inv
        LEFT JOIN snp500 sn ON inv.Year = sn.Year
        WHERE inv.Year BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $startYear, $endYear);
}

$stmt->execute();
$result = $stmt->get_result();

$years = [];
$p_values = [];
$pe_values = [];
$cpi_values = [];
$r_values = [];
$rlong_values = [];
$pe_snp500_values = []; // New array for S&P 500 P/E values

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $years[] = $row['Year'];
        $p_values[] = $row['P'];
        $pe_values[] = $row['PE'];
        $cpi_values[] = $row['CPI'];
        $r_values[] = $row['R'];
        $rlong_values[] = $row['RLONG'];
        $pe_snp500_values[] = $row['PE_SNP500']; // Store S&P 500 P/E
    }
} else {
    echo json_encode(["error" => "No data found"]);
    exit;
}

$stmt->close();
$conn->close();

echo json_encode([
    'years' => $years,
    'p_values' => $p_values,
    'pe_values' => $pe_values,
    'cpi_values' => $cpi_values,
    'r_values' => $r_values,
    'rlong_values' => $rlong_values,
    'pe_snp500_values' => $pe_snp500_values // Return S&P 500 P/E values
]);

