<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="https://techstory.in/wp-content/uploads/2021/04/Logo_PayG-1-2048x726.png">
    <title>Reconciliation</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Reconciliation</title>

</head>
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    @import url('/css/app.css');
</style>


<body>
    <div class="row m-0">
        <div class="col-md-1 displayNone" id="col-md-2">
            <div class="row" style="padding: 2px;">
            <img class="company-logo" src="{{ asset('images/payg_logo.svg') }}" alt="">
            </div>
            <div>
                <a class="menu-link {{ request()->is('axis-data') ? 'active' : '' }}" href="/axis-data" id="home" style="width: 80px; display: inline-block;">
                    <i class="fas fa-university"></i>UPI-Axis Bank
                </a><br>
                <a class="menu-link {{ request()->is('/') ? 'active' : '' }}" href="/" id="home" style="width: 80px; display: inline-block;">
                    <i class="fas fa-university"></i>UPI-Cosmos Bank
                </a><br>
                <a class="menu-link {{ request()->is('icici-data') ? 'active' : '' }}" href="/icici-data" id="home" style="width: 80px; display: inline-block;">
                    <i class="fas fa-university"></i>UPI-ICICI Bank
                </a><br>
                <a class="menu-link {{ request()->is('indusland-data') ? 'active' : '' }}" href="/indusland-data" id="home" style="width: 80px; display: inline-block;">
                    <i class="fas fa-university"></i>Induslnd Bank
                </a><br>
                <a class="menu-link {{ request()->is('upi-kotak-data') ? 'active' : '' }}" href="/upi-kotak-data" id="home" style="width: 80px; display: inline-block;">
                    <i class="fas fa-university"></i>UPI-Kotak Bank
                </a><br>
                <a class="menu-link {{ request()->is('payu-data') ? 'active' : '' }}" href="/payu-data" id="home" style="width: 80px; display: inline-block;">
                    <i class="fas fa-university"></i>PayU Bank
                </a><br>

                <a class="menu-link {{ request()->is('all-acquirers') ? 'active' : '' }}" href="/all-acquirers" id="home" style="width: 80px; display: inline-block;">
                    <i class="fas fa-university"></i>All Acquirers
                </a><br>
            </div>
        </div>

        <div class="col-md-11 p-0 fullContaint">
            <div class="navbar navbar-dark">
                <div class="container-fluid m-0 p-0">
                    Reconciliation
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="logout" type="submit" class="btn btn-link text-white">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
            <div style="margin-left: 3px;"> @yield('content')</div>
        </div>
    </div>
</body>

</html>