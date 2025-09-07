    <form id="categoryForm" action="{{ route('createCategory') }}" method="POST" enctype="multipart/form-data">
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
