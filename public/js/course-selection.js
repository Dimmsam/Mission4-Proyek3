// Student Course Selection dengan Multiple Choice & SKS Calculator

// Array untuk store selected courses
let selectedCourses = [];

// Calculate total SKS dari courses yang dipilih
function calculateTotalSKS() {
    const checkboxes = document.querySelectorAll(
        'input[name="course_ids[]"]:checked'
    );
    let totalSKS = 0;

    selectedCourses = [];
    checkboxes.forEach((checkbox) => {
        const sks = parseInt(checkbox.getAttribute("data-credits"));
        const courseName = checkbox.getAttribute("data-course-name");
        totalSKS += sks;

        selectedCourses.push({
            id: checkbox.value,
            name: courseName,
            credits: sks,
        });
    });

    // Update total display
    const totalDisplay = getElementById("totalSKS");
    if (totalDisplay) {
        totalDisplay.textContent = totalSKS;

        // Color coding
        if (totalSKS > 24) {
            totalDisplay.className = "badge badge-danger badge-lg";
        } else if (totalSKS > 18) {
            totalDisplay.className = "badge badge-warning badge-lg";
        } else {
            totalDisplay.className = "badge badge-success badge-lg";
        }
    }

    // Update course count
    const courseCount = getElementById("courseCount");
    if (courseCount) {
        courseCount.textContent = selectedCourses.length;
    }

    // Enable/disable submit button (optional - allow manual testing)
    const submitBtn = getElementById("enrollBtn");
    if (submitBtn) {
        // Only disable if no courses selected and user tried to submit
        // Keep enabled for debugging purposes
        if (selectedCourses.length === 0) {
            submitBtn.classList.add("btn-secondary");
            submitBtn.classList.remove("btn-success");
        } else {
            submitBtn.classList.add("btn-success");
            submitBtn.classList.remove("btn-secondary");
        }
    }

    // Update selected courses list
    updateSelectedCoursesList();
}

// Update daftar courses yang dipilih
function updateSelectedCoursesList() {
    const listContainer = getElementById("selectedCoursesList");
    if (!listContainer) return;

    if (selectedCourses.length === 0) {
        listContainer.innerHTML =
            '<p class="text-muted">No courses selected</p>';
        return;
    }

    let html = '<div class="list-group">';
    selectedCourses.forEach((course) => {
        html += `
            <div class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">${course.name}</h6>
                    <span class="badge badge-primary">${course.credits} SKS</span>
                </div>
            </div>
        `;
    });
    html += "</div>";

    listContainer.innerHTML = html;
}

// Validate course selection
function validateCourseSelection() {
    const checkboxes = document.querySelectorAll(
        'input[name="course_ids[]"]:checked'
    );

    if (checkboxes.length === 0) {
        alert("Please select at least one course to enroll");
        return false;
    }

    const totalSKS = selectedCourses.reduce(
        (sum, course) => sum + course.credits,
        0
    );
    if (totalSKS > 24) {
        return confirm(
            `Total SKS (${totalSKS}) exceeds recommended limit of 24 SKS. Continue anyway?`
        );
    }

    return true;
}

// Setup course selection events
function initializeCourseSelection() {
    const checkboxes = document.querySelectorAll('input[name="course_ids[]"]');
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", calculateTotalSKS);
    });

    // Setup form submission
    const enrollForm = getElementById("multiEnrollForm");
    if (enrollForm) {
        enrollForm.addEventListener("submit", function (e) {
            console.log("Form submission started");
            debugCourseSelection();

            if (!validateCourseSelection()) {
                e.preventDefault();
                return;
            }

            // Refresh CSRF token sebelum submit
            refreshCSRFToken();

            // Find submit button
            const submitButton = enrollForm.querySelector(
                'button[type="submit"]'
            );
            if (submitButton) {
                // Show loading state
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i> Enrolling...';
                submitButton.disabled = true;

                console.log(
                    "Form submitting with data:",
                    new FormData(enrollForm)
                );
                // Let form submit normally (don't prevent default)
                // The loading state will be visible until page redirects
            }
        });
    }

    // Initial calculation
    calculateTotalSKS();
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector('input[name="course_ids[]"]')) {
        initializeCourseSelection();
    }
});
