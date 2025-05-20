<?php
session_start();

// Handle form submission for settings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notificationPref = $_POST['notificationPref'] ?? '';
    $language = $_POST['language'] ?? '';
    $theme = $_POST['theme'] ?? '';
    $autoLogout = $_POST['autoLogout'] ?? '';
    $currency = $_POST['currency'] ?? '';

    $_SESSION['settings'] = [
        'notificationPref' => $notificationPref,
        'language' => $language,
        'theme' => $theme,
        'autoLogout' => $autoLogout,
        'currency' => $currency,
    ];

    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        /* Navbar Styling */
        .navbar {
            background-color: #21abcd;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #fff;
        }

        /* Dark Mode Variables */
        :root {
            --bg-color: #f0f4f8;
            --card-bg: #ffffff;
            --text-color: #222;
            --button-bg: #00796b;
            --button-hover-bg: #004d40;
        }

        body.dark-mode {
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --text-color: #eeeeee;
            --button-bg: #bb86fc;
            --button-hover-bg: #985eff;
        }

        body {
            margin: 0;
            padding: 0;
            background: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Content Area Styling */
        .container {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background: var(--card-bg);
            color: var(--text-color);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--button-bg);
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
            font-weight: bold;
        }

        button:hover {
            background-color: var(--button-hover-bg);
        }

        /* Footer Styling */
        footer {
            background-color: #0892d0;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: auto; /* Ensures footer sticks to bottom */
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .toggle-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--button-bg);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .toggle-btn:hover {
            background: var(--button-hover-bg);
        }
    </style>
</head>

<body id="body">

    <!-- Navbar -->
    <div class="navbar">
        <div class="text-white font-bold text-lg"></div>
        <div class="menu flex items-center">
            <a href="dashboard.php">
                <button class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    <i class="fas fa-home"></i> Home
                </button>
            </a>
        </div>
    </div>

    <!-- Settings Section -->
    <section class="flex-grow flex flex-col items-center justify-center p-4">
        <header class="bg-[#0f88c6] w-full max-w-md p-4 text-white text-center text-lg font-semibold rounded-t-lg">
            Settings
        </header>

        <main class="max-w-md w-full rounded-b-lg shadow-lg p-6 overflow-auto max-h-[90vh]">
            <form id="settingsForm" class="space-y-6">
                <h2 id="settingsHeading" class="text-[#003366] text-xl font-semibold mb-4 text-center">Account Settings</h2>

                <div>
                    <label for="notificationPref" class="block text-[#003366] font-medium mb-1">Notification Preferences</label>
                    <select id="notificationPref" name="notificationPref" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="all">All Notifications</option>
                        <option value="email">Email Only</option>
                        <option value="sms">SMS Only</option>
                        <option value="none">No Notifications</option>
                    </select>
                </div>

                <div>
                    <label for="language" class="block text-[#003366] font-medium mb-1">Preferred Language</label>
                    <select id="language" name="language" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="english">English</option>
                        <option value="hindi">Hindi</option>
                        <option value="marathi">Marathi</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label for="theme" class="block text-[#003366] font-medium mb-1">Theme</label>
                    <select id="theme" name="theme" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                        <option value="system">System Default</option>
                    </select>
                </div>

                <div>
                    <label for="autoLogout" class="block text-[#003366] font-medium mb-1">Auto Logout (minutes)</label>
                    <input type="number" id="autoLogout" name="autoLogout" min="1" max="60" value="15" class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>

                <div>
                    <label for="currency" class="block text-[#003366] font-medium mb-1">Currency</label>
                    <select id="currency" name="currency" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="inr">INR (₹)</option>
                        <option value="usd">USD ($)</option>
                        <option value="eur">EUR (€)</option>
                        <option value="gbp">GBP (£)</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-[#0f88c6] text-white py-2 rounded hover:bg-[#0b5e8a] transition-colors mt-6">
                    Save Settings
                </button>
            </form>
        </main>
    </section>

    <!-- Footer -->
    <footer>
        <a href="privacy.php" class="block mb-2 hover:underline">Privacy Policy</a>
        <p class="flex justify-center items-center gap-2">
            <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
            <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
        </p>
    </footer>

    <script>
        // Theme Change
        function applyTheme(theme) {
            const body = document.getElementById('body');
            if (theme === 'dark') {
                body.classList.add('bg-gray-900', 'text-white');
                body.classList.remove('bg-white', 'text-black');
            } else if (theme === 'light') {
                body.classList.add('bg-white', 'text-black');
                body.classList.remove('bg-gray-900', 'text-white');
            } else {
                // System theme (default)
                body.classList.remove('bg-white', 'text-black', 'bg-gray-900', 'text-white');
            }
        }

        document.getElementById('theme').addEventListener('change', function () {
            const theme = this.value;
            applyTheme(theme);
            localStorage.setItem('theme', theme);
        });

        window.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.getElementById('theme').value = savedTheme;
                applyTheme(savedTheme);
            }
        });

        // Language Change
        function applyLanguage(language) {
            const heading = document.getElementById('settingsHeading');
            if (language === 'hindi') {
                heading.innerText = 'खाता सेटिंग्स';
            } else if (language === 'marathi') {
                heading.innerText = 'खाते सेटिंग्ज';
            } else if (language === 'other') {
                heading.innerText = 'अन्य भाषा सेटिंग';
            } else {
                heading.innerText = 'Account Settings';
            }
        }

        document.getElementById('language').addEventListener('change', function () {
            const lang = this.value;
            applyLanguage(lang);
            localStorage.setItem('language', lang);
        });
    </script>

</body>

</html>
