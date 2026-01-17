
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
    const data = { type };

    // Convert FormData to object
    formData.forEach((value, key) => {
        data[key] = value;
    });

    // Disable submit button
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = "Wird gesendet...";

    // Send to backend
    fetch("/api/submit-form", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((result) => {
            if (result.success) {
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
            } else {
                alert("Fehler: " + result.message);
            }
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

    // Form submissions
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", function (e) {
            const formId = this.parentElement.id;
            const type = formId === "bewohner-form" ? "bewohner" : "investor";
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
