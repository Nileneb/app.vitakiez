
// Tab switching functionality
function switchTab(tab) {
    // Hide all tab contents
    document.querySelectorAll(".tab-content").forEach((content) => {
        content.classList.remove("active");
    });

    // Remove active class from all buttons
    document.querySelectorAll(".tab-button").forEach((button) => {
        button.classList.remove("active");
    });

    // Show selected tab content
    if (tab === "bewohner") {
        document.getElementById("bewohner-form").classList.add("active");
        document.querySelectorAll(".tab-button")[0].classList.add("active");
    } else {
        document.getElementById("investoren-form").classList.add("active");
        document.querySelectorAll(".tab-button")[1].classList.add("active");
    }
}

function submitForm(event, type) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const data = {};

    // Convert FormData to object
    formData.forEach((value, key) => {
        data[key] = value;
    });

    // Add user_type field based on form type
    data.user_type = type; // 'bewohner' or 'investor'

    // Disable submit button
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = "Wird gesendet...";

    // Send to /register endpoint (Fortify's registration route)
    fetch("/register", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]')?.content || '',
        },
        body: JSON.stringify(data),
    })
        .then((response) => {
            // Handle both successful registration and validation errors
            if (response.ok) {
                return response.json();
            } else if (response.status === 422) {
                // Validation error
                return response.json().then(result => {
                    throw new Error(JSON.stringify(result.errors));
                });
            } else {
                throw new Error("Registration failed");
            }
        })
        .then((result) => {
            // Show success message
            let successMessage;
            if (type === "bewohner") {
                successMessage = document.getElementById("b-success");
            } else {
                successMessage = document.getElementById("i-success");
            }

            successMessage.style.display = "block";
            successMessage.scrollIntoView({ behavior: "smooth", block: "nearest" });

            // Reset form
            form.reset();

            // Hide success message after 5 seconds
            setTimeout(() => {
                successMessage.style.display = "none";
            }, 5000);
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Fehler beim Versenden. Bitte versuchen Sie es später erneut oder kontaktieren Sie uns direkt.");
        })
        .finally(() => {
            // Re-enable submit button
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        });

    return false;
}

// Setup event listeners on page load
document.addEventListener("DOMContentLoaded", function () {
    // Tab buttons
    document.querySelectorAll(".tab-button").forEach((button) => {
        button.addEventListener("click", function () {
            const tab = this.getAttribute("data-tab");
            switchTab(tab);
        });
    });

    // Form submissions (scope to waitlist forms only)
    const waitlistForms = document.querySelectorAll("#bewohner-form form, #investoren-form form");
    waitlistForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            const wrapper = this.closest(".tab-content");
            if (!wrapper) return; // safety guard
            const type = wrapper.id === "bewohner-form" ? "bewohner" : "investor";
            submitForm(e, type);
        });
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });
});
