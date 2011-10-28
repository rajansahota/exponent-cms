{*
 * Copyright (c) 2004-2008 OIC Group, Inc.
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
 
<div class="module importexport manage">
    <h1>Upload Your {$type} CSV File to Import</h1>    
    {form action=validate}
        {control type="hidden" name="import_type" value=$type}
        {* control type=files name=import_file label="Upload .csv File to Import" limit=1 subtype="import_file" *}
        <input type="file" name="import_file" size="50">
        {control type="buttongroup" submit="Import!" cancel="Cancel"}
    {/form}
    {br}
</div>