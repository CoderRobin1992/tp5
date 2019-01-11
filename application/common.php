<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @Function GetIpLookup 根据IP判断所在城市，新浪接口
 * @param string $ip
 * @return array
 * @Author: 肖子恒
 * @Date: 2018/12/24
 * @Time: 9:27
 * @Return: array
 */
if( ! function_exists('get_city_by_ip') )
{
    function get_city_by_ip($ip = '') {
        $ip1num = $ip2num = 0;
        $ipAddr1 = $ipAddr2 = '';
        $dat_path = './qqwry.dat';
        if(!preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
            return 'IP Address Error';
        }
        if( !$fd = @fopen($dat_path, 'rb') ) {
            return 'IP date file not exists or access denied';
        }
        $ip = explode('.', $ip);
        $ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];
        $DataBegin = fread($fd, 4);
        $DataEnd = fread($fd, 4);
        $ipbegin = implode('', unpack('L', $DataBegin));
        if($ipbegin < 0) $ipbegin += pow(2, 32);
        $ipend = implode('', unpack('L', $DataEnd));
        if($ipend < 0) $ipend += pow(2, 32);
        $ipAllNum = ($ipend - $ipbegin) / 7 + 1;
        $BeginNum = 0;
        $EndNum = $ipAllNum;
        while($ip1num>$ipNum || $ip2num<$ipNum) {
            $Middle= intval(($EndNum + $BeginNum) / 2);
            fseek($fd, $ipbegin + 7 * $Middle);
            $ipData1 = fread($fd, 4);
            if(strlen($ipData1) < 4) {
                fclose($fd);
                return 'System Error';
            }
            $ip1num = implode('', unpack('L', $ipData1));
            if($ip1num < 0) $ip1num += pow(2, 32);

            if($ip1num > $ipNum) {
                $EndNum = $Middle;
                continue;
            }
            $DataSeek = fread($fd, 3);
            if(strlen($DataSeek) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
            fseek($fd, $DataSeek);
            $ipData2 = fread($fd, 4);
            if(strlen($ipData2) < 4) {
                fclose($fd);
                return 'System Error';
            }
            $ip2num = implode('', unpack('L', $ipData2));
            if($ip2num < 0) $ip2num += pow(2, 32);
            if($ip2num < $ipNum) {
                if($Middle == $BeginNum) {
                    fclose($fd);
                    return 'Unknown';
                }
                $BeginNum = $Middle;
            }
        }
        $ipFlag = fread($fd, 1);
        if($ipFlag == chr(1)) {
            $ipSeek = fread($fd, 3);
            if(strlen($ipSeek) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
            fseek($fd, $ipSeek);
            $ipFlag = fread($fd, 1);
        }
        if($ipFlag == chr(2)) {
            $AddrSeek = fread($fd, 3);
            if(strlen($AddrSeek) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $ipFlag = fread($fd, 1);
            if($ipFlag == chr(2)) {
                $AddrSeek2 = fread($fd, 3);
                if(strlen($AddrSeek2) < 3) {
                    fclose($fd);
                    return 'System Error';
                }
                $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
                fseek($fd, $AddrSeek2);
            } else {
                fseek($fd, -1, SEEK_CUR);
            }
            while(($char = fread($fd, 1)) != chr(0))
                $ipAddr2 .= $char;
            $AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
            fseek($fd, $AddrSeek);
            while(($char = fread($fd, 1)) != chr(0))
                $ipAddr1 .= $char;
        } else {
            fseek($fd, -1, SEEK_CUR);
            while(($char = fread($fd, 1)) != chr(0))
                $ipAddr1 .= $char;
            $ipFlag = fread($fd, 1);
            if($ipFlag == chr(2)) {
                $AddrSeek2 = fread($fd, 3);
                if(strlen($AddrSeek2) < 3) {
                    fclose($fd);
                    return 'System Error';
                }
                $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
                fseek($fd, $AddrSeek2);
            } else {
                fseek($fd, -1, SEEK_CUR);
            }
            while(($char = fread($fd, 1)) != chr(0)){
                $ipAddr2 .= $char;
            }
        }
        fclose($fd);
        if(preg_match('/http/i', $ipAddr2)) {
            $ipAddr2 = '';
        }

        $ipaddr = "$ipAddr1 $ipAddr2";
        $ipaddr = preg_replace('/CZ88.NET/is', '', $ipaddr);
        $ipaddr = preg_replace('/^s*/is', '', $ipaddr);
        $ipaddr = preg_replace('/s*$/is', '', $ipaddr);
        if(preg_match('/http/i', $ipaddr) || $ipaddr == '') {
            $ipaddr = 'Unknown';
        }
        $ipaddr = mb_convert_encoding ( $ipaddr, "UTF-8", "GB2312" );
        $rarr = array();
        //有可能不包含省份在里面
        $arr = array();
        $pos = strpos($ipaddr, '省');
        if($pos) {
            $arr = explode('省', $ipaddr);
        } else {
            $arr[1] = $ipaddr;
        }

        $arr = explode('市', $arr[1]);
        $rarr['city'] = $arr[0];
        $city = $arr[0];
        if(empty($rarr['city'])) {
            $rarr['city'] = $ipaddr;
            return $rarr;
        } else {
            return $rarr;
        }
    }
}

/**
 * @Function getip 获取IP地址
 * @return array|false|string
 * @Author: 肖子恒
 * @Date: 2018/12/24
 * @Time: 9:28
 * @Return: array|false|string
 */
if( ! function_exists('get_ip') )
{
    function get_ip() {
        if (getenv ( "HTTP_CLIENT_IP" ) && strcasecmp ( getenv ( "HTTP_CLIENT_IP" ), "unknown" )) {
            $ip = getenv ( "HTTP_CLIENT_IP" );
        } else if (getenv ( "HTTP_X_FORWARDED_FOR" ) && strcasecmp ( getenv ( "HTTP_X_FORWARDED_FOR" ), "unknown" )) {
            $ip = getenv ( "HTTP_X_FORWARDED_FOR" );
        } else if (getenv ( "REMOTE_ADDR" ) && strcasecmp ( getenv ( "REMOTE_ADDR" ), "unknown" )) {
            $ip = getenv ( "REMOTE_ADDR" );
        } else if (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], "unknown" )) {
            $ip = $_SERVER ['REMOTE_ADDR'];
        } else {
            $ip = "unknown";
        }
        return ($ip);
    }
}