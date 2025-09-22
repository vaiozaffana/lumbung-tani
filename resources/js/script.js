document.addEventListener("DOMContentLoaded", function () {
  // Set current date
  const now = new Date();
  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  document.getElementById("current-date").textContent = now.toLocaleDateString(
    "id-ID",
    options
  );

  // Sidebar toggle functionality
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.getElementById("main-content");
  const sidebarToggle = document.getElementById("sidebar-toggle");
  const overlay = document.getElementById("overlay");

  sidebarToggle.addEventListener("click", function () {
    if (window.innerWidth < 992) {
      sidebar.classList.toggle("mobile-expanded");
      overlay.style.display = sidebar.classList.contains("mobile-expanded")
        ? "block"
        : "none";
    } else {
      sidebar.classList.toggle("collapsed");
      mainContent.classList.toggle("expanded");
    }
  });

  // Close sidebar when clicking on overlay (mobile view)
  overlay.addEventListener("click", function () {
    sidebar.classList.remove("mobile-expanded");
    overlay.style.display = "none";
  });

  // Page navigation
  const menuLinks = document.querySelectorAll(".menu-link");
  const pageContents = document.querySelectorAll(".page-content");

  menuLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      // Remove active class from all links
      menuLinks.forEach((l) => l.classList.remove("active"));
      // Add active class to clicked link
      this.classList.add("active");

      // Hide all pages
      pageContents.forEach((page) => page.classList.add("d-none"));

      // Show selected page
      const pageId = `${this.dataset.page}-page`;
      document.getElementById(pageId).classList.remove("d-none");

      // Close sidebar on mobile after selection
      if (window.innerWidth < 992) {
        sidebar.classList.remove("mobile-expanded");
        overlay.style.display = "none";
      }
    });
  });

  // Table sorting functionality
  const tableHeaders = document.querySelectorAll("th[data-sort]");

  tableHeaders.forEach((header) => {
    header.addEventListener("click", function () {
      const sortBy = this.dataset.sort;
      const currentlySorted =
        this.classList.contains("sort-asc") ||
        this.classList.contains("sort-desc");
      const newSortDirection =
        currentlySorted && this.classList.contains("sort-asc") ? "desc" : "asc";

      // Remove sort classes from all headers
      tableHeaders.forEach((h) => {
        h.classList.remove("sort-asc", "sort-desc");
      });

      // Add appropriate class to clicked header
      this.classList.add(`sort-${newSortDirection}`);

      // In a real application, you would sort the data here
      console.log(`Sorting by ${sortBy} in ${newSortDirection} order`);
    });
  });

  // Search functionality
  const productSearch = document.getElementById("productSearch");

  productSearch.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll("#productsTable tbody tr");

    rows.forEach((row) => {
      const productName = row.cells[1].textContent.toLowerCase();
      if (productName.includes(searchTerm)) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });

  // Image upload preview
  const uploadTrigger = document.getElementById("uploadTrigger");
  const productImage = document.getElementById("productImage");
  const previewImage = document.getElementById("previewImage");
  const imagePreview = document.getElementById("imagePreview");

  uploadTrigger.addEventListener("click", function () {
    productImage.click();
  });

  productImage.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();

      reader.addEventListener("load", function () {
        previewImage.src = reader.result;
        previewImage.style.display = "block";
        imagePreview.querySelector(".upload-placeholder").style.display =
          "none";
      });

      reader.readAsDataURL(file);
    }
  });

  // Edit product functionality
  const editButtons = document.querySelectorAll(".edit-product");

  editButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const row = this.closest("tr");
      const code = row.cells[0].textContent;
      const name = row.cells[1].textContent;
      const unit = row.cells[2].textContent;
      const price = row.cells[3].textContent
        .replace("Rp ", "")
        .replace(".", "");

      document.getElementById("editProductCode").value = code;
      document.getElementById("editProductName").value = name;
      document.getElementById("editProductUnit").value = unit.toLowerCase();
      document.getElementById("editProductPrice").value = price;
    });
  });

  // Edit image upload preview
  const editUploadTrigger = document.getElementById("editUploadTrigger");
  const editProductImage = document.getElementById("editProductImage");

  editUploadTrigger.addEventListener("click", function () {
    editProductImage.click();
  });

  editProductImage.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();

      reader.addEventListener("load", function () {
        document.getElementById("editPreviewImage").src = reader.result;
      });

      reader.readAsDataURL(file);
    }
  });

  // Form submission handlers (would connect to backend in real application)
  document
    .getElementById("submitProduct")
    .addEventListener("click", function () {
      // Validate and submit form
      const form = document.getElementById("addProductForm");
      if (form.checkValidity()) {
        // In a real app, you would send data to the server here
        alert("Produk berhasil ditambahkan!");
        bootstrap.Modal.getInstance(
          document.getElementById("addProductModal")
        ).hide();
        form.reset();
        previewImage.style.display = "none";
        imagePreview.querySelector(".upload-placeholder").style.display =
          "block";
      } else {
        form.reportValidity();
      }
    });

  document
    .getElementById("updateProduct")
    .addEventListener("click", function () {
      // Validate and submit form
      const form = document.getElementById("editProductForm");
      if (form.checkValidity()) {
        // In a real app, you would send data to the server here
        alert("Produk berhasil diperbarui!");
        bootstrap.Modal.getInstance(
          document.getElementById("editProductModal")
        ).hide();
      } else {
        form.reportValidity();
      }
    });

  document
    .getElementById("confirmDelete")
    .addEventListener("click", function () {
      // In a real app, you would send delete request to the server here
      alert("Produk berhasil dihapus!");
      bootstrap.Modal.getInstance(
        document.getElementById("deleteConfirmModal")
      ).hide();
    });
});

document.querySelector('[data-page="products"]').click();
