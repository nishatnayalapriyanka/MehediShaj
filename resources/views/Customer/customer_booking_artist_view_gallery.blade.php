<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Customer/customer_booking_artist_view_gallery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <h1 class= "title">
        <i class="fa-regular fa-image"></i> Gallery( {{Session::get('booking_artist')}} )
    </h1>
    <br>
    <div class= "gallery_container">
        @foreach($gallery as $gallery)
            <img class="gallery_photo" src= "Artist Gallery/{{$gallery->img_name}}">
        @endforeach 
    </div>
</body>
</html>
