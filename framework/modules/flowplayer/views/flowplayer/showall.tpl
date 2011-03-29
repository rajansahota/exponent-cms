{*
 * Copyright (c) 2007-2011 OIC Group, Inc.
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

{script unique="flowplayer" src="`$smarty.const.PATH_RELATIVE`external/flowplayer3/example/flowplayer-3.2.6.min.js"}
{literal}
flowplayer("a.flowplayer-video", EXPONENT.PATH_RELATIVE+"external/flowplayer3/flowplayer-3.2.7.swf",
    {
        plugins:  { 
            controls: { 
                play: true,  
                scrubber: true 
            }         
        } 
    }
);
{/literal}

{/script}

<div class="module flowplayer showall">
    {if $moduletitle}<h1>{$moduletitle}</h1>{/if}
	{permissions}
		<div class="module-actions">
			{if $permissions.edit == 1}
				{icon class="add" action=edit title="Add a Video at the Top"|gettext text="Add a Video"|gettext}
			{/if}
			{if $permissions.edit == 1}
				{ddrerank items=$page->records model="flowplayer" label="Videos"|gettext}
			{/if}
		</div>	
	{/permissions}   
    {foreach from=$page->records item=video key=key}
        <div class="item">
            <h2>{$video->title}</h2>
            <div class="video">
                <a href="{$video->expFile.video[0]->url}" style="display:block;width:{$video->width|default:200}px;height:{$video->height|default:143}px;" class="flowplayer-video">
                    {if $video->expFile.splash[0]->url}
                        {img file_id=$video->expFile.splash[0]->id w=$video->width h=$video->height zc=1}
                    {/if}
                </a> 
            </div>
			{permissions}
				<div class="item-actions">
					{if $permissions.edit == 1}
						{icon action=edit id=$video->id title="Edit video"|gettext text="Edit"|gettext}
					{/if}
					{if $permissions.delete == 1}
						{icon action=delete id=$video->id title="Delete video"|gettext onclick="return confirm('Are you sure you want to delete this `$modelname`?');" text="Delete"|gettext}
					{/if}
				</div>			
			{/permissions} 
            <div class="bodycopy">
                {$video->body}
            </div>            
			{permissions}
				<div class="module-actions">		
					{if $permissions.create == 1}
						{icon class=add action=edit rank=`$video->rank+1` title="Add a Video Here"|gettext text="Add a Video"|gettext}
					{/if}
				</div>
			{/permissions}
			{clear}
        </div>
    {/foreach}
</div>
