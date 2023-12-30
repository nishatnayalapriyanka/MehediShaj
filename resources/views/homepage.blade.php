<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/homepage.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
</head>
<body>

	<!-- navigation -->
	<nav>
		<div class="nav_left">
			<img class="logo" src="Project Image/MehediShaj_logo.png">
			
			<a href="#About_Us">About Us</a>
			<a href="#Packages">Packages</a>			
            <a href="#Gallery">Gallery</a>
			<a href="#Ratings">Ratings</a>
            <a href="#Contact_Us">Contact Us</a>
		</div>

		<div class="nav_right">
			<a href="/customer_signup_phone_number_verify">Sign Up</a>
			<a href="/customer_login">Log In</a>
		</div>
	</nav>

	<!-- banner -->
    <section class="banner" >
        <img class="banner_gif" src="Project Image/banner.gif">
        <img class="banner_henna_bowl" src="Project Image/banner_henna_bowl.png">
        <img class="banner_artist" src="Project Image/banner_artist.png">

        <div class="artist_account"> 
            <p>Are you a henna artist??</p>
            <div class="button">
		        <a href="artist_signup_phone_number_verify">Sign Up</a>
		        <a href="artist_login">Log In</a>
            </div>
        </div>

	</section>
    <br><br><br>
    <br><br><br>

	<!-- About Us -->
	<h1 id="About_Us" class="heading">
		MehediShaj
	</h1>

	<section class="About_Us">
        <img src="Project Image/about_us.png">

		<p>
			<b>Assalamualaikum,</b> We provide our services for
            "Bridal Package" & "Non-Bridal
            Package". We have many professional henna artists so,
            you can book your favorite artist for any package.
            Making your special day memorable is our duty. <b>Thank you.....</b>
		</p>
	</section>   
	<br><br><br>

	<!-- Packages -->
	<h1 id="Packages" class="heading">
		Our Packages
	</h1>

	<section class="Packages">
        <img src="Project Image/non_bridal_package.png"> 
        <img src="Project Image/bridal_package.png">        
	</section>
	<br><br><br>

    <!-- Gallery -->
	<h1 id="Gallery" class="heading">
		Gallery
	</h1>
    @if($gallery->isNotEmpty())
	    <section class="Gallery">
            @foreach($gallery as $gallery)
                <img class="gallery_photo" src= "Artist Gallery/{{$gallery->img_name}}">
            @endforeach 
	    </section>
    @else
        <section class="Error">
            <p><i class="fa-solid fa-circle-exclamation"></i> There is no photo uploaded yet</p>
	    </section>
    @endif
	<br><br><br>

    <!-- Ratings -->
	<h1 id="Ratings" class="heading">
		Ratings
	</h1>
    @if($feedback->isNotEmpty())
	    <section class="Ratings">
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
	    </section>
    @else
        <section class="Error">
            <p><i class="fa-solid fa-circle-exclamation"></i> There is no photo uploaded yet</p>
	    </section>
    @endif
    <br><br><br><br><br><br>

	<!-- footer -->
	<footer id="Contact_Us">
		<div class="Contact_Us">
			<div class="contact_us_container">
				<h1>Contact Us</h1>

				<p>
				 	<a href="mailto:priyanka.programming@gmail.com" target="_blank" >
						<span class="las la-envelope"></span>
                        priyanka.programming@gmail.com
					</a>
				 	<br>

				 	<a href="tel:+8801641496294">
						<span class="las la-phone"></span>
                        +8801641496294
					</a>
				 	<br>

				 	<a href="https://wa.me/+8801641496294" target="_blank" >
						<span class="lab la-whatsapp"></span>
                        +880-1641496294
					</a>
				 	<br>
			    </p>	
			</div>

			<div class="contact_us_container">
				<h1>Follow Us</h1>

				<div class="follow">
					<a href="https://www.facebook.com/priyanka.kashem" target="_blank" >
					    <span class="lab la-facebook"></span>
					</a>

				    <a href="https://www.instagram.com/priyankakashem/" target="_blank" >
						<span class="lab la-instagram"></span>
					</a>

					<a href="https://www.youtube.com/channel/UC5hfk7e1_L_AIWxAWZyRqJQ" target="_blank" >
						<span class="lab la-youtube"></span>
					</a>
				</div>
			</div>

            <div class="contact_us_container">
			
			</div>
		</div>

		<div class="footer">
			<p>You are not logged in</p>	
		</div>
	</footer>

    <!-- top arrow -->
    <a class="top-arrow" href="#banner">
        <i class="fa-solid fa-angle-up"></i>
    </a>
    <a class="messenger" href="https://m.me/priyanka.kashem" target="_blank">
        <i class="fa-brands fa-facebook-messenger"></i>
    </a>
    <script>
        window.addEventListener('scroll', function() {
            var scrollPosition = window.scrollY || window.pageYOffset;

            if (scrollPosition > document.querySelector('.banner').clientHeight ) {
                document.querySelector('.top-arrow').style.visibility = 'visible'; 
            } else {
                document.querySelector('.top-arrow').style.visibility = 'hidden';
            }
        });
    </script>




</body>
</html>
