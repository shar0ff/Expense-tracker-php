// Load categories for a specific page
async function loadCategories(page = 1) {
    try {
      const response = await fetch(`$../categories/getPagedCategories.php?page=${page}`);
      const data = await response.json();
      updateCategoryTable(data.categories);
      updatePagination(data.totalPages, data.currentPage);
    } catch (error) {
      console.error("Error fetching categories:", error);
    }
}

// Update the Category table with new data
function updateCategoryTable(categories) {
    const tbody = document.querySelector("table[class='category-table'] tbody");
    tbody.innerHTML = "";
  
    categories.forEach(category => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${catgory.name}</td>
        <td>${category.description}</td>
        <td>${category.type}</td>
      `;
      tbody.appendChild(row);
    });
}

// Create a pagination button
function createPaginationButton(text, isEnabled, onClick) {
    const button = document.createElement("button");
    button.textContent = text;
    button.classList.add("page-link");
    if (isEnabled) {
      button.addEventListener("click", onClick);
    } else {
      button.disabled = true;
    }
    return button;
}

// Update the pagination controls
function updatePagination(totalPages, currentPage) {
    const pagination = document.querySelector("div[class='table-pagination']");
    pagination.innerHTML = "";
  
    // First arrow
    pagination.appendChild(createPaginationButton("<<", currentPage > 1, () => loadEvents(1)));
  
    // Previous arrow
    pagination.appendChild(createPaginationButton("<", currentPage > 1, () => loadEvents(currentPage - 1)));
  
    // Page numbers
    const pageNumberContainer = document.createElement("div");
    pageNumberContainer.classList.add("page-number-container");
    for (let i = 1; i <= totalPages; i++) {
      if (i >= currentPage - 1 && i <= currentPage + 1) {
        const pageLink = createPaginationButton(i, i !== currentPage, () => loadCategories(i));
        if (i === currentPage) {
          pageLink.classList.add("active");
        }
        pageNumberContainer.appendChild(pageLink);
      } else if (i === currentPage - 2 || i === currentPage + 2) {
        const dots = document.createElement("span");
        dots.textContent = "...";
        dots.classList.add("page-dots");
        pageNumberContainer.appendChild(dots);
      }
    }
    pagination.appendChild(pageNumberContainer);
  
    // Next arrow
    pagination.appendChild(createPaginationButton(">", currentPage < totalPages, () => loadEvents(currentPage + 1)));
  
    // Last arrow
    pagination.appendChild(createPaginationButton(">>", currentPage < totalPages, () => loadEvents(totalPages)));
}
  
// Initial load
loadCategories();  
  