"use strict";

function warning_alert(pMessage) {
    Swal.fire({
        title: "Warning",
        text: pMessage,
        icon: "warning",
    });
}

function error_message(pMessage) {
    Swal.fire({
        title: "Error",
        text: pMessage,
        icon: "error",
    });
}

function noload_success(pMessage) {
    $("#nb-global-spinner").fadeOut(1000);
    Swal.fire({
        title: "Success",
        text: pMessage,
        icon: "success",
    });
}

function post_message(pMessage) {
    $("#nb-global-spinner").fadeOut();
    Swal.fire({
        title: "Success",
        text: pMessage,
        icon: "success",
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
        }
    });
}
