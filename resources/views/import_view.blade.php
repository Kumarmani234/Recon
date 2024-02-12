@extends('home')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <!-- import.blade.php -->
    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('acquirer.import') }}" method="GET" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".xls, .xlsx, .csv">
        <button type="submit" style="background:#1195D3 ;color:white;border:none;font-size:12px;padding:5px 10px;border-radius:5px;">Import</button>
    </form>
</body>

</html>
@endsection