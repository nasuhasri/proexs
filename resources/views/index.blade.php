<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projext EXS</title>
</head>

<body>
    <h1>Project EXS</h1>
    
    @if (!empty($message))
        <h3>{{ $message }}</h3>
    @else
        <p>Time In: {{ $timeIn }}</p>
        <p>Time Out: {{ $timeOut }}</p>
        <p>Duration: {{ $duration->h }} hours {{ $duration->i }} minutes</p>
        <p>Amount to Paid: RM{{ $totalAmount }}</p>
        <p>Final Amount to be Paid: RM{{ $finalTotalAmount }}</p>
    @endif
</body>

</html>