<?php

namespace App;


class Snowflake {
	/**
	 * CRC16 algortihm implementation
	 * http://php.net/manual/fr/function.crc32.php#28012
	 * @author spectrumizer@cycos.net
	 */
	public static function crc16( $string ) {
		$crc = 0xFFFF;
		for ($x = 0; $x < strlen ($string); $x++) {
			$crc = $crc ^ ord($string[$x]);
			for ($y = 0; $y < 8; $y++) {
				if (($crc & 0x0001) == 0x0001) {
					$crc = (($crc >> 1) ^ 0xA001);
				} else { $crc = $crc >> 1; }
			}
		}
		return $crc;
	}

	public static function create( $name ) {
		return ( ( ~ ( 0 << 48 ) ) | ( Snowflake::crc16( $name ) << 48 ) ) & time();
	}
}