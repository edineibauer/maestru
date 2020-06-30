function saveConfig(field, value) {
    AJAX.post("UIDev/settings/saveConfig", {field: field, value: value}).then(g => {
        if (g)
            toast("erro", 3000, "toast-warning")
    });
}

$(function () {
    $(".inputConfig").off("keyup change").on("keyup change", function () {
        saveConfig($(this).attr("id"), $(this).val())
    });
});