<!DOCTYPE html>
<html>
<head>
    <title>AI Daily Routine & Meal Planner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="icon" type="image/png" href="https://imgs.search.brave.com/d4_wE3DdmwfCJ2Ofi5wDVqJO8h5isZmKLpS6-5TkBeo/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4t/aWNvbnMtcG5nLmZs/YXRpY29uLmNvbS8x/MjgvMzA5OC8zMDk4/Mzk1LnBuZw" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        /* Animated Gradient Background */
        body {
            background: linear-gradient(-45deg, #1e3c72, #2a5298, #0f2027, #203a43);
            background-size: 400% 400%;
            animation: gradientBG 12s ease infinite;
            min-height: 100vh;
            overflow-x: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glass Effect Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            color: white;
        }

        /* Floating Circles */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            animation: float 6s infinite ease-in-out;
        }

        .circle1 {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 5%;
        }

        .circle2 {
            width: 300px;
            height: 300px;
            bottom: 10%;
            right: 10%;
            animation-delay: 2s;
        }

        @keyframes float {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-30px); }
        }

        /* Button animation */
        .btn-primary {
            transition: 0.3s;
            border-radius: 30px;
        }

        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(255,255,255,0.6);
        }

        /* Fade in result */
        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        input, select {
            border-radius: 20px !important;
        }

        #typing-title::after {
    content: '|';
    animation: blink 1s infinite;
    margin-left: 2px;
}

@keyframes blink {
    0%, 50%, 100% { opacity: 1; }
    25%, 75% { opacity: 0; }
}

    </style>
</head>

<body>

<!-- Floating Background Shapes -->
<div class="circle circle1"></div>
<div class="circle circle2"></div>

<div class="container py-5">
    <div class="glass-card shadow p-4">
      <h2 class="text-center mb-4" id="typing-title"></h2>


        <form id="plannerForm">
            <div class="row">
                <div class="col-md-4">
                    <input type="number" name="age" class="form-control mb-3" placeholder="Age" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="weight" class="form-control mb-3" placeholder="Weight (kg)" required>
                </div>
                <div class="col-md-4">
                    <select name="goal" class="form-control mb-3">
                        <option value="Weight Loss">Weight Loss</option>
                        <option value="Muscle Gain">Muscle Gain</option>
                        <option value="Maintain">Maintain</option>
                    </select>
                </div>
            </div>

            <select name="diet" class="form-control mb-3">
                <option value="Vegetarian">Vegetarian</option>
                <option value="Non-Vegetarian">Non-Vegetarian</option>
            </select>

            <button type="submit" class="btn btn-primary w-100">
                Generate Plan
            </button>
        </form>

        <hr class="text-light">

        <div id="result" class="mt-4"></div>
    </div>

    <p class="text-danger text-center mt-3">
       Note: ⚠ This is general health guidance, not medical advice.
    </p>
</div>

<script>
document.getElementById("plannerForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const resultDiv = document.getElementById("result");
    resultDiv.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-light" role="status"></div>
            <p class="mt-2">Generating your personalized plan...</p>
        </div>
    `;

    const formData = new FormData(this);

    const response = await fetch("chat.php", {
        method: "POST",
        body: formData
    });

    const data = await response.text();

    resultDiv.innerHTML = `
        <div class="alert alert-success fade-in">
            ${data}
        </div>
    `;
});

 // Typing effect for the heading
    const titleText = "🥗 AI Daily Routine & Meal Planner";
    const titleElement = document.getElementById("typing-title");
    let index = 0;

    function typeTitle() {
        if (index < titleText.length) {
            titleElement.innerHTML += titleText.charAt(index);
            index++;
            setTimeout(typeTitle, 100); // Adjust speed here (ms per character)
        }
    }

    // Start typing effect when page loads
    window.onload = typeTitle;
</script>

</body>
</html>
