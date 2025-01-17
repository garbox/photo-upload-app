<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Photo Upload Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .upload-container {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 10px;
    }
    #image-container {
      max-width: 100%;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    .uploaded-image {
      max-width: 100%;
      max-height: 300px;
      object-fit: cover;
      border-radius: 5px;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <!-- Two Columns Layout -->
  <div class="row">
    <!-- Column for the Upload Form -->
    <div class="col-md-6">
      <div class="upload-container">
        <h2 class="text-center mb-4">Upload Your Photo</h2>

        <form action="/upload" method="post" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="photo" class="form-label">Select Photo</label>
            <input class="form-control" type="file" id="photo" name="photo" required>
            <div class="form-text">Max file size: 5MB. Supported formats: JPG, PNG, JPEG.</div>
          </div>
          
          <button onclick="Processing()" type="submit" id="submit" class="btn btn-primary w-100">Upload</button>
          <button class="btn btn-primary w-100 d-none" type="button" id="processing" disabled>
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Processing...
          </button>
          @if (session('success'))
              <div class="alert alert-success mt-3">
                  {{ session('success') }}
              </div>
          @endif

          @if ($errors->any())
          <div class="alert alert-danger mt-3">
            @foreach ($errors->get('photo') as $error)
                  {{ $error }}<br>
            @endforeach
              </div>
          @endif
        </form>
        <div class="d-none d-md-block">
        <h3 class="text-center">Photo on your phone? Scan Here!</h3>
        <div class="d-flex justify-content-center">
          {{ QRCode::url(url()->current() . "/mobile/" . session()->getID())->setsize(5)->svg() }}
        </div>
      </div>
        
      </div>
    </div>

    <!-- Column for Uploaded Images (Visible only on md and larger screens) -->
    <div class="col-md-6 d-none d-md-block">
      <div class="container">
        <h3 class="text-center mb-4">Uploaded Photos</h3>
        
        <!-- Image Display Container -->
        <div id="image-container">
          <!-- Example of uploaded images, replace with actual dynamic image data -->
          <!-- Dynamically generated images should go here -->
          @isset($photos)
            @foreach ($photos as $photo)
              <div class="image-item">
                <img src="{{asset('storage/photos/'.$photo->filename)}}" class="uploaded-image">
              </div>
            @endforeach  
          @endisset
        </div>
      </div>
    </div>
  </div>  

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
function Processing() {
  document.getElementById('processing').classList.remove('d-none');
  document.getElementById('submit').classList.add('d-none');
}
function fetchPhotos() {
    fetch('/photos')
        .then(response => response.json()) // Parse the response as JSON
        .then(data => {
            const photoGallery = document.getElementById('image-container');
            photoGallery.innerHTML = ''; // Clear the gallery before adding new photos

            // Loop through each photo and create a container with an image and caption
            data.forEach(photo => {
                // Create a div for the photo item
                const photoDiv = document.createElement('div');
                photoDiv.classList.add('image-item');
                
                // Create the image element
                const img = document.createElement('img');
                img.src = '{{asset('storage/photos/')}}' +'/' + photo.filename;  // Assuming 'file_path' contains the image path
                img.alt = 'Uploaded Photo';
                img.classList.add('uploaded-image');
                
                // Append the image and caption to the photo div
                photoDiv.appendChild(img);

                // Append the photo div to the gallery
                photoGallery.appendChild(photoDiv);
            });
        })
        .catch(error => console.error('Error fetching photos:', error));
}

// Fetch photos every 5 seconds
setInterval(fetchPhotos, 5000);
</script>
</body>
</html>
