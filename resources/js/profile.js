$(function () {
    document
        .getElementById("confirm-password")
        .addEventListener("input", function () {
            const password = document.getElementById("password").value.trim();
            const confirmPassword = this.value.trim();

            if (password === confirmPassword) {
                this.setCustomValidity("");
                document.querySelector(
                    "#confirm-password+.custom-invalid-feedback"
                ).style.display = "none";
            } else {
                this.setCustomValidity("Passwords do not match");
                document.querySelector(
                    "#confirm-password+.custom-invalid-feedback"
                ).style.display = "block";
            }
        });

    $("form[name='profile']").submit(function (e) {
        e.preventDefault();
        this.classList.add("was-validated");
        $(e.target).find(".alert-danger").addClass("d-none");

        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirm-password");
        const confirmPasswordInvalid = document.querySelector(
            "#confirm-password+.custom-invalid-feedback"
        );

        if (password.value.trim() !== confirmPassword.value.trim()) {
            confirmPassword.setCustomValidity("Passwords do not match");
            confirmPasswordInvalid.style.display = "block";
        } else {
            confirmPassword.setCustomValidity("");
            confirmPasswordInvalid.style.display = "none";
        }

        if (this.checkValidity()) {
            $.ajax({
                method: "PUT",
                url: "/api/user",
                data: Object.fromEntries(new FormData(this)),
            })
                .done(function () {
                    alert("Account updated successfully!");
                    setTimeout(() => location.reload(), 888);
                })
                .fail(function (err) {
                    $(e.target)
                        .find(".alert-danger")
                        .html(
                            Object.keys(err.responseJSON.errors)
                                .map((e) =>
                                    err.responseJSON.errors[e].join("<br/>")
                                )
                                .join("<br/>")
                        )
                        .removeClass("d-none");
                });
        }
    });
});
