<?php
function wbws($sentence) {
    $pspell_link = pspell_new("en");
    $words = preg_split('/\s+/', $sentence, -1, PREG_SPLIT_NO_EMPTY);
    $result = array();
    $corrected_sentence_html = "";
    $corrected_sentence = "";
    $is_corrected = false;
    foreach ($words as $word) {
        if (pspell_check($pspell_link, $word)) {
            $corrected_sentence .= $word . " ";
            $corrected_sentence_html .= $word . " ";
        } else {
            $suggestions = pspell_suggest($pspell_link, $word);
            if (count($suggestions) > 0) {
                $corrected_sentence_html .= "<i>" . $suggestions[0] . "</i> ";
                $corrected_sentence .= $suggestions[0] . " ";
                $is_corrected = true;
            } else {
                return false;
            }
        }
    }
    $corrected_sentence = trim($corrected_sentence);
    $corrected_sentence_html = trim($corrected_sentence_html);
    if ($is_corrected) {
        $result[] = $corrected_sentence;
        $result[] = $corrected_sentence_html;
    } else {
        return false;
    }
    return $result;
}
