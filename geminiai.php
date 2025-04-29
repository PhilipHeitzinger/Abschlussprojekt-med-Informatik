<?php
$responseText = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['body_parts']) && !empty($_POST['body_parts'])) {
    $selectedParts = $_POST['body_parts'];
    $anfrage = $_POST['prompt'];
    $geschlecht = $_POST['geschlecht'];
    $api_key = 'AIzaSyBN4_p0e0WUjW9W9prLFce-r3tBz8c96Ak';
    $model = 'gemini-2.0-flash';
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $api_key;

    // **Angepasster Prompt, um nach Ratschlägen zu fragen:**
    $painDescription = "Ich habe Schmerzen in folgenden Körperteilen: " . implode(", ", $selectedParts) . ". Was kann ich dagegen tun, halte dich kurz. Sag mir nicht das du kein Arzt bist.";
    $fullPain = $anfrage . " \n " . $painDescription . "\nIch bin ein/e". $geschlecht;
    $data = [
        'contents' => [
            ['parts' => [['text' => $fullPain]]]
        ]
    ];

    $headers = [
        'Content-Type: application/json'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        $responseText = "Fehler beim Abrufen der Antwort.";
    } else {
        $decoded = json_decode($response, true);
        $responseText = $decoded['candidates'][0]['content']['parts'][0]['text'] ?? 'Keine Antwort erhalten.';
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>KI-Antwort</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>KI-Antwort</h1>
    <?php if (!empty($responseText)): ?>
        <div class="antwort">
            <strong>Mögliche Ratschläge:</strong><br>
            <?php echo nl2br(htmlspecialchars($responseText)); ?>
        </div>
    <?php else: ?>
        <p>Es gab ein Problem bei der Anfrage oder keine Daten wurden gesendet.</p>
    <?php endif; ?>
    <p><a href="index.php">Zurück zum Formular</a></p>
</body>
</html>