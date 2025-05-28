<?php

    include_once ('function.php');

    $is_number = 0;
    if (file_exists (defineServer['html-file'])):
        $is_html = getFileDateTime (defineServer['html-file']);
        foreach ([ ...getPathArray ([ 'dir' => 'json' ]), defineServer['php-file'] ] as $is_index):
            $is_file = getFileDateTime ($is_index);
            if ($is_file > $is_html)
                $is_number++;
        endforeach;
    else:
        $is_number++;
    endif;

    echo isTrue ($is_number) ? setMetaRefresh (defineServer['php-file']) : setMetaRefresh (defineServer['html-file']);

?>