<?php

function paginate($reload, $shown_page, $total_pages) {
    
    $adjacency = 2;
    $prevLabel = "<";
    $nextLabel = ">";
    $firstLabel = "<<";
    $lastLabel = ">>";
    $out = "";

    // the very first page & previous
    if ($shown_page == 1) {
        $out.= "<li><span>" . $prevLabel . "</span></li>";
    } elseif ($shown_page == 2) {
        $out.= "<li><a title='The first page' href=\"" . $reload . "\">" . $firstLabel . "</a></li>";
        $out.= "<li><a title='The previous page' href=\"" . $reload . "\">" . $prevLabel . "</a></li>";
    } else {
        $out.= "<li><a title='The first page' href=\"" . $reload . "\">" . $firstLabel . "</a></li>";
        $out.= "<li><a title='The previous page' href=\"" . $reload . "&amp;page=" . ($shown_page - 1) . "\">" . $prevLabel . "</a></li>";
    }

    // 3 dots if needed
    if ($shown_page - $adjacency > 1)
        $out.= "<li><span>...</span></li>";

    // Calculate page_min & page_max
    $pmin = ($shown_page > $adjacency) ? ($shown_page - $adjacency) : 1;
    $pmax = ($shown_page < ($total_pages - $adjacency)) ? ($shown_page + $adjacency) : $total_pages;

    // Display all pages in range of pmin to pmax
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $shown_page) {
            $out.= "<li  class=\"active\"><a href=''>" . $i . "</a></li>";
        } elseif ($i == 1) {
            $out.= "<li><a  href=\"" . $reload . "\">" . $i . "</a></li>";
        } else {
            $out.= "<li><a  href=\"" . $reload . "&amp;page=" . $i . "\">" . $i . "</a></li>";
        }
    }

    // 3 dots if needed
    if ($shown_page < ($total_pages - $adjacency)) {
        $out.= "<li><span>...</span></li>";
    }

    // Next
    if ($shown_page < $total_pages) {
        $out.= "<li><a title='The next page' href=\"" . $reload . "&amp;page=" . ($shown_page + 1) . "\">" . $nextLabel . "</a></li>";
    } else {
        $out.= "<span>" . $nextLabel . "</span>";
    }

    // The very last page
    $out.= "<li><a title='The last page' href=\"" . $reload . "&amp;page=" . $total_pages . "\">" . $lastLabel . "</a></li>";

    $out.= "";
    return $out;
}
