<script>
    if(navigator.onLine) {
        if (senha = prompt("Senha:")) {
            toast("Atualizando Sistema...", 100000);
            AJAX.post("config/updateSystem", {pass: senha}).then(g => {
                if (g) {
                    localStorage.removeItem('update');
                    checkUpdate().then(() => {
                        location.href = HOME;
                    })
                } else {
                    toast("Senha inválida", 2000, "toast-warning");
                }
            })
        }
    }
</script>