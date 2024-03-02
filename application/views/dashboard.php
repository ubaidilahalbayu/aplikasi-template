<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Template</title>
     <!-- Include Font Awesome CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
            top: 5px;
            cursor: pointer;
            color: white;
            z-index: 999;
            font-size: 24px; /* Ukuran simbol */
            line-height: 1; /* Menyesuaikan jarak antar baris */
        }
    </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
     
    <?php
        $userData = $this->session->userdata('user_data')[0];
        if ($this->session->flashdata('alert')) {
            $alert = $this->session->flashdata('alert');
        ?>
            <script type="text/javascript">
                alert(
                    <?php
                    if ($alert['code']=="999") {
                        echo "'<p><b>ERROR Code: 999;</b></p><p><b>Status: Fatal;</b></p><p>Message: ".$alert['message'].";</p>'";
                    }else{
                        echo "'".$alert['message']."'";
                    }
                    ?>
                );
            </script>
    <?php
        }
    ?>

    <div class="sidebar" id="sidebar">
        <a id="href_dash" href="<?= base_url("MyApplication/dashboard"); ?>">Dashboard</a>
        <a id="href_poke" href="<?= base_url("MyApplication/dashboard"); ?>">Pokemon</a>
        <a id="href_user" href="<?= base_url("MyApplication/users"); ?>">Users</a>
        <a href="<?= base_url("login/logout") ?>">Logout</a>
    </div>
    <div class="content" id="content">
        <button class="toggle-btn" onclick="toggleSidebar()">☰ Menu</button>
        <hr>
        <h2>Welcome <?= $userData['first_name']." ".$userData['last_name'] ?> to Dashboard</h2>
        <p>This is the content area where user actions can be displayed.</p>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
