<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Kasir Dashboard</title>
</head>
<body>
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h1>Welcome To Kasir Dashboard</h1>
                        </div>
                    </div>
                    <a href="{{ route('pos.logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" class="nav-link">
                        <i data-feather="log-out"></i>
                        <span>Log Out</span>
                    </a>
                    <form id="logout-form" action="{{ route('pos.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
</body>
</html>
