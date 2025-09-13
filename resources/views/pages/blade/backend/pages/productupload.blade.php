<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Upload Form</title>
  <script src="https://cdn.tiny.cloud/1/rbjlullpzhi1phyw0yscmwkjuqrpedzy0b4esgkdrwqbt0hs/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      display: flex;
      justify-content: center;
      padding: 30px;
    }

    .form-container {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 650px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 6px;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      outline: none;
      font-size: 14px;
    }

    input[type="checkbox"] {
      width: auto;
      margin-right: 8px;
    }

    .checkbox-group {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    #imagePreview {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    #imagePreview img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
      border: 1px solid #ddd;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Upload Product</h2>
    <form id="productForm">
      
      <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" id="name" name="name" required>
      </div>

      <div class="form-group">
        <label for="images">Product Images</label>
        <input type="file" id="images" name="images" accept="image/*" multiple required>
        <div id="imagePreview"></div>
      </div>

      <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="category" required>
          <option value="">-- Select Category --</option>
          <option value="clothing">Clothing</option>
          <option value="electronics">Electronics</option>
          <option value="accessories">Accessories</option>
          <option value="home">Home</option>
        </select>
      </div>

      <div class="form-group">
        <label for="price">Price ($)</label>
        <input type="number" id="price" name="price" min="0" step="0.01" required>
      </div>

      <div class="form-group">
        <label for="size">Size</label>
        <input type="text" id="size" name="size" placeholder="e.g. S, M, L, XL">
      </div>

      <div class="form-group">
        <label for="specification">Specification</label>
        <textarea id="specification" name="specification"></textarea>
      </div>

      <div class="form-group checkbox-group">
        <label><input type="checkbox" id="is_fav" name="is_fav"> Favorite</label>
        <label><input type="checkbox" id="in_stock" name="in_stock" checked> In Stock</label>
      </div>

      <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status" required>
          <option value="draft">Draft</option>
          <option value="active">Active</option>
          <option value="archived">Archived</option>
        </select>
      </div>

      <button type="submit">Submit Product</button>
    </form>
  </div>

  <script>
    // Initialize TinyMCE for specification field
    tinymce.init({
      selector: '#specification',
      height: 250,
      menubar: false,
      plugins: 'lists link image preview code',
      toolbar: 'undo redo | bold italic underline | bullist numlist | link image | preview code',
      branding: false
    });

    // Image preview
    const imagesInput = document.getElementById("images");
    const previewContainer = document.getElementById("imagePreview");
    const form = document.getElementById("productForm");

    imagesInput.addEventListener("change", () => {
      previewContainer.innerHTML = "";
      [...imagesInput.files].forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
          const img = document.createElement("img");
          img.src = e.target.result;
          previewContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
    });

    // Form submission
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      tinymce.triggerSave(); // Save TinyMCE content back to textarea
      const formData = new FormData(form);

      // Debug: Show form data in console
      for (let [key, value] of formData.entries()) {
        console.log(key, value);
      }

      alert("Product submitted successfully!");
    });
  </script>
</body>
</html>
