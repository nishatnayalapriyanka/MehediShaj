<!DOCTYPE html>
<html>
<head>
	<title>MehediShaj</title>
	<link rel="stylesheet" href="CSS/Artist/artist_sidebar.css">
    <link rel="stylesheet" href="CSS/Artist/artist_gallery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    
    <nav>
        <div class="menu">
            <label for="menu" class="las la-bars"></label>
            <img class="logo" src="Project Image/MehediShaj_logo.png">		    
	    </div>
        
	    <div class="profile">		    
            <img src="Artist Profile Picture/{{session('artist_profile_pic')}}">
		    <span>{{session('artist_name')}}</span>
	    </div>			
    </nav>

    <main>
        <input type="checkbox" id="menu">
        <div class="sidebar">

		    <a href="/artist_dashboard" class="option">
			    <div>
				    <span class="las la-home"></span>
           		    <span class="sidebar_text" >Dashboard</span>
			    </div>
            </a>

            <a href="/artist_profile" class="option">
        	    <div >
        		    <i class="las la-user-alt"></i>
           		    <span class="sidebar_text">Profile</span>
        	    </div>			
            </a>

            <a href="" class="selected_option">
        	    <div >
        		    <i class="las la-image"></i>
           		    <span class="sidebar_text">Gallery</span>
        	    </div>			
            </a>

            <a href="/artist_appointments" class="option">
        	    <div>
        		    <span class="las la-calendar-day"></span>
            	    <span class="sidebar_text">My Appointments</span>
        	    </div>			
            </a>

            <a href="artist_help" class="option">
        	    <div>
        		    <i class="las la-question-circle"></i>
            	    <span class="sidebar_text">Help</span>
        	    </div>			
            </a>

            <a href="/artist_logout" class="option">
        	    <div>
        		    <span class="las la-sign-out-alt"></span>
            	    <span class="sidebar_text">Log Out</span>
        	    </div>			
            </a>
	    </div>

        <div class="main_section">

            <form method="post" action="/artist_add_gallery" enctype="multipart/form-data">
                @csrf
                <br><br><br>
	            <label for="artist_add_gallery" class="artist_add_gallery_Upload">
                    <img src="" id="preview_gallery">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <p>Browse image to upload</p>
                    <input id="artist_add_gallery" type="file" name="artist_add_gallery" onchange="previewGallery(this)" accept="image/*">
                </label>    
                <div class="errorMsg">
                    @error('artist_add_gallery')
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                    @enderror
                </div>
                <br>

                <input class="button" type="submit" value="Save to Gallery">
                <br><br><br>                  
            </form>


            <div class="gallery_conatiner">
                @foreach($gallery as $gallery)
                    <form method="post" action="/artist_delete_gallery">
                        @csrf
                        <input type="checkbox" id="{{$gallery->img_name}}">
                        
                        <label for="{{$gallery->img_name}}">
                            <img class="gallery_photo" src= "Artist Gallery/{{$gallery->img_name}}">

                            <input type="hidden" name="img_name" value="{{$gallery->img_name}}">
                            <input type="image" src="https://img.icons8.com/ios-glyphs/18/FFFFFF/delete-sign.png"  class="image_button">
                        </label>
                        <!-- src="https://img.icons8.com/sf-regular-filled/30/FFFFFF/trash.png"
                        dustbin icon image-->
                    </form>
                @endforeach     
            </div>
            <br><br><br>

            <!-- from template -->
	        <script src="JS/Artist/artist_image_upload.js"> </script>
	        <!-- from template -->

        </div>
    </main>

</body>
</html>



