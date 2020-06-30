<header class="container padding-bottom">
    <h5>
        <b><i class="material-icons left padding-right">settings_input_component</i> <span class="left">Integrações</span></b>
    </h5>
</header>

<div class="col s12 padding-small">

    <div class="col s12 m6 padding-medium">
        {foreach key=i item=item from=$integration}
            {if $i%2 === 0}
                <section class="card padding-8 border-bottom">
                    <header class="container col padding-8">
                        {if !empty($item['link'])}
                            <a href="{$item['link']}" target="_blank" class="font-xxlarge"
                               style="text-decoration: none">{$item['nome']}</a>
                        {else}
                            <span class="font-xxlarge" style="text-decoration: none">{$item['nome']}</span>
                        {/if}
                    </header>

                    <div class="col padding-medium font-medium">
                        {foreach key=key item=it from=$item['constantes']}
                            {if ($it['input'] === "text")}
                                <label class="col padding-small">
                                    <span class="col">{$key}</span>
                                    <input type="text" id="{$it['column']}" value="{$it['value']}"
                                           class="font-xlarge inputConfig">
                                </label>
                            {elseif ($it['input'] === "textarea")}
                                <label class="col padding-small">
                                    <span class="col">{$key}</span>
                                    <textarea id="{$it['column']}" rows="4"
                                              class="font-small inputConfig">{$it['value']}</textarea>
                                </label>
                            {/if}
                        {/foreach}
                    </div>
                </section>
            {/if}
        {/foreach}
    </div>
    <div class="col s12 m6 padding-medium">
        {foreach key=i item=item from=$integration}
            {if $i%2 === 1}
                <section class="card padding-8 border-bottom">
                    <header class="container col padding-8">
                        {if !empty($item['link'])}
                            <a href="{$item['link']}" target="_blank" class="font-xxlarge"
                               style="text-decoration: none">{$item['nome']}</a>
                        {else}
                            <span class="font-xxlarge" style="text-decoration: none">{$item['nome']}</span>
                        {/if}
                    </header>

                    <div class="col padding-medium font-medium">
                        {foreach key=key item=it from=$item['constantes']}
                            {if ($it['input'] === "text")}
                                <label class="col padding-small">
                                    <span class="col">{$key}</span>
                                    <input type="text" id="{$it['column']}" value="{$it['value']}"
                                           class="font-xlarge inputConfig">
                                </label>
                            {elseif ($it['input'] === "textarea")}
                                <label class="col padding-small">
                                    <span class="col">{$key}</span>
                                    <textarea id="{$it['column']}" rows="4"
                                              class="font-small inputConfig">{$it['value']}</textarea>
                                </label>
                            {/if}
                        {/foreach}
                    </div>
                </section>
            {/if}
        {/foreach}
    </div>
</div>