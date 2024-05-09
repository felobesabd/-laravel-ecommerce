<?php

function getFolder()
{
    return app()->getLocale() === 'ar' ? 'css-rtl' : 'css';
}

define('PAGINATION_COUNT', 10);
