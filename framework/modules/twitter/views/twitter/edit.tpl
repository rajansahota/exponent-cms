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

<div class="module twitter edit">
    <h1>Creating a Tweet</h1>
    {form action=update}
        {control type=hidden name=id value=$record->id}
	    {control type=textarea cols="60" rows=5 name=body label="Tweet (trimmed to 140 characters)" value=''}
        {control type=buttongroup submit="Send Tweet" cancel="Cancel"}
    {/form}   
</div>