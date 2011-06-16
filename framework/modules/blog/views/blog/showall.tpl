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

{css unique="blog" link="`$asset_path`css/blog.css"}

{/css}

<div class="module blog showall">
    {if $config.enable_rss == true}
        <a class="rsslink" href="{rsslink}">Subscribe to {$config.feed_title}</a>
    {/if}
    {if $moduletitle}<h1>{$moduletitle}</h1>{/if}
    {permissions}
		<div class="module-actions">
			{if $permissions.edit == 1}
				{icon class=add action=edit title="Add a new blog article" text="Add a new blog article"}
			{/if}
            {if $permissions.manage == 1}
                {icon class="manage" controller=expTag action=manage title="Manage Tags"|gettext text="Manage Tags"|gettext}
            {/if}
		</div>
    {/permissions}
    {pagelinks paginate=$page top=1}
    {foreach from=$page->records item=item}
        <div class="item">
            <h2>
            <a href="{link action=show title=$item->sef_url}">
            {$item->title}
            </a>
            </h2>
            {permissions}
                <div class="item-actions">
                    {if $permissions.edit == 1}
                        {icon action=edit record=$item title="Edit this `$modelname`"}
                    {/if}
                    {if $permissions.delete == 1}
                        {icon action=delete record=$item title="Delete this `$modelname`" onclick="return confirm('Are you sure you want to delete this `$modelname`?');"}
                    {/if}
                </div>
            {/permissions}
            <div class="post-info">
                <span class="attribution">
                    Posted by {attribution user_id=$item->poster} on <span class="date">{$item->created_at|format_date:$smarty.const.DISPLAY_DATE_FORMAT}</span>
                </span>

                | <a class="comments" href="{link action=show title=$item->sef_url}#exp-comments">{$item->expComment|@count} {"Comments"|gettext}</a>
                
				{if $item->expTag[0]->id}
				| <span class="tags">
					{"Tags"|gettext}: 
					{foreach from=$item->expTag item=tag name=tags}
					<a href="{link action=showall_by_tags tag=$tag->sef_url}">{$tag->title}</a>{if $smarty.foreach.tags.last != 1},{/if}
					{/foreach} 
				</span>
				{/if}
            </div>
            <div class="bodycopy">
                {filedisplayer view="`$config.filedisplay`" files=$item->expFile item=$item is_listing=1}
    			{if $config.usebody==1}
    				<p>{$item->body|summarize:"html":"paralinks"}</p>
    			{elseif $config.usebody==2}
    			{else}
    				{$item->body}
    			{/if}			
                
            </div>
        </div>
    {/foreach}    
    {pagelinks paginate=$page bottom=1}
</div>
