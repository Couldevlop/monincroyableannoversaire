 <?php
 function FileNameGen($string) {
       
        # On remplace les caractères spéciaux
        $string = str_replace(array(
        '?',
        '!',
        '.',
        ','), '', $string);
       
        $string = trim($string); // Après avoir supprimé la ponctuation, on supprime les éventuels espaces avant et après $string (afin d'éviter les multi-tirets)
       
        $string = str_replace(array('€',
        '#',
        '+',
        '*',
        ' ',
        "'",
        '"',
        '²',
        '&',
        '~',
        '{',
        '(',
        '[',
        '|',
        '`',
        '^',
        ')',
        '}',
        '=',
        '}',
        '^',
        '$',
        '£',
        '¤',
        '%',
        '*',
        ';',
        ':',
        '/',
        '\\',
        '§',
        '>',
        '@',
        '§',
        '©',
        '<'), '', $string);
        # On remplace les variantes de "e"
        $string = str_replace(array('ê', 'ë', 'é', 'è'), 'e', $string);
        # On remplace les variantes de "u"
        $string = str_replace(array('ù', 'µ', 'û', 'ü'), 'u', $string);
        # On remplace les variantes de "a"
        $string = str_replace(array('à', 'ä', 'â'), 'a', $string);
        # On remplace les variantes de "o"
        $string = str_replace(array('ô', 'ö', 'ò'), 'o', $string);
        # On remplace les variantes de "i"
        $string = str_replace(array('î', 'ï', 'ì', ), 'i', $string);
        # On remplace les variantes de "y"
        $string = str_replace(array('ÿ'), 'y', $string);
        # On remplace les variantes de "c"
        $string = str_replace(array('ç'), 'c', $string);
        # On remplace les variantes de "n"
        $string = str_replace(array('ñ'), 'n', $string);
         
        return $string;
} 

?>