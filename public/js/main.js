// Main JavaScript untuk Mission 4 - DOM & Event Handling
function getElementById(id) {
    return document.getElementById(id);
}

function querySelector(selector) {
    return document.querySelector(selector);
}

// Active Menu State
function setActiveMenu() {
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll(".nav-link");

    menuLinks.forEach((link) => {
        const href = link.getAttribute("href");
        if (
            currentPath.includes(href) ||
            (currentPath === "/" && href.includes("dashboard"))
        ) {
            link.parentElement.classList.add("active");
        } else {
            link.parentElement.classList.remove("active");
        }
    });
}

// Custom Delete Confirmation Dialog
function showDeleteConfirmation(type, name, callback) {
    const modal = document.createElement("div");
    modal.className = "modal fade";
    modal.id = "deleteModal";
    modal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle"></i> Confirm Delete
                    </h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this ${type}?</p>
                    <div class="alert alert-warning">
                        <strong>${type}:</strong> ${name}
                    </div>
                    <p class="text-muted">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    $("#deleteModal").modal("show");

    getElementById("confirmDelete").addEventListener("click", function () {
        $("#deleteModal").modal("hide");
        setTimeout(() => {
            document.body.removeChild(modal);
            callback();
        }, 300);
    });

    $("#deleteModal").on("hidden.bs.modal", function () {
        if (modal.parentNode) {
            document.body.removeChild(modal);
        }
    });
}

// Initialize saat DOM loaded
document.addEventListener("DOMContentLoaded", function () {
    setActiveMenu();
});
