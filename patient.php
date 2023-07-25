<?php
// Start the session
session_start();

// Check if the user is logged in and their type
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"]) || !in_array($_SESSION["role"], ["doctor", "patient", "pharmacist"])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-image: url('photo2.jpg'); /* Replace 'your-background-photo.jpg' with the path to your background photo */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: #fff;
        }

        h1 {
            margin-bottom: 20px;
        }

        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fff;
            text-decoration: none;
            background-color: #333;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .logout:hover {
            background-color: #555;
        }

        .content {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }

        p {
            line-height: 1.6;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Welcome, <?php echo $_SESSION["username"]; ?>!</h1>
        <p>Hey there! Welcome to our drug dispensing website, where your health and safety are our top priorities. We want to provide you with all the relevant information you need to make informed decisions about your medications. Let's dive right in!</p>
        <ol>
            <li><strong>Get to Know Your Medication:</strong> When browsing our website, you'll find clear and concise information about each medication. We'll provide you with the drug's name, description, and its primary use. Understanding what a medication does is the first step toward effective treatment.</li>
            <li><strong>Using Medications Safely:</strong> Taking medications correctly is crucial for your well-being. We'll lay out the dosage and administration instructions, ensuring you know exactly how to take the medication for maximum benefit. It's essential to follow the prescribed dosage and any special instructions, like taking it with food or before bedtime, as advised by your healthcare provider.</li>
            <li><strong>Stay Informed about Potential Risks:</strong> While medications can be beneficial, it's essential to be aware of potential side effects. Our website will list both common and serious side effects, as well as any warning signs that require immediate medical attention. By being informed, you can promptly address any concerns with your healthcare provider.</li>
            <li><strong>Avoiding Drug Interactions:</strong> Did you know that some medications can interact with others or even with certain foods and supplements? We'll make sure to highlight any known drug interactions, helping you steer clear of potential complications. Remember, it's always best to consult your healthcare provider before combining medications or starting a new one.</li>
        </ol>
        <p><strong>Fun Fact to Remember:</strong> Here's a fascinating tidbit about medicine: Did you know that aspirin, a commonly used pain reliever, can also be used to help save the lives of heart attack patients? When someone experiences a heart attack, chewing an aspirin tablet can help prevent blood clot formation and reduce damage to the heart muscle before they receive medical treatment. Always keep in mind that medicine should be taken as prescribed by your healthcare provider, and never share your medications with others. Properly disposing of unused medications also prevents misuse and accidental ingestion.</p>
        <p>At our drug dispensing website, we strive to provide you with comprehensive and reliable information, empowering you to take charge of your health. Remember, the information we offer here is meant to complement professional medical advice, not replace it. Always consult your healthcare provider before starting or altering any medication regimen. If you have any questions or concerns, our customer support team is just a click or call away. Stay informed, stay safe, and take your health into your hands!</p>
    </div>
    <a href="logout.php" class="logout">Logout</a>
    <p>This is the <?php echo $_SESSION["role"]; ?> page. Only <?php echo $_SESSION["role"]; ?>s can access this page.</p>
</body>
</html>