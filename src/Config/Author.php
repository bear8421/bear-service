<?php

namespace Bear8421\Bear\Services\Config;

use Bear8421\Bear\Services\Environment;
use Bear8421\Bear\Services\Traits\Version;

class Author implements Environment
{
    use Version;

    public static function getAuthorName(): string
    {
        return self::POWERED_BY_NAME;
    }

    public static function getAuthorEmail(): string
    {
        return self::POWERED_BY_EMAIL;
    }

    public static function getCopyrightYear($startYear = '')
    {
        if (empty($startYear)) {
            $copyrightYear = date('Y');
        } else {
            $copyrightYear = $startYear . '-' . date('Y');
        }
        return $copyrightYear;
    }
}