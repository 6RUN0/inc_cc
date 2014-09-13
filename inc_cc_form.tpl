{if !empty($inc_cc_settings)}
  <div class="inc-cc-fix"><form id="set-options" name="set_options" method="post">
    {foreach from=$inc_cc_settings key=position item=arr}
      {if !empty($arr)}
        <div class='block-header2'>{$position}</div>
        <table class="kb-table kb-table-rows">
          <thead>
            <tr class="kb-table-header">
              <td></td>
              <td>Position</td>
              <td>Code</td>
            </tr>
          </thead>
          <tbody>
            {foreach from=$arr key=key item=val}
              <tr>
                <td><input type="checkbox" name="set_options[{$position}][{$key}][check]" /></td>
                <td>
                  <select name="set_options[{$position}][{$key}][position]">
                    <option {if $position == 'head'}selected{/if}>head</option>
                    <option {if $position == 'body'}selected{/if}>body</option>
                  </select>
                </td>
                <td><textarea name="set_options[{$position}][{$key}][code]" cols="80" rows="7" >{$val}</textarea></td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      {/if}
    {/foreach}
    <br />
    <div class="inc-cc-button"><input type="submit" name="rm" value="Remove" /></div>
    <div class="inc-cc-button"><input type="submit" name="set" value="Set" /></div>
    <div class="inc-cc-button"><input type="submit" name="clear" value="Clear" /></div>
  </form></div>
{/if}
<div class='block-header2'>Add code</div>
<div class="inc-cc-fix"><form id="add-options" name="add_options" method="post">
  <div><label for name="add_options[position]"></label></div>
  <div>
    <select name="add_options[position]">
      <option>head</option>
      <option>body</option>
    </select>
  </div>
  <div><label for name="add_options[code]">Code</label></div>
  <div><textarea name="add_options[code]" cols="80" rows="7" ></textarea></div>
  <div class="inc-cc-button"><input type="submit" name="add" value="Add" /></div>
</form></div>
