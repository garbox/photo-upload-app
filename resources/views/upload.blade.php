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
      max-height: 200px;
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
            <div class="form-text">Max file size: 10MB. Supported formats: JPG, PNG, JPEG.</div>
          </div>
          
          <button type="submit" class="btn btn-primary w-100">Upload</button>
          @if (session('success'))
              <div class="alert alert-success mt-3">
                  {{ session('success') }}
              </div>
          @endif
          @if ($errors->any())
          <div class="alert alert-danger mt-3">
                  {{ $errors }}
              </div>
          @endif
        </form>
        <div class="d-none d-md-block">
        <h3 class="text-center">Photo on your phone? Scan Here!</h3>
        <div class="d-flex justify-content-center">
          {{ QRCode::url(url()->current() . "/" . session()->getID())->setsize(5)->svg() }}
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

</body>
</html>
