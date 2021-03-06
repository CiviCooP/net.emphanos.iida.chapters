<div id="ltype">
 <div class="form-item">
  {strip}
  <table cellpadding="0" cellspacing="0" border="0">
   <thead class="sticky">
   <th>{ts}Match{/ts}</th>
   <th></th>
   <th></th>
   </thead>
   <tbody>
   {foreach from=$rows item=row}
     <td>{$row.type}</td>
     <td>
       {if ($row.type_value == 'country')}
         {$row.country}
        {else}
         {$row.zipcode_from} - {$row.zipcode_to}
       {/if}
     </td>
     <td>
         <a href="{crmURL p="civicrm/contact/automatch_chapters/edit" q="action=update&reset=1&cid=`$cid`&id=`$row.id`"}">{ts}Edit{/ts}</a>
         &nbsp;
         <a href="{crmURL p="civicrm/contact/automatch_chapters/edit" q="action=delete&reset=1&cid=`$cid`&id=`$row.id`"}">{ts}Delete{/ts}</a>
     </td>
   {/foreach}
   </tbody>
  </table>
  {/strip}

     <div class="action-link">
         <a href="{crmURL p="civicrm/contact/automatch_chapters/edit" q="action=add&reset=1&cid=`$cid`"}" id="newAutomatchSet" class="button"><span><div class="icon add-icon"></div>{ts}Add Automatch set{/ts}</span></a>
     </div>

 </div>
</div>