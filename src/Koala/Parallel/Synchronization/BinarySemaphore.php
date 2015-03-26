<?php

namespace Koala\Parallel\Synchronization;

class BinarySemaphore {

	private $key;
	private $semaphoreId;
	private $locked;
	
	public function __construct($key) {
		$this->key = $key;
	}
	
	public function lock() {
		if (PHP_OS !== 'Linux') {
			return;
		}
		
		sem_acquire($this->getSemaphoreId());
		$this->locked = true;
	}
	
	public function unlock() {
		if (PHP_OS !== 'Linux') {
			return;
		}
		
		sem_release($this->getSemaphoreId());
		$this->locked = false;
	}

	private function getSemaphoreId() {
		if ($this->semaphoreId === null) {
			$this->semaphoreId = sem_get($this->key);
		}
		return $this->semaphoreId;
	}

	public function __destruct() {
		if ($this->locked) {
			$this->unlock();
		}
	}

}
