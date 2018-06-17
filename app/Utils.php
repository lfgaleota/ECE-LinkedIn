<?php

namespace App;

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
}