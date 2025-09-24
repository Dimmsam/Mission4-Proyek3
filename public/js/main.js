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
    const menuItems = document.querySelectorAll(".nav-item");

    menuItems.forEach((item) => {
        const link = item.querySelector(".nav-link");
        if (link) {
            const href = link.getAttribute("href");

            // Remove active class first
            item.classList.remove("active");

            // Check if current path matches the menu item
            if (
                currentPath === href ||
                (currentPath.includes("/admin/students") &&
                    href.includes("/admin/students")) ||
                (currentPath.includes("/admin/courses") &&
                    href.includes("/admin/courses")) ||
                (currentPath.includes("/student/courses") &&
                    href.includes("/student/courses") &&
                    !href.includes("my-courses")) ||
                (currentPath.includes("/student/my-courses") &&
                    href.includes("/student/my-courses")) ||
                (currentPath.includes("/dashboard") &&
                    href.includes("/dashboard")) ||
                (currentPath === "/" && href.includes("dashboard"))
            ) {
                item.classList.add("active");
            }
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

// Utility function untuk create auto-hide notification programmatically
function showNotification(message, type = "success", duration = 4000) {
    const container = document.querySelector(".container-fluid");
    if (!container) return;

    const alertDiv = document.createElement("div");
    alertDiv.className = `alert alert-${type} fade show`;
    alertDiv.setAttribute("role", "alert");

    const typeText =
        type === "success"
            ? "Success!"
            : type === "danger"
            ? "Error!"
            : "Info!";
    alertDiv.innerHTML = `<strong>${typeText}</strong> ${message}`;

    // Insert at the beginning of container
    container.insertBefore(alertDiv, container.firstChild);

    // Auto-hide dengan animation
    setTimeout(function () {
        alertDiv.style.transition =
            "opacity 0.5s ease-out, transform 0.5s ease-out";
        alertDiv.style.opacity = "0";
        alertDiv.style.transform = "translateY(-10px)";

        setTimeout(function () {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 500);
    }, duration);
}

// Initialize saat DOM loaded
document.addEventListener("DOMContentLoaded", function () {
    setActiveMenu();
});
