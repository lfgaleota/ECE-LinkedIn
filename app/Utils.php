<?php

namespace App;

use App\Exceptions\QuotaExceededException;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Rackspace\RackspaceAdapter;
use OpenCloud\ObjectStore\Constants\UrlType;

class Utils {
	public static function getFileUrl($path) {
		if(Storage::cloud()->getDriver()->getAdapter() instanceof RackspaceAdapter) {
			return Storage::cloud()->getDriver()->getAdapter()->getContainer()->getObject($path)->getPublicUrl(UrlType::SSL);
		}
		return Storage::url($path);
	}

	public static function store( $user, $file, $path ) {
		$size = filesize( $file->getRealPath() ) / pow( 1024, 2 );
		$newquota = $size + $user->usagequota;
		if( $newquota <= User::quota_usage_max ) {
			$user->usagequota = $newquota;
			$user->save();
			return $file->store( $path );
		}
		throw new QuotaExceededException();
	}
}