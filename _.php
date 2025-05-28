<?php

    include_once ('_function.php');

    define ('defineMainContent', [
    ]);

    define ('defineFooterContent', [
    ]);

    define ('defineBodyContent', [
        '<table', ...setClass (getClass ('htmlTable')), '>',
            '<tbody', ...setClass (getClass ('htmlTableBody')), '>',
                ...array_map (function ($is_index, $is_key) {
                    $is_content = [ 'flex-lg-row', 'flex-lg-wrap' ];
                    return implode ('', [
                        '<tr', ...setClass (getClass ('htmlTableTr')), '>',
                            '<td', ...setClass ([ ...$is_content, getClass ('col04') ]), '>',
                                ...setGroup ('getClass (\'' . $is_key . '\'),'),
                            '</td>',
                            '<td', ...setClass ([ ...$is_content, getClass ('col08') ]), '>',
                                ...setGroup (implode (' ', [ '[', ...array_map (function ($is_class, $is_key) use ($is_index) {
                                    return implode ('', [
                                        '\'', $is_class, '\'',
                                        ...$is_key < sizeof ($is_index) - 1 ? [ ',' ] : []
                                    ]);
                                }, $is_index, array_keys ($is_index)), ']', ]), 'textarea'),
                            '</td>',
                        '</tr>',
                    ]);
                }, definePool, array_keys (definePool)),
            '</tbody>',
        '</table>',
        // ...setSELETOR (defineMainContent, [ 'wrap' => 'main' ]),
        // ...setSELETOR (defineFooterContent, [ 'wrap' => 'footer' ]),
    ]);

    define ('defineFloatContent', [
    ]);

    define ('defineHeadContainer', setSELETOR ([
        ...setMetaWrapper (setAttrib ('utf-8', 'charset')),
        ...setMetaViewport (),
        ...setMetaDescription (),
        ...setMetaKeyword (),
        ...setHeadTitle (),
        ...setStyleArray ()
    ], [ 'wrap' => 'head' ]));

    define ('defineBodyContainer', setSELETOR ([
        ...defineBodyContent,
        ...defineFloatContent,
        ...setScriptArray ()
    ], [ 'wrap' => 'body' ]));

    define ('defineHTMLContent', [
        '<!doctype html>',
        '<html',
            ...setClass (getClass ('html')),
            ' data-bs-theme=\'', defineTheme['color'], '\'',
            ' lang=\'en\'',
        '>',
            ...defineHeadContainer,
            ...defineBodyContainer,
        '</html>',
    ]);

    ob_start ();
    echo implode ('', defineHTMLContent);
    $is_html_content = ob_get_contents ();
    ob_end_clean ();
    file_put_contents (defineServer['html-file'], $is_html_content);
    echo $is_html_content;

?>