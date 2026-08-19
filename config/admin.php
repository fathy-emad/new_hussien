<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin data tables pagination
    |--------------------------------------------------------------------------
    */

    'per_page' => (int) env('ADMIN_PER_PAGE', 10),

    'per_page_options' => [5, 10, 15, 25, 50],

    /** Admin paginator: pages shown before / after the current page */
    'pagination_pages_before' => 3,
    'pagination_pages_after' => 2,

    /** Minimum score percentage to count as success on exam results */
    'exam_pass_percentage' => (int) env('ADMIN_EXAM_PASS_PERCENTAGE', 50),

];
