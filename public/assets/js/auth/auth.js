"use strict";
function setEncryptedItem(key, value) {
    const encrypted = CryptoJS.AES.encrypt(
        JSON.stringify(value),
        secretKey
    ).toString();
    localStorage.setItem(key, encrypted);
}

function getDecryptedItem(key) {
    const encrypted = localStorage.getItem(key);
    if (!encrypted) return null;

    try {
        const bytes = CryptoJS.AES.decrypt(encrypted, secretKey);
        const decrypted = bytes.toString(CryptoJS.enc.Utf8);
        return JSON.parse(decrypted); // original value
    } catch (e) {
        console.error("Decryption failed:", e);
        return null;
    }
}

$(window).on("load", function () {
    if (
        localStorage.hasOwnProperty("User_Name") &&
        localStorage.hasOwnProperty("AbCDS")
    ) {
        var pUname = getDecryptedItem("User_Name");
        var xxx = getDecryptedItem("AbCDS");

        $("#user_name").val(pUname);
        $("#user_pass").val(xxx);
        $("#remember_me").prop("checked", true);
    }
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    error: function (xhr) {
        let message = xhr.responseJSON?.message || "Something went wrong!";
        error_message(message);
    },
});

function proc_login() {
    var pUser_Name = $("#user_name").val();
    var pUser_Pass = $("#user_pass").val();

    if (pUser_Name == "") {
        $("#user_name").focus();
        warning_alert("Please Enter User Name !!");
    } else if (pUser_Pass == "") {
        $("#user_pass").focus();
        warning_alert("Please Enter Password !!");
    } else {
        $.ajax({
            url: baseUrl + "/UserLogin", // Replace with your route
            type: "POST", // GET or POST
            data: {
                user_name: pUser_Name,
                user_pass: pUser_Pass,
            }, // Data to send
            dataType: "json", // Expected response
            beforeSend: function () {
                // Optional: show loader
                $("#nb-global-spinner").fadeIn();
            },
            success: function (response) {
                // Handle success response
                if (response.status === "success") {
                    if ($("#remember_me").prop("checked") == true) {
                        setEncryptedItem("User_Name", pUser_Name);
                        setEncryptedItem("AbCDS", pUser_Pass);
                    } else {
                        localStorage.removeItem("User_Branch");
                        localStorage.removeItem("User_Name");
                        localStorage.removeItem("AbCDS");
                    }

                    location.replace(baseUrl + "/Dashboard");
                } else {
                    // If server returns error in JSON
                    error_message(response.message || "Something went wrong!");
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                let errorMessage =
                    "Error: " +
                    (xhr.responseJSON?.message || error || "Unknown error");
                console.error(errorMessage);
                error_message(errorMessage);
            },
            complete: function () {
                $("#nb-global-spinner").fadeOut();
            },
        });
    }
}
