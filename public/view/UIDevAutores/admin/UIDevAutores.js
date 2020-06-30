$(function () {
    let dicionarios = dbLocal.exeRead("__dicionario", 1);
    let info = dbLocal.exeRead("__info", 1);
    let tpl = getTemplates();
    Promise.all([dicionarios, info, tpl]).then(r => {
        dicionarios = r[0];
        info = r[1];
        tpl = r[2];

        let entitys = [];
        let classe = 'color-gray-light';
        $.each(dicionarios, function (entity, meta) {
            if(typeof info[entity].autor !== "undefined" && info[entity].autor === 1 || info[entity].autor === 2) {
                classe = (classe === 'color-white' ? 'color-gray-light' : 'color-white');
                entitys.push({class: classe, entity: entity});
            }
        })

        $("#autor-list-dev").html(Mustache.render(tpl['autor-list-entity'], {entidades: entitys}));
    });

    $("#autor-list-dev").off("click", ".btn-edit-autor").on("click", ".btn-edit-autor", function () {
        $("#autor-list-dev").html("").grid($(this).attr("rel"), [], {autor: !0, create: !1, update: !1, delete: !1, status: !1})
    });
});