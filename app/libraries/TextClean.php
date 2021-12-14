<?php
function addQuotes($str)
{
    return "'$str'";
}
function sanitize($str)
{
    return htmlspecialchars(strip_tags($str));
}
