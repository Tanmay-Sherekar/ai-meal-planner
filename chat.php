<?php
require 'config.php';

// Enable error reporting (REMOVE in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if POST request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

// Validate inputs safely
$age = $_POST['age'] ?? '';
$weight = $_POST['weight'] ?? '';
$goal = $_POST['goal'] ?? '';
$diet = $_POST['diet'] ?? '';

if (!$age || !$weight || !$goal || !$diet) {
    die("All fields are required.");
}

$prompt = "Create a simple daily routine and meal plan.
Age: $age
Weight: $weight kg
Goal: $goal
Diet Preference: $diet

Include:
- Morning routine
- Breakfast
- Lunch
- Evening snack
- Dinner
- Water intake
- Exercise
- Sleep recommendation

Keep it clear and easy to follow.";

// Prepare API request
$data = [
    "model" => "gpt-4o-mini",
    "messages" => [
        ["role" => "system", "content" => "You are a professional fitness and nutrition assistant."],
        ["role" => "user", "content" => $prompt]
    ],
    "temperature" => 0.7
];

$ch = curl_init("https://api.openai.com/v1/chat/completions");

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer " . OPENAI_API_KEY
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data)
]);

$response = curl_exec($ch);

// Check cURL error
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

$result = json_decode($response, true);

// Check API error
if (isset($result['error'])) {
    echo "API Error: " . $result['error']['message'];
    exit;
}

// Safe output
if (isset($result['choices'][0]['message']['content'])) {
    echo nl2br(htmlspecialchars($result['choices'][0]['message']['content']));
} else {
    echo "Unexpected API response.";
}
?>

