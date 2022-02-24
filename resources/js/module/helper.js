window.Swal = require("sweetalert2");
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});
window.serializeObject = function (obj) {
    var jsn = {};
    $.each(obj, function () {
        if (jsn[this.name]) {
            if (!jsn[this.name].push) {
                jsn[this.name] = [jsn[this.name]];
            }
            jsn[this.name].push(this.value || "");
        } else {
            jsn[this.name] = this.value || "";
        }
    });
    return jsn;
};

window.ToastNotification = function (info,message) {
    Toast.fire({
        icon: info,
        title: message,
    });
};