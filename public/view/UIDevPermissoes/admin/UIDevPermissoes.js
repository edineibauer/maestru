$(function () {
    var permit = {users: [], entidades: {}, permissoes: {}};

    $("#permissao-container").off("change", ".allow-menu-session").on("change", ".allow-menu-session", function () {
        let user = $(this).attr("data-user");
        let entity = $(this).attr("data-entity");
        let tipo = $(this).attr("data-tipo");
        permit.permissoes[user][entity][tipo] = $(this).prop("checked");

        if(tipo === "menu") {
            permit.permissoes[user][entity]["read"] = permit.permissoes[user][entity]["menu"];
            permit.permissoes[user][entity]["create"] = permit.permissoes[user][entity]["menu"];
            permit.permissoes[user][entity]["update"] = permit.permissoes[user][entity]["menu"];
            permit.permissoes[user][entity]["delete"] = permit.permissoes[user][entity]["menu"];
            $(".allow-menu-session[data-tipo='read'][data-entity='" + entity + "'][data-user='" + user + "']").prop("checked", permit.permissoes[user][entity]["menu"]);
            $(".allow-menu-session[data-tipo='create'][data-entity='" + entity + "'][data-user='" + user + "']").prop("checked", permit.permissoes[user][entity]["menu"]);
            $(".allow-menu-session[data-tipo='update'][data-entity='" + entity + "'][data-user='" + user + "']").prop("checked", permit.permissoes[user][entity]["menu"]);
            $(".allow-menu-session[data-tipo='delete'][data-entity='" + entity + "'][data-user='" + user + "']").prop("checked", permit.permissoes[user][entity]["menu"]);
        }

        let dados = Object.assign({}, permit.permissoes);
        AJAX.post('UIDev/save/permissoes', {dados: dados}).then(() => {
            let all = [];
            all.push(get("config/allow"));
            all.push(dbLocal.clear('__allow'));
            Promise.all(all).then(r => {
                dbLocal.exeCreate("__allow", r[0]);
            });
            setUpdateVersion()
        });
    });

    let pp = AJAX.get('UIDev/devPermissoes');
    let pt = dbLocal.exeRead('__info', 1);
    Promise.all([pp, pt]).then(r => {

        permit.users.push({id: "0", user: "Anônimo"});
        $.each(r[1], function(entity, meta) {
            if(typeof meta.user === "number" && meta.user === 1)
                permit.users.push({id: entity, user: ucFirst(replaceAll(entity, '_', ' '))})
        });

        permit.entidades = [];
        for (let k in dicionarios) {
            if(typeof dicionarios === "object" && ["login_attempt", "dashboard_push", "usuarios_token", "api_chave", "config"].indexOf(k) === -1)
                permit.entidades.push(k);
        }
        permit.permissoes = preenchePermissoesNaoDefinidas(r[0]);

        getTemplates().then(tpl => {
            $("#list-entity").html(Mustache.render(tpl['allow-list-entity'], {
                entidades: permit.entidades,
                familyName: function () {
                    return function (text, render) {
                        return replaceAll(render(text), '_', ' ')
                    }
                }
            }));
            let entidades = [];
            $.each(permit.entidades, function (i, e) {
                entidades.push({entity: e, checked: permit.permissoes['admin'][e].menu})
            });
            $("#adm-allow-menu").html(Mustache.render(tpl['allow-entity-menu'], {entidades: entidades}));
            $.each(permit.users, function (a, u) {
                u.entitys = [];
                $.each(permit.entidades, function (i, e) {
                    let ee = {entity: e, permissoes: []};
                    $.each(['menu', 'read', 'create', 'update', 'delete'], function (b, t) {
                        ee.permissoes.push({tipo: t, checked: permit.permissoes[u.id][e][t]})
                    });
                    u.entitys.push(ee)
                })
            });
            $("#permissao").html(Mustache.render(tpl['allow-user-table'], {users: permit.users}));
            $("#permissao-container").width($("#permissao").width() + 75 + "px")
        })
    });

    function preenchePermissoesNaoDefinidas(permissoes) {
        if (typeof permissoes['admin'] === "undefined")
            permissoes['admin'] = {};
        $.each(permit.entidades, function (b, e) {
            if (typeof permissoes['admin'][e] === "undefined") {
                permissoes['admin'][e] = {};
                permissoes['admin'][e].menu = !1
            }
        });
        $.each(permit.users, function (a, u) {
            if (typeof permissoes[u.id] === "undefined" || permissoes[u.id] === "")
                permissoes[u.id] = {};
            $.each(permit.entidades, function (b, e) {
                if (typeof permissoes[u.id][e] === "undefined") {
                    permissoes[u.id][e] = {};
                    $.each(['menu', 'read', 'create', 'update', 'delete'], function (b, t) {
                        permissoes[u.id][e][t] = !1
                    })
                }
            })
        });
        return permissoes
    }

    $("#permissao").off("mouseover", ".stripp").on("mouseover", ".stripp", function () {
        $(".stripp[rel='" + $(this).attr("rel") + "']").addClass("color-gray-light")
    }).off("mouseleave", ".stripp").on("mouseleave", ".stripp", function () {
        $(".stripp").removeClass("color-gray-light")
    });
    $("#newUserType").off("click").on("click", function () {
        let userType = prompt("Dê um nome ao novo tipo de usuário", "ex: Funcionário");
        if (userType != null)
            permit.permissoes[userType] = 'teste'
    })
})