<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      background: #f6f9fc;
      color: #333;
      padding: 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 40px;
    }

    h2 {
      text-align: center;
      margin-bottom: 15px;
      color: #2d3748;
    }

    form {
      background: #fff;
      padding: 25px;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.06);
      width: 100%;
      max-width: 500px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #4a5568;
    }

    input[type="text"],
    input[type="file"],
    textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      outline: none;
      transition: border 0.2s;
    }

    input[type="text"]:focus,
    textarea:focus {
      border-color: #3182ce;
    }

    textarea {
      resize: vertical;
      min-height: 80px;
    }

    .preview {
      margin-top: 10px;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .preview img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 10px;
      border: 2px solid #edf2f7;
    }

    button {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 12px;
      background: linear-gradient(135deg, #63b3ed, #3182ce);
      color: #fff;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }
  </style>
</head>
<body>

  <!-- Category Add Form -->
    <form id="categoryForm" action="{{ route('createCategory') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h2>Add Category</h2>
        <div class="form-group">
            <label for="categoryName">Category Name</label>
            <input type="text" id="categoryName" name="name" placeholder="Enter category name" required>
        </div>
        <div class="form-group">
            <label for="categoryImage">Category Image</label>
            <input type="file" id="categoryImage" name="category_image" accept="image/*" required>
            <div class="preview" id="categoryPreview"></div>
        </div>
        <button type="submit">Add Category</button>
    </form>

  <!-- Slider Upload Form -->
  <form id="sliderForm" method="POST" action="{{route('createSlider')}}" enctype="multipart/form-data">
    @csrf
    <h2>Slider Upload</h2>
    <div class="form-group">
      <label for="sliderImages">Upload Images</label>
      <input type="file" id="sliderImages" name="slider_image" accept="image/*" required>
      <div class="preview" id="sliderPreview"></div>
    </div>
    <div class="form-group">
      <label for="sliderTitle">Slider Title</label>
      <input type="text" id="sliderTitle" name="slider_title" placeholder="Enter slider title" required>
    </div>
    <div class="form-group">
      <label for="sliderDesc">Slider Description</label>
      <textarea id="sliderDesc" name="slider_description" placeholder="Enter slider description"></textarea>
    </div>
    <div class="form-group">
      <label for="sliderLink">Slider Link</label>
      <input type="text" id="sliderLink" name="slider_link" placeholder="https://example.com">
    </div>
    <button type="submit">Upload Slider</button>
  </form>

  <script>
    // Preview category image
    document.getElementById("categoryImage").addEventListener("change", function(e) {
      const preview = document.getElementById("categoryPreview");
      preview.innerHTML = "";
      if (e.target.files.length > 0) {
        const file = e.target.files[0];
        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        preview.appendChild(img);
      }
    });

    // Preview multiple slider images
    document.getElementById("sliderImages").addEventListener("change", function(e) {
      const preview = document.getElementById("sliderPreview");
      preview.innerHTML = "";
      Array.from(e.target.files).forEach(file => {
        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        preview.appendChild(img);
      });
    });

    // // Example form handlers
    // document.getElementById("categoryForm").addEventListener("submit", function(e) {
    //   e.preventDefault();
    //   alert("Category submitted!");
    // });

    // document.getElementById("sliderForm").addEventListener("submit", function(e) {
    //   e.preventDefault();
    //   alert("Slider submitted!");
    // });
  </script>
</body>
</html>
