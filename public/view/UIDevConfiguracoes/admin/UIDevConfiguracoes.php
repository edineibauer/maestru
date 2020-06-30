<?php
$conf = json_decode(file_get_contents(PATH_HOME . "_config/config.json"), true);

?>
<header class="container">
    <h5>
        <b><i class="material-icons left padding-right">settings_ethernet</i> <span class="left">Configurações Administrativas</span></b>
    </h5>
</header>
<div class="col padding-32">
    <div class="left container">
        <label class="col card padding-medium padding-16">
            <input type="checkbox" class="left margin-left" id="homepage"
                   value="<?= $conf['homepage'] ?>" <?= ($conf['homepage'] ? "checked='checked'" : "") ?>/>
            <div class="font-medium left padding-8 padding-right pointer">Página Inicial Admin</div>
        </label>
    </div>
    <div class="left container">
        <label class="col card padding-medium padding-16">
            <input type="checkbox" class="left margin-left" id="dev"
                   value="<?= $conf['dev'] ?>" <?= ($conf['dev'] ? "checked='checked'" : "") ?>/>
            <div class="font-medium left padding-8 padding-right pointer">Desenvolvimento</div>
        </label>
    </div>
    <div class="left container">
        <label class="col card padding-medium padding-16">
            <input type="checkbox" class="left margin-left" id="serviceworker"
                   value="<?= $conf['serviceworker'] ?>" <?= ($conf['serviceworker'] ? "checked='checked'" : "") ?>/>
            <div class="font-medium left padding-8 padding-right pointer">ServiceWorker</div>
        </label>
    </div>
    <div class="left container">
        <label class="col card padding-medium" style="padding-bottom: 0!important;width: 160px;">
            <span class="col align-left">Limite de Registros Offline</span>
            <input type="number" style="margin-bottom: 10px;" step="50" class="left" id="limitoffline" value="<?= $conf['limitoffline'] ?>"/>
            <span class="input-bar"></span>
        </label>
    </div>
</div>

<section class="col padding-8 border-bottom">
    <div class="container">
        <div class="left padding-small padding-16">
            <button id="clear-cache" class="btn hover-shadow margin-0 opacity hover-opacity-off left">
                <i class="material-icons left padding-right" title="Atualiza as bibliotecas e aplica as alterações no sistema">info</i>
                <span class="left padding-tiny">Atualizar Bibliotecas</span>
            </button>
            <button id="create-bundle" class="btn hover-shadow opacity hover-opacity-off left" style="margin-left: 10px">
                <i class="material-icons left padding-right" title="Cria uma versão de produção front-end do sistema">info</i>
                <span class="left padding-tiny">Criar App Front-end</span>
            </button>
        </div>
    </div>
</section>