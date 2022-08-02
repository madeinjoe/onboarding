<?php
defined( 'ABSPATH' ) || die( "Can't access directly" );

class ShortCodeMI
{
    public function __construct()
    {
        add_shortcode('short_code_time',[$this, 'current_time_ukraine_cest']);
        add_shortcode('short_code_time2',[$this, 'current_time_ukraine_cest2']);
    }

    public function current_time_ukraine_cest()
    {
        $date = new DateTime("now", new DateTimeZone('Europe/Berlin') );
        echo  "<span class='current_time_zone_cest'> Ukraine Time ".$date->format("F d").", ".$date->format("Y").", ".$date->format("h:i a")." CEST</span>";
    }

    public function current_time_ukraine_cest2()
    {
        $date = new DateTime("now", new DateTimeZone('Europe/Berlin') );
        echo  "<span class='current_time_zone_cest2'> Current Ukraine Time ".$date->format("F d").", ".$date->format("Y").", ".$date->format("h:i a")." CEST</span>";
    }
}

new ShortCodeMI;