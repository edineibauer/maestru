var updateRelatiosCard = null, graficoData = {}, relevant = {};

function hide_sidebar_small() {
    if (screen.width < 993) {
        $("#myOverlay, #mySidebar").css("display", "none")
    }
}

function mainLoading() {
    hide_sidebar_small();
    closeSidebar()
}

function menuDashboard(count) {
    count = typeof count === "undefined" ? 0 : count;
    if (isEmpty(dicionarios)) {
        if (count > 5)
            return;

        setTimeout(function () {
            menuDashboard(count + 1);
        }, 500);
    } else {
        let allow = dbLocal.exeRead("__allow", 1);
        let info = dbLocal.exeRead("__info", 1);
        let templates = getTemplates();
        Promise.all([allow, info, templates]).then(r => {
            allow = r[0];
            info = r[1];
            templates = r[2];
            let menu = [];
            let indice = 1;

            $.each(dicionarios, function (entity, meta) {
                if (typeof allow !== "undefined" && typeof allow[entity] !== "undefined" && typeof allow[entity].menu !== "undefined" && allow[entity].menu) {
                    nome = ucFirst(replaceAll(replaceAll(entity, "_", " "), "-", " "));
                    menu.push({
                        indice: indice,
                        icon: (info[entity].icon !== "" ? info[entity].icon : "storage"),
                        title: nome,
                        table: !0,
                        link: !1,
                        form: !1,
                        page: !1,
                        file: '',
                        lib: '',
                        entity: entity
                    });
                    indice++
                }
            });

            menu.sort(dynamicSort('indice'));
            $("#dashboard-menu").html("");
            let tpl = (menu.length < 4 ? templates.menuCard : templates.menuLi);
            $.each(menu, function (i, m) {
                $("#dashboard-menu").append(Mustache.render(tpl, m))
            });
        })
    }
}

function dashboardSidebarInfo() {
    if (isEmpty(USER.imagem) || USER.imagem === "null") {
        $("#dashboard-sidebar-imagem").html("<i class='material-icons font-jumbo'>people</i>");
    } else {
        let imagem = "";
        if (typeof USER.imagem === "string") {
            if (isJson(USER.imagem))
                imagem = decodeURIComponent(JSON.parse(USER.imagem)[0]['urls'][100]);
            else
                imagem = USER.imagem;
        } else if (typeof USER.imagem === "object" && typeof USER.imagem.url === "string") {
            imagem = USER.imagem.urls[100];
        }
        $("#dashboard-sidebar-imagem").html("<img src='" + imagem + "' title='" + USER.nome + "' alt='imagem do usuário " + USER.nome + "' width='60' height='60' style='width: 60px;height: 60px' />");
    }

    $("#dashboard-sidebar-nome").html(USER.nome);
    let $sidebar = $("#core-sidebar-edit");
    $sidebar.removeClass("hide").off("click").on("click", function () {
        if (document.querySelector(".btn-edit-perfil") !== null) {
            document.querySelector(".btn-edit-perfil").click()
        } else {
            mainLoading();
            app.loadView(HOME + "dashboard");
            toast("carregando perfil...", 1300, "toast-success");
            let ee = setInterval(function () {
                if (document.querySelector(".btn-edit-perfil") !== null) {
                    setTimeout(function () {
                        document.querySelector(".btn-edit-perfil").click()
                    }, 1000);
                    clearInterval(ee)
                }
            }, 100)
        }
    })
}

async function dashboardPanelContent() {
    if(window.innerWidth > 990) {
        return dbLocal.exeRead("__panel", 1).then(panel => {
            return (typeof panel === "string" ? panel : "");
        });
    } else {
        return dbLocal.exeRead('__dicionario', 1).then(d => {

            let syncCheck = [];
            syncCheck.push(dbLocal.exeRead("__allow", 1));
            syncCheck.push(dbLocal.exeRead("__info", 1));
            syncCheck.push(getTemplates());
            syncCheck.push(dbLocal.exeRead("__panel", 1));

            return Promise.all(syncCheck).then(r => {
                allow = r[0];
                info = r[1];
                templates = r[2];
                panel = r[3];
                let menu = [];
                let indice = 1;
                let content = "";

                if (typeof panel === "string" && panel !== "") {
                    content = panel
                } else {
                    if (panel.constructor === Array && panel.length) {
                        $.each(panel, function (nome, dados) {
                            menu.push(dados)
                        })
                    }
                    $.each(d, function (entity, meta) {
                        if (typeof allow !== "undefined" && typeof allow[entity] !== "undefined" && typeof allow[entity].menu !== "undefined" && allow[entity].menu) {
                            nome = ucFirst(replaceAll(replaceAll(entity, "_", " "), "-", " "));
                            menu.push({
                                indice: indice,
                                icon: (info[entity].icon !== "" ? info[entity].icon : "storage"),
                                title: nome,
                                table: !0,
                                link: !1,
                                form: !1,
                                page: !1,
                                file: '',
                                lib: '',
                                entity: entity
                            });
                            indice++
                        }
                    });
                    menu.sort(dynamicSort('indice'));
                    $.each(menu, function (i, m) {
                        content += Mustache.render(templates.card, m)
                    })
                }

                return content
            })
        });
    }
}

function destruct() {
    clearInterval(updateRelatiosCard);
}

async function updateRelatiosCardInfo() {
    let cards = await get("report/relatorios_cards_value");
    for(let card of cards)
        $(".relatorios_card[rel='" + card.id + "']").find(".relatorios_card_value").html(maskData($("<div><div class='cc td-" + card.format + "'><div class='td-value'>" + card.data + "</div></div></div>")).find(".td-value").html());
}

async function dashboardCardRelatorios() {
    let tpl = await getTemplates();
    let cards = await get("report/relatorios_cards");
    for(let i in cards)
        cards[i].data = maskData($("<div><div class='cc td-" + cards[i].format + "'><div class='td-value'>" + cards[i].data + "</div></div></div>")).find(".td-value").html();

    updateRelatiosCard = setInterval(function () {
        updateRelatiosCardInfo();
    }, 3000);

    return Mustache.render(tpl.relatorios_card, {cards: cards});
}

async function dashboardPanel() {
    if ($(".panel-name").length)
        $(".panel-name").html(USER.nome);

    $(".dashboard-panel").append(await dashboardCardRelatorios() + await dashboardPanelContent());

    let myNotifications = await getNotifications();
    if (isEmpty(myNotifications)) {
        $(".dashboard-note").htmlTemplate('notificacoesEmpty', {message: "Você não tem nenhuma notificação"});
    } else {
        $(".dashboard-note").htmlTemplate('note', myNotifications);
    }
}

function getRelevant(entity, dados) {
    for (let i in dicionarios[entity]) {
        if (dicionarios[entity][i].format === relevant[0])
            return dados[dicionarios[entity][i].column] || "não definido";
    }
}

async function getGraficoData(grafico) {
    if (typeof graficoData[grafico.entity] !== "undefined") {
        if (typeof dicionarios[grafico.entity] !== "undefined" && typeof dicionarios[grafico.entity][grafico.x] !== "undefined" && dicionarios[grafico.entity][grafico.x].key === "relation") {
            for (let e in graficoData[grafico.entity]) {
                let id = parseInt(graficoData[grafico.entity][e][grafico.x]);
                if (!isNaN(id)) {
                    let relation = dicionarios[grafico.entity][grafico.x].relation;
                    if (typeof graficoData[relation] === "undefined" || typeof graficoData[relation][id] === "undefined") {
                        return db.exeRead(relation, id).then(rel => {
                            if (typeof graficoData[relation] === "undefined")
                                graficoData[relation] = {};

                            graficoData[relation][id] = rel;
                            graficoData[grafico.entity][e][grafico.x] = getRelevant(relation, graficoData[relation][id]);
                            return getGraficoData(grafico);
                        });
                    } else {
                        graficoData[grafico.entity][e][grafico.x] = getRelevant(relation, graficoData[relation][id]);
                    }
                }
            }
        }

        return Promise.all([]);

    } else {
        /**
         * Caso não tenha os dados desta entidade na variável 'graficoData'
         * busca os dados, adiciona na 'graficoData' e retorna novamente para esta função.
         */
        return db.exeRead("relatorios", grafico.report).then($this => {
            return reportRead($this.entidade, $this.search, $this.regras, $this.agrupamento, (!isEmpty($this.soma)? JSON.parse($this.soma) : []), (!isEmpty($this.media)? JSON.parse($this.media) : []), $this.ordem, $this.decrescente, 99999999, 0).then(dados => {
                graficoData[grafico.entity] = dados.data;
                return getGraficoData(grafico);
            })
        })
    }
}

async function showGrafico(grafico) {
    await getGraficoData(grafico);
    let size = grafico.size === "100%" ? "12" : (grafico.size === "50%" ? "6" : "4");
    let $div = $("<div id='grafico-" + grafico.id + "' class='col s" + size + "'></div>").appendTo(".dashboard-panel");

    let g = new Grafico($div[0]);
    g.setX(grafico.x);
    g.setY(grafico.y);
    g.setType(grafico.type);
    g.setTitle(ucFirst(grafico.entity));
    g.setOperacao(grafico.operacao);
    g.setMaximo(grafico.maximo);
    g.setLabelY(grafico.labely);
    g.setLabelX(grafico.labelx);
    g.setMinimoY(grafico.minimoY);
    g.setMaximoY(grafico.maximoY);
    g.setMinimoX(grafico.minimoX);
    g.setMaximoX(grafico.maximoX);
    g.toogleLegendShow();
    g.setData(graficoData[grafico.entity]);
    g.setCornerRounded(grafico.corner);
    g.show();
}

$(function () {
    dashboardSidebarInfo();
    dashboardPanel();
    menuDashboard();
    $("body").off("click", ".menu-li:not(.not-menu-li)").on("click", ".menu-li:not(.not-menu-li)", function () {
        let action = $(this).attr("data-action");

        clearHeaderScrollPosition();
        checkUpdate();
        mainLoading();

        if (action === "table") {
            pageTransition($(this).attr("data-entity"), 'grid', 'forward', "#dashboard");

        } else if (action === 'form') {
            // let fields = (typeof $(this).attr("data-fields") !== "undefined" ? JSON.parse($(this).attr("data-fields")) : "undefined");
            let id = !isNaN($(this).attr("data-atributo")) && $(this).attr("data-atributo") > 0 ? parseInt($(this).attr("data-atributo")) : null;
            pageTransition($(this).attr("data-entity"), 'form', 'forward', "#dashboard", id);

        } else if (action === 'page') {

            pageTransition($(this).attr("data-atributo"), 'route', 'forward', "#core-content");
        }
    }).off("click", ".btn-edit-perfil").on("click", ".btn-edit-perfil", function () {
        if (history.state.route !== "usuarios" || history.state.type !== "form") {
            let entity = USER.setorData === "" ? "usuarios" : USER.setorData;
            pageTransition(entity, 'form', 'forward', "#dashboard", USER);
        }
    });

    $("#app, #core-applications").off("click", ".close-dashboard-note").on("click", ".close-dashboard-note", function () {
        let $this = $(this);
        AJAX.post('dashboard/dash/delete', {id: $this.attr("id")}).then(data => {
            $this.closest("article").parent().remove()
        })
    });

    getGraficos().then(graficos => {
        graficos = orderBy(graficos, "posicao").reverse();
        dbLocal.exeRead("__relevant", 1).then(relev => {
            relevant = relev;

            for (let grafico of graficos)
                showGrafico(grafico);
        });
    });
})