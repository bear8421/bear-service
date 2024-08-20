<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 17/8/24
 * Time: 23:10
 */

namespace Bear8421\Bear\Services\Tools;

use Bear8421\Bear\Services\API\HungNgToolsServices;

class Iptables extends HungNgToolsServices
{
    protected $portList = array(3306, 22, 21);
    protected $rules;

    /**
     * @param int[] $portList
     */
    public function setPortList(array $portList): self
    {
        $this->portList = $portList;
        return $this;
    }

    public function addRules($newIP = '', $oldIP = ''): self
    {
        $rules = '';
        $suffix = " && \\";
        foreach ($this->portList as $port) {
            $port = trim($port);
            if (!empty($newIP)) {
                $newIP = trim($newIP);
                $rules .= PHP_EOL . "iptables -I INPUT -i eth0 -s " . $newIP . " -p tcp --destination-port " . $port . " -j ACCEPT" . $suffix;
            }
            if (!empty($oldIP)) {
                $oldIP = trim($oldIP);
                $rules .= PHP_EOL . "iptables -D INPUT -i eth0 -s " . $oldIP . " -p tcp --destination-port " . $port . " -j ACCEPT" . $suffix;
            }
        }
        if (!empty($rules)) {
            $begin = "sudo iptables -S && \\";
            $end = PHP_EOL . "sudo service iptables save && \\" . PHP_EOL . 'sudo iptables -S' . PHP_EOL;
            $rules = $begin . $rules . $end;
        }
        $rules = trim($rules, $suffix) . PHP_EOL;

        if (empty($rules)) {
            $rules .= 'Vui lòng nhập địa chi IP cần phân quyền vào hệ thống';
        }
        $this->rules = $rules;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getPortList(): array
    {
        return $this->portList;
    }

    /**
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }
}
