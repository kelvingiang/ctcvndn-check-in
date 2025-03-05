<?php

require_once(DIR_CONTROLLER . 'controller.php');
new Controller_Main();

// require_once(DIR_META_BOX . 'metabox.php');
// new Meta_Box_Main();

// require_once(DIR_TAXONOMY . 'taxonomy.php');
// new Taxonomy_Main();

include_once(DIR_CLASS . 'rewrite.php');
new Rewrite_Url();


/* CHUC NANG SEARCH TU TABLE POSTSMETA */
// require_once(DIR_CODES . 'search-by-meta-value.php');
// new Admin_Search_By_Meta_Value();

