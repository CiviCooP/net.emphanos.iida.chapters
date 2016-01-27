<h3>{if $action eq 1}{ts}Add Automatch set{/ts}{elseif $action eq 2}{ts}Edit Automatch set{/ts}{else}{ts}Delete Automatch set{/ts}{/if}</h3>

<div class="crm-block crm-form-block crm-automatch-form-block">
    {if $action eq 8}
    <div class="">
        <div class="icon inform-icon"></div>
        {ts}Deleting an automatch set cannot be undone.{/ts} {ts}Do you want to continue?{/ts}
    </div>
    <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
    {else}
        <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="top"}</div>

        <div class="crm-section">
            <div class="label">{$form.type.label}</div>
            <div class="content">{$form.type.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section type-option type-country">
            <div class="label">{$form.country.label}</div>
            <div class="content">{$form.country.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section type-zipcode type-option">
            <div class="label">{$form.zipcode_from.label}</div>
            <div class="content">{$form.zipcode_from.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section type-zipcode type-option">
            <div class="label">{$form.zipcode_to.label}</div>
            <div class="content">{$form.zipcode_to.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>

        <script type="text/javascript">
            {literal}
            cj(function() {
                cj('select#type').change(changeType);
                cj('select#type').trigger('change');
            });
            function changeType() {
                cj('.type-option').css('display', 'none');
                var val = cj('#type').val();
                cj('.type-'+val).css('display', 'block');
            }
            {/literal}
        </script>
    {/if}
</div>