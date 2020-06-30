<header class="container padding-bottom">
    <h5>
        <b><i class="material-icons left padding-right">format_paint</i> <span class="left">Tema</span></b>
    </h5>
</header>

<div class="col">
    <div class="col padding-small">
        <div class="col card">
            <input type="hidden" id="color" onchange="createTheme(-1)" size="8" style="height:0;width: 0" value="#efc050">
            <div class="row padding-medium" style="padding-bottom: 0!important;">
                <div class="col padding-small"></div>
                <div class="col right" style="width: 280px">
                    <button class="btn color-blue hover-shadow right" onclick="restoreTheme()">tema anterior</button>
                    <button class="btn color-teal hover-shadow right" onclick="saveTheme()"><i class="material-icons left padding-right">save</i>
                        salvar
                    </button>
                </div>
                <div class="rest s12">
                    <div class="col s12 m2 padding-small">
                        <input type="text" id="colorHex" onkeyup="createSuggestion('colorHex')" onchange="createSuggestion('colorHex')" />
                    </div>
                    <div class="col s12 m4 padding-small">
                        <select id="select01" class="select border" name="option" onchange="createSuggestion('select01')">
                            <option value="" disabled="" selected="">Temas</option>
                            <option style="color:#666;background-color:#ffffff" value="#ffffff">White</option>
                            <option style="color:#fff;background-color:#000000" value="#000000">Black</option>
                            <option style="color:#fff;background-color:#838487" value="#838487">Gray</option>
                            <option style="color:#fff;background-color:#4c6a92" value="#4c6a92">Riverside</option>
                            <option style="color:#fff;background-color:#92b6d5" value="#92b6d5">Airy Blue</option>
                            <option style="color:#fff;background-color:#b93a32" value="#b93a32">Aurora Red</option>
                            <option style="color:#fff;background-color:#af9483" value="#af9483">Warm Taupe</option>
                            <option style="color:#fff;background-color:#ad5d5d" value="#ad5d5d">Dusty Cedar</option>
                            <option style="color:#fff;background-color:#006e51" value="#006e51">Lush Medow</option>
                            <option style="color:#fff;background-color:#d8ae47" value="#d8ae47">Spicy Mustard</option>
                            <option style="color:#fff;background-color:#9e4624" value="#9e4624">Potter's Clay</option>
                            <option style="color:#fff;background-color:#b76ba3" value="#b76ba3">Bodacious</option>
                            <option style="color:#fff;background-color:#f7cac9" value="#f7cac9">Rose Quarts</option>
                            <option style="color:#fff;background-color:#92a8d1" value="#92a8d1">Serenity</option>
                            <option style="color:#fff;background-color:#f7786b" value="#f7786b">Peach Echo</option>
                            <option style="color:#fff;background-color:#034f84" value="#034f84">Snorkel Blue</option>
                            <option style="color:#fff;background-color:#98ddde" value="#98ddde">Limpet Shell</option>
                            <option style="color:#fff;background-color:#9896a4" value="#9896a4">Lilac Grey</option>
                            <option style="color:#fff;background-color:#b18f6a" value="#b18f6a">Iced Coffe</option>
                            <option style="color:#fff;background-color:#dd4132" value="#dd4132">Fiesta</option>
                            <option style="color:#fff;background-color:#fae03c" value="#fae03c">Buttercup</option>
                            <option style="color:#fff;background-color:#79c753" value="#79c753">Green Flash</option>
                            <option style="color:#fff;background-color:#955251" value="#955251">Marsala</option>
                            <option style="color:#fff;background-color:#b565a7" value="#b565a7">Radiand Orchid</option>
                            <option style="color:#fff;background-color:#009b77" value="#009b77">Emerald</option>
                            <option style="color:#fff;background-color:#dd4124" value="#dd4124">Tangerine Tango</option>
                            <option style="color:#fff;background-color:#d65076" value="#d65076">Honeysucle</option>
                            <option style="color:#fff;background-color:#45b8ac" value="#45b8ac">Turquise</option>
                            <option style="color:#fff;background-color:#efc050" value="#efc050">Mimosa</option>
                            <option style="color:#fff;background-color:#5b5ea6" value="#5b5ea6">Blue Izis</option>
                            <option style="color:#fff;background-color:#9b2335" value="#9b2335">Chili Pepper</option>
                            <option style="color:#fff;background-color:#dfcfbe" value="#dfcfbe">Sand Dollar</option>
                        </select>
                    </div>
                    <div class="col s6 m3 padding-small">
                        <span class="left padding-medium">H</span>
                        <input type="text" id="hue" size="8" style="width:50px;height:34px;padding:19px 4px" value="0"
                               disabled="">
                        <button class="btn color-grey hover-shadow opacity hover-opacity-off" style="margin-bottom:4px" onclick="huePlus(-5)">-</button>
                        <button class="btn color-grey hover-shadow opacity hover-opacity-off" style="margin-bottom:4px" onclick="huePlus(+5)">+</button>
                    </div>
                    <div class="col s6 m3 padding-small">
                        <span class="left padding-medium">S</span>
                        <input type="text" id="saturation" size="8" style="width:50px;height:34px;padding:19px 4px"
                               value="0" disabled="">
                        <button class="btn color-grey hover-shadow opacity hover-opacity-off" style="margin-bottom:4px" onclick="saturationPlus(-0.05)">-</button>
                        <button class="btn color-grey hover-shadow opacity hover-opacity-off" style="margin-bottom:4px" onclick="saturationPlus(0.05)">+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m6 padding-small">
        <section class="card border-bottom">
            <div id="demo-h1" class="row" style="background-color: rgb(213, 146, 146); color: rgb(0, 0, 0);">
                <div class="col l3 hide-medium hide-small container padding-16 xlarge opacity">
                    <i class="material-icons">menu</i>
                </div>

                <div class="col l7 s12 container padding-16 xlarge">
                    <input style="width: 80%; background-color: rgb(225, 179, 179);" class="border-0 show-inline-block"
                           id="demo-input" value="">
                    &nbsp;<i class="material-icons">search</i>
                </div>

                <div class=" col l2 hide-medium hide-small container" style="padding-top:8px">
                    <div class="right">
                        <img class="radius-circle" src="{$home}{$vendor}dev-ui/public/assets/avatar.jpg" style="height:55px"><br>
                    </div>
                </div>
            </div>

            <div id="demo-h2" class="container padding-32"
                 style="background-color: rgb(238, 211, 211); color: rgb(0, 0, 0);">
                <h2>Paleta</h2>
            </div>
            <div class="row-padding" style="margin:0 -16px">
                <div class="col">
                    <table class="col">
                        <tbody>
                        <tr style="height:59px;">
                            <td id="t1l5" style="color: rgb(0, 0, 0); background-color: rgb(254, 252, 252);">#fefcfc
                                theme-l5
                            </td>
                        </tr>
                        <tr style="height:59px">
                            <td id="t1l4" style="color: rgb(0, 0, 0); background-color: rgb(252, 246, 246);">#fcf6f6
                                theme-l4
                            </td>
                        </tr>
                        <tr style="height:58px">
                            <td id="t1l3" style="color: rgb(0, 0, 0); background-color: rgb(248, 237, 237);">#f8eded
                                theme-l3
                            </td>
                        </tr>
                        <tr style="height:59px">
                            <td id="t1l2" style="color: rgb(0, 0, 0); background-color: rgb(245, 229, 229);">#f5e5e5
                                theme-l2
                            </td>
                        </tr>
                        <tr style="height:58px">
                            <td id="t1l1" style="color: rgb(0, 0, 0); background-color: rgb(241, 220, 220);">#f1dcdc
                                theme-l1
                            </td>
                        </tr>
                        <tr style="height:59px">
                            <td id="t1d0" style="background-color: rgb(238, 211, 211); color: rgb(0, 0, 0);">#eed3d3
                                theme
                            </td>
                        </tr>
                        <tr style="height:58px">
                            <td id="t1d1" style="background-color: rgb(225, 179, 179); color: rgb(0, 0, 0);">#e1b3b3
                                theme-d1
                            </td>
                        </tr>
                        <tr style="height:59px">
                            <td id="t1d2" style="background-color: rgb(213, 146, 146); color: rgb(0, 0, 0);">#d59292
                                theme-d2
                            </td>
                        </tr>
                        <tr style="height:58px">
                            <td id="t1d3" style="background-color: rgb(200, 114, 114); color: rgb(255, 255, 255);">
                                #c87272 theme-d3
                            </td>
                        </tr>
                        <tr style="height:59px">
                            <td id="t1d4" style="background-color: rgb(188, 82, 82); color: rgb(255, 255, 255);">#bc5252
                                theme-d4
                            </td>
                        </tr>
                        <tr style="height:58px">
                            <td id="t1d5" style="background-color: rgb(162, 63, 63); color: rgb(255, 255, 255);">#a23f3f
                                theme-d5
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <div class="col s12 m6 padding-small">
        <section class="card border-bottom">
            <div class="col">
                <div class="border">
                    <div id="mt1-top" class="container padding-small"
                         style="background: rgb(200, 114, 114); color: rgb(255, 255, 255);">
                        <div class="right">
                            <i class="fa fa-cube"></i>
                            <i class="fa fa-sort"></i>
                            <i class="fa fa-trash"></i>
                            12:30
                        </div>
                    </div>
                    <header id="mt1-header" class="container"
                            style="background: rgb(238, 211, 211); color: rgb(0, 0, 0);">
                        <h2>Movies</h2>
                    </header>
                    <div id="mt1-back" class="container padding-16"
                         style="position: relative; min-height: 465px; background: rgb(254, 252, 252);">
                        <a id="mt1-action" class="button xlarge radius-circle right"
                           style="position: absolute; top: -30px; right: 16px; background: rgb(162, 63, 63); color: rgb(255, 255, 255);">+</a>
                        <div class="row">
                            <div class="col" style="width:100px">
                                <img class="radius-circle" src="{$home}{$vendor}dev-ui/public/assets/avatar.jpg" alt="avatar">
                            </div>
                            <div class="rest container">
                                <h3 id="mt1-h1" style="color: rgb(238, 211, 211);">Frozen</h3>
                                <p>The response to the animations was ridiculous.</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div id="mt1-graphic" class="col" style="width: 100px; color: rgb(238, 211, 211);">
                                <i class="material-icons" style="font-size:96px;">perm_identity</i>
                            </div>
                            <div class="rest container">
                                <h3 id="mt1-h2" style="color: rgb(238, 211, 211);">Star Wars</h3>
                                <p>People were excited for the new Star Wars movie.</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col" style="width:100px">
                                <img class="radius-circle" src="{$home}{$vendor}dev-ui/public/assets/avatar.jpg" alt="avatar">
                            </div>
                            <div class="rest container">
                                <h3 id="mt1-h3" style="color: rgb(238, 211, 211);">The Avengers</h3>
                                <p>A huge success for Marvel and Disney.</p>
                            </div>
                        </div>
                    </div>
                    <div id="mt1-footer" class="container" style="background: rgb(238, 211, 211); color: rgb(0, 0, 0);">
                        <p>W3Schools 2016</p>
                    </div>
                    <div id="mt1-bottom" class="container xlarge"
                         style="background: rgb(162, 63, 63); color: rgb(255, 255, 255);">«<span class="right">»</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>