<?php

use \Illuminate\Support\Facades\DB;

$chatchit = DB::table('tbl_chat')->get();
foreach ($chatchit as $c) {
    echo "<h6>$c->content</h6>";
}
