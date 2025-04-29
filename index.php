<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>KI-basierte Schmerzberatung</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 id = "title">KI-basierte Schmerzberatung</h1>

  <div id="bild-container">
    <img id="bild-mann" src="Mann.jpg" alt="Bild eines Mannes" style="display: none;">
    <img id="bild-frau" src="Frau.jpg" alt="Bild einer Frau" style="display: none;">
    <div class="marker" id="marker-kopf-mann" style="top: 25px; left: 102px;"></div>
    <div class="marker" id="marker-hals-mann" style="top: 50px; left: 102px;"></div>
    <div class="marker" id="marker-nacken-mann" style="top: 68px; left: 254px;"></div>
    <div class="marker" id="marker-schulter-rechts-mann" style="top: 80px; left: 67px;"></div>
    <div class="marker" id="marker-schulter-links-mann" style="top: 80px; left: 137px;"></div>
    <div class="marker" id="marker-ruecken-mann" style="top: 95px; left: 271px;"></div>
    <div class="marker" id="marker-brust-rechts-mann" style="top: 95px; left: 82px;"></div>
    <div class="marker" id="marker-brust-links-mann" style="top: 95px; left: 122px;"></div>
    <div class="marker" id="marker-bauch-mann" style="top: 130px; left: 92px; width: 50px; height:50px"></div>
    <div class="marker" id="marker-arme-mann" style="top: 80px; left: 60px;"></div>
    <div class="marker" id="marker-hand-rechts-mann" style="top: 185px; left: 42px;"></div>
    <div class="marker" id="marker-hand-links-mann" style="top: 185px; left: 162px;"></div>
    <div class="marker" id="marker-knie-rechts-mann" style="top: 260px; left: 79px;"></div>
    <div class="marker" id="marker-knie-links-mann" style="top: 260px; left: 125px;"></div>
    <div class="marker" id="marker-fuss-rechts-mann" style="top: 345px; left: 80px;"></div>
    <div class="marker" id="marker-fuss-links-mann" style="top: 345px; left: 124px;"></div>

    <div class="marker" id="marker-kopf-frau" style="top: 35px; left: 102px;"></div>
    <div class="marker" id="marker-hals-frau" style="top: 68px; left: 102px;"></div>
    <div class="marker" id="marker-nacken-frau" style="top: 87px; left: 248px;"></div>
    <div class="marker" id="marker-schulter-rechts-frau" style="top: 90px; left: 77px;"></div>
    <div class="marker" id="marker-schulter-links-frau" style="top: 90px; left: 127px;"></div>
    <div class="marker" id="marker-ruecken-frau" style="top: 95px; left: 265px;"></div>
    <div class="marker" id="marker-brust-rechts-frau" style="top: 112px; left: 85px;"></div>
    <div class="marker" id="marker-brust-links-frau" style="top: 112px; left: 119px;"></div>
    <div class="marker" id="marker-bauch-frau" style="top: 140px; left: 92px; width: 50px; height:50px"></div>
    <div class="marker" id="marker-arme-frau" style="top: 80px; left: 60px;"></div>
    <div class="marker" id="marker-hand-rechts-frau" style="top: 195px; left: 59px;"></div>
    <div class="marker" id="marker-hand-links-frau" style="top: 195px; left: 145px;"></div>
    <div class="marker" id="marker-knie-rechts-frau" style="top: 260px; left: 85px;"></div>
    <div class="marker" id="marker-knie-links-frau" style="top: 260px; left: 119px;"></div>
    <div class="marker" id="marker-fuss-rechts-frau" style="top: 345px; left: 92px;"></div>
    <div class="marker" id="marker-fuss-links-frau" style="top: 345px; left: 112px;"></div>
  </div>

    <form method="post" action ="geminiai.php">   
        <label for="geschlecht">Wählen Sie Ihr Geschlecht:</label>
        <select id="geschlecht" name="geschlecht">
            <option value="">Bitte wählen</option>
            <option value="mann">Mann</option>
            <option value="frau">Frau</option>
        </select>
        <br><br>
        <label for="alter">Alter:</label>
        <input type="number" id="alter" name="alter" min="0" max="150">
        <br><br>
        <div class="checkbox-group">
            <strong id = "checkbox-title">Wo haben Sie Schmerzen? (Mehrere Auswahl möglich)</strong><br><br>
            <label><input type="checkbox" name="body_parts[]" value="Kopf"> Kopf</label>
            <label><input type="checkbox" name="body_parts[]" value="Hals"> Hals</label>
            <label><input type="checkbox" name="body_parts[]" value="Nacken"> Nacken</label>
            <label><input type="checkbox" name="body_parts[]" value="Schultern"> Schultern</label>
            <label><input type="checkbox" name="body_parts[]" value="Rücken"> Rücken</label>
            <label><input type="checkbox" name="body_parts[]" value="Brust"> Brust</label>
            <label><input type="checkbox" name="body_parts[]" value="Bauch"> Bauch</label>
            <label><input type="checkbox" name="body_parts[]" value="Hand"> Hand</label>
            <label><input type="checkbox" name="body_parts[]" value="Knie"> Knie</label>
            <label><input type="checkbox" name="body_parts[]" value="Fuß"> Fuß</label>
        </div>
        <label for="prompt">Anmerkungen:</label><br>
        <textarea class = "textarea" name="prompt" rows="6" placeholder="Geben Sie, wenn nötig Zusatzinformationen an..."><?php echo isset($_POST['prompt']) ? htmlspecialchars($_POST['prompt']) : ''; ?></textarea><br>
        <input type="submit" value="Senden">
    </form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bodyPartToMarkerIdsMann = {
            'Schultern': ['marker-schulter-links-mann', 'marker-schulter-rechts-mann'],
            'Kopf': ['marker-kopf-mann'],
            'Hals': ['marker-hals-mann'],
            'Nacken': ['marker-nacken-mann'],
            'Rücken': ['marker-ruecken-mann'],
            'Brust': ['marker-brust-rechts-mann', 'marker-brust-links-mann'],
            'Bauch': ['marker-bauch-mann'],
            'Hand': ['marker-hand-rechts-mann', 'marker-hand-links-mann'],
            'Knie': ['marker-knie-rechts-mann', 'marker-knie-links-mann'],
            'Fuß': ['marker-fuss-rechts-mann', 'marker-fuss-links-mann']
        };
        const bodyPartToMarkerIdsFrau = {
            'Schultern': ['marker-schulter-links-frau', 'marker-schulter-rechts-frau'],
            'Kopf': ['marker-kopf-frau'],
            'Hals': ['marker-hals-frau'],
            'Nacken': ['marker-nacken-frau'],
            'Rücken': ['marker-ruecken-frau'],
            'Brust': ['marker-brust-rechts-frau', 'marker-brust-links-frau'],
            'Bauch': ['marker-bauch-frau'],
            'Hand': ['marker-hand-rechts-frau', 'marker-hand-links-frau'],
            'Knie': ['marker-knie-rechts-frau', 'marker-knie-links-frau'],
            'Fuß': ['marker-fuss-rechts-frau', 'marker-fuss-links-frau']
        };

        const checkboxes = document.querySelectorAll('input[name="body_parts[]"]');
        const geschlechtSelect = document.getElementById('geschlecht');
        const bildMann = document.getElementById('bild-mann');
        const bildFrau = document.getElementById('bild-frau');

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const selectedValue = geschlechtSelect.value;

                let markerIds = null;
                if (selectedValue === 'mann') {
                    markerIds = bodyPartToMarkerIdsMann[this.value];
                } else if (selectedValue === 'frau') {
                    markerIds = bodyPartToMarkerIdsFrau[this.value];
                }

                if (markerIds) {
                    markerIds.forEach(function (markerId) {
                        const marker = document.getElementById(markerId);
                        if (marker) {
                            if (checkbox.checked) {
                                marker.classList.add('active');
                            } else {
                                marker.classList.remove('active');
                            }
                        }
                    });
                }
            });
        });

        geschlechtSelect.addEventListener('change', function () {
            const selectedValue = this.value;

            bildMann.style.display = 'none';
            bildFrau.style.display = 'none';

            if (selectedValue === 'mann') {
                bildMann.style.display = 'block';
            } else if (selectedValue === 'frau') {
                bildFrau.style.display = 'block';
            }

            // Unselected alle Checkboxen
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });

            // Entferne auch alle aktiven Marker
            const allActiveMarkers = document.querySelectorAll('.active');
            allActiveMarkers.forEach(function (marker) {
                marker.classList.remove('active');
            });
        });
    });
</script>
</body>
</html>