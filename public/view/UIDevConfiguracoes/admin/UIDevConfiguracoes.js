function postOptions() {
    AJAX.post("config/updateOptions", {'autosync': $("#autosync").is(":checked"), 'dev': $("#dev").is(":checked"), 'serviceworker': $("#serviceworker").is(":checked"), 'homepage': $("#homepage").is(":checked"), 'limitoffline': $("#limitoffline").val()});
}

$(function () {

    $("#app").off("click", "#clear-cache").on("click", "#clear-cache", function () {
        if(navigator.onLine) {
            if(senha = prompt("Senha:")) {
                toast("Atualizando Sistema...", 100000);
                AJAX.post("config/updateSystem", {pass: senha}).then(g => {
                    if(g) {
                        localStorage.removeItem('update');
                        checkUpdate().then(() => {
                            location.href = HOME + "dashboard";
                        })
                    } else {
                        toast("Senha inválida", 2000, "toast-warning");
                    }
                });
            }
        } else {
            toast("Sem Conexão", 2500, "toast-warning");
        }
    }).off("click", "#create-bundle").on("click", "#create-bundle", function () {
        if(navigator.onLine) {
            AJAX.post("createMaestruBundle").then(g => {
                if (g)
                    toast("App criado na pasta `bundle/`", 3000, "toast-success");
                else
                    toast("Algo deu errado", 2000, "toast-warning");
            });
        }
    });

    $("#autosync, #homepage, #limitoffline, #serviceworker, #dev").off("change keyup").on("change keyup", function() {
        postOptions();
    });
})