<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="desk-page-container">
        <div class="nav-bar">
            <ul class="nav-items">
                <li class="logo">EBMS</li>
                <li>Log out</li>
            </ul>
        </div>
        <div class="under-nav-section">Dashboard</div>
        <div class="upper-menu-section">
            <ul class="upper-left-menu-items">
                <li>Analytics</li>
            </ul>
            <div class="upper-right-menu-items">
                <input class="search-input" type="search" placeholder="Search"/>
                <button class="search-button">Search</button>
            </div>
        </div>
        <div class="dash-container">
            <div class="side-menu-section">
                <button class="toggle-menu" onclick="toggleMenu()">☰</button>
                <h5 class="side-menu-headings">Analysis</h5>
                <ul class="side-menu-items">
                    <li><a href="{{ url('dashboard') }}" class="nav-link">Energy Analysis</a></li>
                    <li><a href="{{ url('/reports') }}" class="nav-link">Reports</a></li>
                    <li><a href="{{ url('/predictions') }}" class="nav-link">Predictions</a></li>
                </ul>
                <h5 class="side-menu-headings">Hardware Management</h5>
                <ul class="side-menu-items">
                    <li><a href="{{ url('/appliances') }}" class="nav-link">Appliances</a></li>
                    <li><a href="{{ url('/equipment') }}" class="nav-link">Equipment</a></li>
                    <li><a href="{{ url('/zones') }}" class="nav-link">Zones</a></li>
                </ul>
                <h5 class="side-menu-headings">Administrative Management</h5>
                <ul class="side-menu-items">
                    <li><a href="{{ url('/overviews') }}" class="nav-link">Overviews</a></li>
                    <li><a href="{{ url('/users') }}" class="nav-link">Users</a></li>
                </ul>
            </div>
            <div class="main-content">
                {{ $slot }}
            </div>
        </div>
    </div>
    <script>
        function toggleMenu() {
            document.querySelector('.side-menu-section').classList.toggle('collapsed');
        }
    </script>
</body>
</html>
