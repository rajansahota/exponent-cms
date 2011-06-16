{*
 * Copyright (c) 2004-2011 OIC Group, Inc.
 * Written and Designed by Adam Kessler
 *
 * This file is part of Exponent
 *
 * Exponent is free software; you can redistribute
 * it and/or modify it under the terms of the GNU
 * General Public License as published by the Free
 * Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 *
 * GPL: http://www.gnu.org/licenses/gpl.txt
 *
 *}

{css unique="myaddressbook" corecss="tables"}

{/css}

<div class="module address myaddressbook">
    <h1>{$moduletitle|default:"My address book"}</h1>
    <div>Click the <strong>Add New Address</strong> link below if you'd like to add a new address to use for either your billing or shipping address.{br}
    To change your billing or shipping address for this order, simply select the button next to the address you'd like to set in either the billing or shipping address column. {br}
    A green button indicates your selection.{br}{br}
    When you are done, simply click the <strong>Return to Checkout</strong> button below to go back to the checkout process.
    {br}    {br}    
    </div>
    <p>
        {icon class=add action=create title="Add New Address" text="Add New Address"|gettext}
    </p>
    {br}    
    <table class="exp-skin-table">
    <thead>
    <th>Use as Billing</th>
    <th>Use as Shipping</th>
    <th>Address</th>
    <th>&nbsp;</th>
    </thead>
    <tbody>
    
    {foreach from=$addresses item=address}
        <tr class="{cycle values="odd,even"}">
            <td align="center">
                {if $address->is_billing}
                    <span style="text-align: center;">{img src=`$smarty.const.ICON_RELATIVE`toggle_on.gif}</span>
                {else}
                    <span style="text-align: center;"><a href="{link action=activate_address is_what="is_billing" id=$address->id enabled=1}">{img src=`$smarty.const.ICON_RELATIVE`toggle_off.gif}</a></span>
                {/if}   
            </td>
            <td align="center">
                {if $address->is_shipping}
                    {img src=`$smarty.const.ICON_RELATIVE`toggle_on.gif}
                {else}
                    <a href="{link action=activate_address is_what="is_shipping"  id=$address->id enabled=1}">{img src=`$smarty.const.ICON_RELATIVE`toggle_off.gif}</a>
                {/if}   
            </td>
            <td>
            <address class="address show">
            
            <strong>{$address->firstname} {$address->middlename} {$address->lastname}</strong>{br}
            {$address->address1}{br}
            {if $address->address2 != ""}{$address->address2}{br}{/if}
            {$address->city}, {if $address->state == -2}{$address->non_us_state}{else}{$address->state|statename}{/if} {$address->zip}{br}
            {if $address->state == -2}{$address->country|countryname}{br}{/if}
							{$address->phone}{br}
							{$address->email}{br}
							{clear}
						</address>
					</td>
					<td>
						{permissions level=$smarty.const.UILEVEL_PERMISSIONS}
							<div class="item-actions">
								{if $user->id == $address->user_id}
									{icon action=edit record=$address title="Edit this Address"}
									{if $addresses|@count > 1}{icon action=delete record=$address title="Delete this Address" onclick="return confirm('Are you sure you want to delete this address?');"}{/if}
								{/if}
							</div>
						{/permissions}
					</td>
				</tr>    
			{foreachelse}
				<tr><td colspan="4"></tr><p>You don't have any addresses in your address book yet</p></td>
			{/foreach}
		</tbody>
    </table>
    <a class="awesome blue small" href="{backlink}">Done</a>
</div>

