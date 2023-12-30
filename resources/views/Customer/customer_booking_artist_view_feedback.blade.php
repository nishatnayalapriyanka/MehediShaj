<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Customer/customer_booking_artist_view_feedback.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <h1 class= "title">
        <i class="fa-regular fa-image"></i> Feedback( {{Session::get('booking_artist')}} )
    </h1>
    <br>
    <div class= "feedback_container">
        @foreach($feedback as $feedback)
            <div class= "feedback">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $feedback->ratings )
                        <i class="fa-solid fa-star" style="color: yellowgreen;"></i>
                    @else
                        <i class="fa-solid fa-star" style="color: transparent;"></i>
                    @endif
                @endfor
                <br><br>
                @if($feedback->comment)
                    {{$feedback->comment}}
                @endif
            </div>           
        @endforeach 
    </div>
</body>
</html>
