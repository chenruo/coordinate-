<?php
/**
 * Coord.php
 * Description:
 * Author Chenruo <klshcr@163.com>
 * Date: 2018/2/28
 * Time: 下午2:25
 */

namespace Cr46\CoordTransform;


class Coord
{
    public $lng;
    public $lat;
    public $type;

    /**
     * ControllerCreator constructor.
     *
     * @param string $lng
     * @param string $lat
     * @param int $type
     */
    public function __construct($lng='',$lat='',$type=1)
    {
        $this->lng = $lng;
        $this->lat = $lat;
        $this->type = $type;
    }

    //GCJ-02(火星，高德) 坐标转换成 BD-09(百度) 坐标
    //@param bd_lon 百度经度
    //@param bd_lat 百度纬度
    public function hxToBd($gg_lon,$gg_lat){
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $gg_lon;
        $y = $gg_lat;
        $z = sqrt($x * $x +$y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $data['lng'] = $z * cos($theta) +0.0065;
        $data['lat'] = $z * sin($theta)+ 0.006;
        return $data;
    }

    //BD-09(百度) 坐标转换成  GCJ-02(火星，高德) 坐标
    //@param bd_lon 百度经度
    //@param bd_lat 百度纬度
    public function bdToHx($bd_lon,$bd_lat){
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $bd_lon - 0.0065;
        $y = $bd_lat - 0.006;
        $z = sqrt($x * $x+ $y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $data['lng'] = $z * cos($theta);
        $data['lat'] = $z * sin($theta);
        return $data;
    }

    public function __toString()
    {
        if($this->type==1) return json_encode($this->hxToBd($this->lng,$this->lat));
        return json_encode($this->bdToHx($this->lng,$this->lat));
    }
}