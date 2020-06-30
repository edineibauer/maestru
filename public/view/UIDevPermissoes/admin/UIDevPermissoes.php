<header class="container">
    <h5 class="left">
        <b><i class="material-icons left padding-right">assignment_turned_in</i> <span class="left">Gerenciamento de Permissões CRUD para Usuários</span></b>
    </h5>
</header>

<section class="col padding-32 border-bottom">
    <div class="container">
        <div class="left padding-right" style="width: 160px">
            <div class="col card">
                <header class="container color-gray-light" style="height: 106px;">
                    <h1 class="font-large">Entidades</h1>

                    <div class="container padding-0 padding-12" style="padding-bottom: 17px!important;">
                        Permissões
                    </div>
                </header>

                <div id="list-entity"></div>
            </div>
        </div>
        <div class="rest" style="overflow-x: scroll">
            <div class="col margin-right" style="width: 10000px;" id="permissao-container">

                <div class="left padding-right" style="width: 75px">
                    <div class="col card">
                        <header class="col padding-small color-gray-light"
                                style="height: 106px;padding-top: 0!important;">
                            <h1 class="font-large">ADM</h1>

                            <div class="container padding-0" style="padding-left: 5px!important;">
                                <div title="menu" class="padding-tiny left">
                                    <i class="material-icons">menu</i>
                                </div>
                            </div>
                        </header>

                        <div class="col" id="adm-allow-menu"></div>
                    </div>
                </div>

                <div class="left" id="permissao"></div>
            </div>
        </div>
    </div>
</section>