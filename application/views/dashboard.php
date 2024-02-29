<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
     <!-- Include Font Awesome CSS -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-j0AQq+Vj7BAGVn6GOA26w1o9IR6Pxlb4R+38FyJg2Ul98WtSfxTfwejzUfiz60YHTGFjHuCEyl5+JZrD7Xrx5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px; /* Mulai dengan menyembunyikan sidebar */
            background-color: #333;
            padding-top: 20px;
            transition: left 0.3s ease;
        }
        .sidebar.active {
            left: 0; /* Tampilkan sidebar ketika aktif */
        }
        .sidebar a {
            padding: 10px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #555;
        }
        .content {
            margin-left: 0; /* Mulai dengan margin kiri 0 */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        .content.active {
            margin-left: 250px; /* Sesuaikan margin kiri saat sidebar aktif */
        }
        .toggle-btn {
            position: absolute;
            background-color: #333;
            top: 10px;
            cursor: pointer;
            color: white;
            z-index: 999;
            font-size: 24px; /* Ukuran simbol */
            line-height: 1; /* Menyesuaikan jarak antar baris */
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <a href="#home">Home</a>
        <a href="#users">Users</a>
        <a href="#products">Products</a>
        <a href="<?= base_url("login/logout") ?>">Logout</a>
    </div>

    <div class="content" id="content">
        <button class="toggle-btn" onclick="toggleSidebar()">☰ Menu</button>
        <h2>Welcome to Admin Dashboard</h2>
        <p>This is the content area where admin actions can be displayed.</p>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        }
    </script>
</body>
</html>
