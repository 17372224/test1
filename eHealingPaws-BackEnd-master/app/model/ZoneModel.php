<?php

use BunnyPHP\Model;

class ZoneModel extends Model
{

    function isZoneAvailable($zoneId)
    {
        return is_numeric($zoneId) && $this->where('zone_id = ?', [$zoneId])->fetch('1')['1'] == '1';
    }

    function getZoneName($zoneId)
    {
        return $this->where('zone_id = ?', [$zoneId])->fetch('zone_name')['zone_name'];
    }

}