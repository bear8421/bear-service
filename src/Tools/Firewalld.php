<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 17/8/24
 * Time: 23:32
 */

namespace Bear8421\Bear\Services\Tools;

use Bear8421\Bear\Services\API\HungNgToolsServices;

class Firewalld extends HungNgToolsServices
{
    /**
     * Generate basic firewall-cmd rule
     *
     * @param string $zone
     * @param string $type
     * @param string $value
     * @param bool $permanent
     * @return string
     */
    function generateBasicRule(string $zone, string $type, string $value, bool $permanent = true): string
    {
        $command = "firewall-cmd --zone=$zone --add-$type=$value";
        if ($permanent) {
            $command .= " --permanent";
        }
        return $command;
    }

    /**
     * Generate advanced firewall-cmd rule
     *
     * @param string $zone
     * @param string $type
     * @param string $value
     * @param array $options
     * @param bool $permanent
     * @return string
     */
    function generateAdvancedRule(
        string $zone,
        string $type,
        string $value,
        array $options = [],
        bool $permanent = true
    ): string {
        $command = "firewall-cmd --zone=$zone --add-$type=$value";

        foreach ($options as $option => $optValue) {
            $command .= " --$option=$optValue";
        }

        if ($permanent) {
            $command .= " --permanent";
        }

        return $command;
    }
}
