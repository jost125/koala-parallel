<?php

namespace Koala\Parallel\Synchronization;

class SemaphoreFactory {

	public function createBinary($keyName) {
		$key = intval(substr(md5($keyName), 15, 15), 16);;
		$semaphore = new BinarySemaphore($key);
		return $semaphore;
	}
}
