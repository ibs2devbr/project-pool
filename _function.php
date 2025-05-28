<?php

    foreach ([ 'config', 'define' ] as $is_archive):
        foreach (getFileArray ([ 'search' => $is_archive ]) as $is_index):
            $is_index = pathinfo ($is_index);
            define (setTargetName (explode ('-', $is_index['filename'])), setJson2Array ($is_index['basename']));
        endforeach;
    endforeach;

    function getDefineKeyword (): array {
        $is_result = [];
        $is_i_array = configKeyword[0];
        $is_j_array = isArray (configKeyword[1]) ? configKeyword[1] : defineGenero;
        $is_k_array = configKeyword[2];
        for ($i = 0; $i < sizeof ($is_i_array); $i++):
            for ($j = 0; $j < sizeof ($is_j_array); $j++):
                for ($k = 0; $k < sizeof ($is_k_array); $k++):
                    $is_index = implode (' ', [ $is_i_array[$i], $is_j_array[$j], $is_k_array[$k] ]);
                    array_push ($is_result, setCamelcase ($is_index));
                endfor;
            endfor;
        endfor;
        shuffle ($is_result);
        return $is_result;
    };

    define ('configKeywordArray', getDefineKeyword ());

    define ('defineFullCollection', [ ...defineColorLight, ...defineColorDark ]);

    define ('defineSmallCollection', array_values (array_filter (array_map (function ($i) { if (!in_array ($i, [ 'black', 'white' ])) return $i; }, defineFullCollection))));

    function getCollectionClasses (array $is_input = []): array {
        $is_array = [];
        for ($i = 0; $i < sizeof (defineTargetName); $i++):
            $is_index = explode ('-', defineTargetName[$i]);
            $is_array = array_merge ($is_array, [
                setFileName ([ $is_index[0], $is_index[1] ]) => array_map (function ($i) use ($is_index) {
                    return setFileName ([ $is_index[0], $i, $is_index[1] ]);
                }, $is_input),
            ]);
        endfor;
        return $is_array;
    };

    for ($i = 0; $i < sizeof (defineTargetName); $i++):
        $is_index = explode ('-', defineTargetName[$i]);
        define (setTargetName ([ 'define', ...$is_index ]), getCollectionClasses (defineSmallCollection)[setFileName ($is_index)]);
    endfor;

    function getColor (float|string $is_input = ''): string {
        $is_array = $is_collection = $is_result = [];
        if (in_array ($is_input, [ '' ])):
            foreach (defineSmallCollection as $is_input)
                if (!in_array ($is_input, defineColorNeutral))
                    array_push ($is_collection, $is_input);
            $is_input = array_rand (range (0, sizeof ($is_collection) - 1));
        else:
            $is_collection = defineSmallCollection;
            for ($i = 0; $i < sizeof ($is_collection); $i++) $is_array = array_merge ($is_array, [ $is_collection[$i] => $i ]);
            if (is_string ($is_input)): $is_input = in_array ($is_input, array_keys ($is_array)) ? $is_array[$is_input] : 0;
            elseif (is_numeric ($is_input)): $is_input = in_array ($is_input, range (0, sizeof ($is_collection) - 1)) ? $is_input : 0; endif;
        endif;
        foreach (defineTargetName as $is_target)
            $is_result[] = getCollectionClasses ($is_collection)[setFileName (explode ('-', $is_target))][$is_input];
        $is_result = array_unique ([ ...$is_result, ...defineBorder ]);
        sort ($is_result);
        return implode (' ', $is_result);
    };

    define ('defineButtonLine', array_map (function ($i) { return implode ('-', [ 'btn', 'outline', $i ]); }, defineFullCollection));
    define ('defineButtonSolid', array_map (function ($i) { return implode ('-', [ 'btn', $i ]); }, defineFullCollection));
    define ('defineLinkSolid', array_map (function ($i) { return implode ('-', [ 'link', $i ]); }, defineFullCollection));

    define ('defineBody', [ 'h-100', 'm-0', 'p-0', 'w-100' ]);
    define ('defineBorder', [ 'border', 'border-1' ]);
    define ('defineButton', [ 'btn', 'button', 'cursor-pointer', 'm-0', 'p-2' ]);
    define ('defineTable', [ 'm-0', 'p-0', 'row', 'w-100' ]);
    define ('defineTd', [ 'm-0', 'p-2', 'row', 'w-100' ]);
    define ('defineText', [ 'd-inline', 'lh-1', 'm-0', 'p-0', 'text-center' ]);
    define ('defineWrap', [ 'd-flex', 'justify-content-center', 'm-0', 'w-100' ]);

    define ('defineNavLink', [ 'fw-medium', 'text-decoration-none', 'link-opacity-50-hover', 'nav-link', ...defineText ]);
    define ('defineNavItem', [ 'nav-item', ...defineText ]);

    define ('defineBootstrap', [
        setTargetName ([ 'html' ]) => [ ...defineBody ],
        setTargetName ([ 'html', 'body' ]) => [ ...defineBody ],
        setTargetName ([ 'html', 'hr' ]) => [ 'mx-0', 'my-2', 'p-0', 'w-100' ],
        setTargetName ([ 'html', 'input' ]) => [ 'form-control', 'pe-5', 'ps-2', 'py-2' ],
        setTargetName ([ 'html', 'label' ]) => [ 'align-items-end', 'd-flex', 'justify-content-start', 'label', 'text-start', 'm-0', 'p-0' ],
        setTargetName ([ 'html', 'table' ]) => [ 'table', 'table-striped', 'table-hover', ...defineTable ],
        setTargetName ([ 'html', 'table', 'body' ]) => [ ...defineTable ],
        setTargetName ([ 'html', 'table', 'head' ]) => [ ...defineTable ],
        setTargetName ([ 'html', 'table', 'td' ]) => [ ...defineTd ],
        setTargetName ([ 'html', 'table', 'th' ]) => [ ...defineTd ],
        setTargetName ([ 'html', 'table', 'tr' ]) => [ ...defineTable ],
    ]);

    function getPool (): array {
        $is_array = [];
        foreach (defineFullCollection as $is_key => $is_value):
            $is_name = [ 'set', 'button' ];
            $is_name = [ ...$is_name, $is_value ];
            $is_content = [ ...defineButton, defineButtonSolid[$is_key] ];
            $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
            $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
            $is_name = [ ...$is_name, 'line' ];
            $is_content = [ ...defineButton, defineButtonLine[$is_key] ];
            $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
            $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
            $is_name = [ 'set', 'link' ];
            $is_content = [ ...defineNavLink, defineLinkSolid[$is_key] ];
            $is_array = array_merge ($is_array, [ setTargetName ([ ...$is_name, $is_value ]) => $is_content ]);
            $is_array = array_merge ($is_array, [ setFileName ([ ...$is_name, $is_value ]) => $is_content ]);
        endforeach;
        foreach ([ 'column', 'row' ] as $is_index):
            $is_name = [ 'set', 'wrap' ];
            $is_name = [ ...$is_name, $is_index ];
            $is_content = [
                ...in_array ($is_index, [ 'column' ]) ? [ 'flex-column' ] : [],
                ...in_array ($is_index, [ 'row' ]) ? [ 'flex-row', 'flex-wrap' ] : [],
                ...defineWrap,
            ];
            $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
            $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        endforeach;
        foreach (defineSmallCollection as $is_key => $is_value):
            $is_name = [ 'set', 'wrap' ];
            $is_name = [ ...$is_name, $is_value ];
            $is_content = [
                ...explode (' ', getColor ($is_key)),
                ...defineText,
            ];
            $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
            $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
            $is_name = [ 'set', 'text' ];
            $is_name = [ ...$is_name, $is_value ];
            $is_content = [
                defineTextEmphasis[$is_key],
                ...defineText,
            ];
            $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
            $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
            foreach (range (1, 6) as $is_index):
                $is_name = [ 'h' . $is_index, $is_value ];
                $is_content = [ defineTextEmphasis[$is_key], ...defineText, 'h' . $is_index ];
                $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
                $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
            endforeach;
        endforeach;
        $is_array = array_merge ($is_array, [ setTargetName ([ 'text' ]) => defineText ]);
        $is_array = array_merge ($is_array, [ setFileName ([ 'text' ]) => defineText ]);
        $is_array = array_merge ($is_array, [ setTargetName ([ 'nav', 'link' ]) => defineNavLink ]);
        $is_array = array_merge ($is_array, [ setFileName ([ 'nav', 'link' ]) => defineNavLink ]);
        $is_array = array_merge ($is_array, [ setTargetName ([ 'nav', 'item' ]) => defineNavItem ]);
        $is_array = array_merge ($is_array, [ setFileName ([ 'nav', 'item' ]) => defineNavItem ]);
        foreach (range (1, 6) as $is_index):
            $is_name = [ 'h' . $is_index ];
            $is_content = [ ...defineText, 'h' . $is_index ];
            $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
            $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        endforeach;
        foreach (range (1, 12) as $is_index):
            $is_name = [ 'col', str_pad ($is_index, 2, '0', STR_PAD_LEFT) ];
            $is_content = [ 'col-12', 'col-lg-' . $is_index, 'd-flex', 'justify-content-center', 'm-0' ];
            $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
            $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        endforeach;
        $is_frame = [ 'd-flex', 'flex-nowrap', 'justify-content-center', 'm-0', 'p-0', 'rounded-2' ];
        $is_content = [ ...$is_frame, 'bg-dark-subtle' ];
        $is_title = [ 'set', 'wrap' ];
        $is_name = [ ...$is_title, 'button' ];        
        $is_content = [ ...$is_content, 'btn-group' ];
        $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
        $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        $is_name = [ ...$is_title, 'input' ];
        $is_content = [ ...$is_content, 'input-group' ];
        $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
        $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        $is_name = [ ...$is_title, 'toolbar' ];
        $is_content = [ ...$is_frame, 'btn-toolbar' ];
        $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
        $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        $is_title = [ 'set', 'flex' ];
        $is_name = [ ...$is_title, 'left' ];
        $is_content = [ 'align-items-center', 'justify-content-start' ];
        $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
        $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        $is_name = [ ...$is_title, 'right' ];
        $is_content = [ 'align-items-center', 'justify-content-end' ];
        $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
        $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        $is_name = [ ...$is_title, 'top' ];
        $is_content = [ 'align-items-start', 'justify-content-center' ];
        $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
        $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        $is_name = [ ...$is_title, 'bottom' ];
        $is_content = [ 'align-items-end', 'justify-content-center' ];
        $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
        $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        $is_name = [ ...$is_title, 'center' ];
        $is_content = [ 'align-items-center', 'justify-content-center' ];
        $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
        $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        foreach (range (0, 5) as $is_index):
            $is_name = [ 'gap', str_pad ($is_index, 2, '0', STR_PAD_LEFT) ];
            $is_content = [
                'grid',
                'gap-' . $is_index,
            ];
            $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
            $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        endforeach;
        foreach (defineBootstrap as $is_key => $is_value):
            $is_array = array_merge ($is_array, [ $is_key => $is_value ]);
        endforeach;
        $is_name = [ 'set', 'text' ];
        $is_name = [ ...$is_name, 'disabled' ];
        $is_content = [ 'text-decoration-line-through' ];
        $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
        $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        $is_name = [ 'set', 'text' ];
        $is_name = [ ...$is_name, 'mono' ];
        $is_content = [ 'font-monospace', 'fw-semibold', ...defineText ];
        $is_array = array_merge ($is_array, [ setTargetName ($is_name) => $is_content ]);
        $is_array = array_merge ($is_array, [ setFileName ($is_name) => $is_content ]);
        ksort ($is_array);
        $is_result = [];
        foreach ($is_array as $is_key => $is_value):
            $is_value = array_unique ($is_value);
            sort ($is_value);
            $is_result = array_merge ($is_result, [
                $is_key => $is_value,
            ]);
        endforeach;
        return $is_result;
    };

    getJsonCreator (getPool (), 'define-pool');

    function isKeyExist (array $is_input = [], string $is_key = ''): bool {
        if (!isset ($is_input)) return false;
        if (!array_key_exists ($is_key, $is_input)) return false;
        return true;
    };

    function isKeyTrue (array $is_input = [], string $is_key = ''): bool {
        if (!isKeyExist ($is_input, $is_key)) return false;
        if (!isTrue ($is_input[$is_key])) return false;
        return true;
    };

    function isTrue (array|string|object $is_input = ''): bool {
        if (!isset ($is_input)) return false;
        if (empty ($is_input)) return false;
        return true;
    };

    function setArray (array|string $is_input = []): bool|array {
        return array_values (array_filter ([
            ...isString ($is_input) ? [ $is_input ] : [],
            ...isArray ($is_input) ? [ ...array_is_list ($is_input) ? $is_input : [] ] : [],
        ], function ($is_index) {
            if (isString ($is_index))
                return $is_index;
        }));
    };

    function setObjectVar ($is_input = []) {
        return is_object ($is_input) ? get_object_vars ($is_input) : $is_input;
    };

    function isArray (mixed $is_input = []): bool {
        $is_input = setObjectVar ($is_input);
        return isTrue ($is_input) && is_array ($is_input);
    };

    function isString (mixed $is_input = ''): bool {
        return isTrue ($is_input) && is_string ($is_input);
    };

    function getKeyValue (array $is_input = [], string $is_key = '', array|float|string $is_backup = []): array|string {
        $is_input = setObjectVar ($is_input);
        if (isKeyTrue ($is_input, $is_key))
            if (isTrue (setObjectVar ($is_input[$is_key])))
                return setObjectVar ($is_input[$is_key]);
        return $is_backup;
    };

    function setProper (array $is_input = [], array|string $is_key = '', array|float|string $is_backup = []): array {
        $is_result = [];
        if (isArray ($is_key)):
            foreach ($is_key as $is_index):
                $is_result[$is_index] = getKeyValue ($is_input, $is_index, $is_backup);
            endforeach;
        endif;
        if (isString ($is_key)):
            $is_result[$is_key] = getKeyValue ($is_input, $is_key, $is_backup);
        endif;
        return $is_result;
    };

    function isURL (string $is_input = ''): bool {
        return preg_match ('/^(https?|ftp|file):\/\/(www\.)?/', $is_input);
    };

    function setStyleArray (): array {
        $is_input = [ ...defineStyle, ...getPathArray ([ 'dir' => 'css' ]) ];
        if (isArray (setArray ($is_input))):
            return array_map (function ($is_index) {
                return implode ('', [ '<link', ' href=\'', $is_index, '\'', ' rel=\'stylesheet\'', ' crossorigin=\'anonymous\'', '>' ]);
            }, setArray ($is_input));
        endif;
        return [];
    };

    function setScriptArray (): array {
        $is_input = [ ...defineScript, ...getPathArray ([ 'dir' => 'js' ]) ];
        if (isArray (setArray ($is_input))):
            return array_map (function ($is_index) {
                return implode ('', [ '<script', ' src=\'', $is_index, '\'', ' crossorigin=\'anonymous\'', ...!isURL ($is_index) ? [ ' type=\'module\'' ] : [], '></script>' ]);
            }, setArray ($is_input));
        endif;
        return [];
    };

    function setAttrib (array|string $is_input = '', string $is_attrib = 'id'): array {
        $is_true = in_array ($is_attrib, [ 'class', 'style' ]);
        return isArray (setArray ($is_input)) ? [ ' ', setFileName ($is_attrib), '=\'', implode ($is_true ? ' ' : '', setArray ($is_input)), '\'' ] : [];
    };

    function setFileName (array|string $is_input = ''): string {
        $is_input = implode ('-', setArray ($is_input));
        if (isKeyTrue (pathinfo ($is_input), 'extension')) $is_input = pathinfo ($is_input)['filename'];
        $is_input = setTonicSyllable ($is_input);
        $is_input = preg_replace ('/[^0-9a-zA-Z_]/i', '-', $is_input);
        $is_input = preg_replace ('/-+/', '-', $is_input);
        return strtolower (trim ($is_input, '-'));
    };

    function setTargetName (array|string $is_input = ''): string {
        $is_input = implode (' ', setArray ($is_input));
        $is_input = setTonicSyllable ($is_input);
        $is_input = preg_replace ('/[^0-9a-zA-Z]/i', ' ', $is_input);
        $is_input = preg_replace ('/\s+/', ' ', $is_input);
        $is_input = explode (' ', trim ($is_input));
        return implode ('', array_map (function ($i, $k) { return !$k ? strtolower ($i) : ucfirst ($i); }, $is_input, array_keys ($is_input)));
    };

    function setCamelcase (array|string $is_input = ''): string {
        $is_input = implode (' ', setArray ($is_input));
        $is_input = preg_replace ('/\s+/', ' ', $is_input);
        return implode (' ', array_map (function ($i) { return in_array ($i, defineLowercase) ? strtolower ($i) : ucfirst ($i); }, explode (' ', trim ($is_input))));
    };

    function setTonicSyllable (string $is_input = ''): string {
        foreach ([
            'A' => '/(' . implode ('|', [ 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å' ]) . ')/',
            'E' => '/(' . implode ('|', [ 'È', 'É', 'Ê', 'Ë' ]) . ')/',
            'I' => '/(' . implode ('|', [ 'Ì', 'Í', 'Î', 'Ï' ]) . ')/',
            'O' => '/(' . implode ('|', [ 'Ò', 'Ó', 'Ô', 'Õ' ]) . ')/',
            'U' => '/(' . implode ('|', [ 'Ù', 'Ú', 'Û', 'Ü' ]) . ')/',
            'C' => '/(' . implode ('|', [ 'Ç' ]) . ')/',
            'N' => '/(' . implode ('|', [ 'Ñ' ]) . ')/',
            'Y' => '/(' . implode ('|', [ 'Ÿ' ]) . ')/',
            'a' => '/(' . implode ('|', [ 'à', 'á', 'â', 'ã', 'ä', 'å' ]) . ')/',
            'e' => '/(' . implode ('|', [ 'è', 'é', 'ê', 'ë' ]) . ')/',
            'i' => '/(' . implode ('|', [ 'ì', 'í', 'î', 'ï' ]) . ')/',
            'o' => '/(' . implode ('|', [ 'ò', 'ó', 'ô', 'õ' ]) . ')/',
            'u' => '/(' . implode ('|', [ 'ù', 'ú', 'û', 'ü' ]) . ')/',
            'c' => '/(' . implode ('|', [ 'ç' ]) . ')/',
            'n' => '/(' . implode ('|', [ 'ñ' ]) . ')/',
            'y' => '/(' . implode ('|', [ 'ÿ' ]) . ')/',
        ] as $is_replace => $is_pattern)
            $is_input = preg_replace ($is_pattern, $is_replace, $is_input);
        return trim ($is_input);
    };

    function setDir (string $is_input = ''): string {
        $is_result = implode ('/', [ '.', setFileName ($is_input) ]);
        if (!is_dir ($is_result))
            mkdir ($is_result, 0777, true);
        return $is_result;
    };

    function setArray2Json (array $is_array = [], string $is_filename = '') {
        $is_extension = 'json';
        $is_true = isArray ($is_array) && isString ($is_filename);
        if (isTrue ($is_true)):
            $is_fopen = [];
            if (isKeyTrue (pathinfo ($is_filename), 'extension')):
                if (isTrue (pathinfo ($is_filename)['extension'] === $is_extension)):
                    $is_fopen = [ setDir (pathinfo ($is_filename)['extension']), pathinfo ($is_filename)['basename'] ];
                else:
                    $is_fopen = [ setDir ($is_extension), setFileName ($is_filename) . '.' . $is_extension ];
                endif;
            else:
                $is_fopen = [ setDir ($is_extension), setFileName ($is_filename) . '.' . $is_extension ];
            endif;
            $is_fopen = fopen (implode ('/', [ '.', ...$is_fopen ]), 'w');
            fwrite ($is_fopen, json_encode ($is_array));
            fclose ($is_fopen);
        endif;
    };

    function setSELETOR (array $is_input = [], array $is_proper = []): array {
        $is_proper = setProper ($is_proper, [ 'id', 'class', 'style', 'wrap' ]);
        $is_wrap = in_array ($is_proper['wrap'], defineSeletor) ? $is_proper['wrap'] : 'div';
        return isArray ($is_input) ? [
            '<',
                $is_wrap,
                ...setAttrib ($is_proper['id']),
                ...setClass ([ ...isArray (setArray ($is_proper['class'])) ? setArray ($is_proper['class']) : [], getClass ('setWrapColumn') ]),
                ...setStyle (isArray ($is_proper['style']) ? $is_proper['style'] : []),
            '>',
                ...$is_input,
            '</',
                $is_wrap,
            '>',
        ] : [
        ];
    };
    
    function getFileContent (string $is_input = ''): string {
        return isFileExist ($is_input) ? file_get_contents (isFileExist ($is_input)) : '';
    };

    function isPathExist (string $is_input = ''): string {
        return file_exists (setPath ($is_input)) ? setPath ($is_input) : '';
    };

    function isFileExist (string $is_input = ''): string {
        if (isKeyTrue (pathinfo ($is_input), 'extension')):
            $is_input = implode ('.', [ setFileName (pathinfo ($is_input)['filename']), pathinfo ($is_input)['extension'] ]);
        else:
            $is_input = implode ('.', [ setFileName ($is_input), 'json' ]);
        endif;
        return isPathExist ($is_input);
    };

    function setProperFileArray (array $is_input = []): array {
        return [
            ...setProper ($is_input, 'dir', 'json'),
            ...setProper ($is_input, 'search'),
        ];
    };

    function getPathArray (array $is_input = []): array {
        $is_proper = setProperFileArray ($is_input);
        return array_map (function ($is_index) { return isPathExist ($is_index); }, getFileArray ([ 'dir' => $is_proper['dir'], 'search' => $is_proper['search'] ]));
    };

    function getFileArray (array $is_input = []): array {
        $is_proper = setProperFileArray ($is_input);
        return array_values (array_filter (scandir (setDir ($is_proper['dir'])), function ($is_index) use ($is_proper) {
            if (isKeyTrue (pathinfo ($is_index), 'extension'))
                if (isTrue (pathinfo ($is_index)['extension'] === $is_proper['dir']))
                    if (!in_array (substr ($is_index, 0, 1), [ '_' ]))
                        if (isString ($is_proper['search'])):
                            if (str_contains ($is_index, $is_proper['search'])):
                                if (getFileContent ($is_index)):
                                    return $is_index;
                                endif;
                            endif;
                        elseif (getFileContent ($is_index)):
                            return $is_index;
                        endif;
        }));
    };

    function setObject2Array (array|object $is_input = []): array {
        $is_result = [];
        foreach ($is_input as $is_key => $is_value):
            if (is_object ($is_value)): $is_result[$is_key] = setObject2Array (get_object_vars ($is_value));
            elseif (is_array ($is_value)): $is_result[$is_key] = setObject2Array ($is_value);
            else: $is_result[$is_key] = $is_value; endif;
        endforeach;
        return $is_result;
    };

    function setJson2Array (string $is_input = ''): array {
        return getFileContent ($is_input) ? setObject2Array (json_decode (getFileContent ($is_input))) : [];
    };

    function arrayIsLikeJson (array $is_array = [], string $is_filename = ''): bool {
        if (isKeyTrue (pathinfo ($is_filename), 'extension')):
            if (pathinfo ($is_filename)['extension'] === 'json'):
                return isArray ($is_array) ? json_decode (getFileContent ($is_filename)) === json_encode ($is_array) : false;
            endif;
        endif;
        return false;
    };

    function setPath (string $is_input = ''): string {
        if (isKeyTrue (pathinfo ($is_input), 'extension')):
            $is_dir = setDir (pathinfo ($is_input)['extension']);
            $is_filename = implode ('.', [ setFileName (pathinfo ($is_input)['filename']), setFileName (pathinfo ($is_input)['extension']) ]);
            return implode ('/', [ $is_dir, $is_filename ]);
        endif;
        return '';
    };

    function getJsonCreator (array $is_array = [], string $is_filename = '') {
        if (isKeyTrue (pathinfo ($is_filename), 'extension')):
            if (isTrue (pathinfo ($is_filename)['extension'] === 'json')):
                if (isPathExist ($is_filename)):
                    if (arrayIsLikeJson ($is_array, $is_filename)): else:
                        setArray2Json ($is_array, $is_filename);
                    endif;
                else:
                    setArray2Json ($is_array, $is_filename);
                endif;
            else:
                setArray2Json ($is_array, implode ('.', [ pathinfo ($is_filename)['filename'], 'json' ]));
            endif;
        else:
            setArray2Json ($is_array, implode ('.', [ setFileName ($is_filename), 'json' ]));
        endif;
    };

    function getClass (string $is_input = ''): string {
        if (isKeyTrue (definePool, $is_input)):
            $is_array = definePool[$is_input];
            sort ($is_array);
            return implode (' ', $is_array);
        endif;
        return '';
    };

    function setClass (array|string $is_input = []): array {
        $is_input = implode (' ', setArray ($is_input));
        $is_input = explode (' ', $is_input);
        $is_input = array_unique ($is_input);
        sort ($is_input);
        $is_input = array_values ($is_input);
        return setAttrib ($is_input, 'class');
    };

    function setStyle (array $is_input = []): array {
        if (!array_is_list ($is_input))
            return setAttrib (implode (' ', array_map (function ($is_index) use ($is_input) {
                return implode ('', [ $is_index, ': ', $is_input[$is_index], ';' ]);
            }, array_keys ($is_input))), 'style');
        return [];
    };

    function setHeadTitle (): array {
        return [
            '<title>',
                implode (' | ', array_map (function ($is_index) {
                    if (isKeyTrue (configDescription, $is_index))
                        return setCamelcase (configDescription[$is_index]);
                }, [ 'title', 'subtitle', 'description' ])),
            '</title>',
        ];
    };

    function setMetaWrapper (array $is_input = []): array {
        return isArray (setArray ($is_input)) ? [ '<meta', ...setArray ($is_input), '>' ] : [];
    };

    function setMetaDescription (): array {
        return [
            ...array_map (function ($is_index) {
                if (isKeyTrue (configDescription, $is_index)):
                    $is_name = [ ...in_array ($is_index, [ 'title' ]) ? [ 'author' ] : [], ...in_array ($is_index, [ 'subtitle' ]) ? [ 'description' ] : [] ];
                    return implode ('', setMetaWrapper ([ ...setAttrib ($is_name, 'name'), ...setAttrib (configDescription[$is_index], 'content') ]));
                endif;
            }, [ 'title', 'subtitle' ]),
        ];
    };

    function setMetaKeyword (): array {
        return isArray (configKeywordArray) ? setMetaWrapper ([ ...setAttrib ('keywords', 'name'), ...setAttrib (implode (', ', configKeywordArray), 'content') ]) : [];
    };

    function setMetaViewport (): array {
        $is_input = [ 'width=device-width', 'initial-scale=1', 'shrink-to-fit=no' ];
        return setMetaWrapper ([ ...setAttrib ('viewport', 'name'), ...setAttrib (implode (', ', $is_input), 'content') ]);
    };

    /*
    *
    *
    *
    *
    *
    */

    function setGroup (array|string $is_input = '', string $is_field = 'span'): array {
        $is_set = 'group';
        $is_content = [ 'align-items-start', 'd-flex', 'justify-content-start', 'p-2', 'w-100' ];
        return IsArray (setArray ($is_input)) ? [ 
            '<div', ...setClass ([ 'd-flex', 'justify-content-center', 'w-100' ]), '>',
                '<div', ...setClass ([ setFileName ([ $is_set, 'container' ]), getClass ('setWrapInput') ]), '>',
                    ...in_array ($is_field, [ 'textarea' ]) ? [
                        '<textarea disabled', ...setClass ([ setFileName ([ $is_set, 'content' ]), 'form-control', ...$is_content ]), '>', ...setArray ($is_input), '</textarea>',
                    ] : [
                        '<span', ...setClass ([ setFileName ([ $is_set, 'content' ]), 'input-group-text', ...$is_content ]), '>', ...setArray ($is_input), '</span>',
                    ],
                    '<button',
                        ...setAttrib ('button', 'type'),
                        ...setClass ([ setFileName ([ $is_set, 'command' ]), getClass ('setButtonSecondaryLine') ]),
                    '>',
                        setCamelcase ('copiar'),
                    '</button>',
                '</div>',
            '</div>',
        ] : [
        ];
    };

?>