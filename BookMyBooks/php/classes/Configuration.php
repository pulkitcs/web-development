<?php
  class Configuration {
    private $keys;

    function __construct($configs) {
      $this->keys = $configs;
    }

    public function getKey($keyName) {
      return $this->keys[$keyName] ? $this->keys[$keyName] : getenv($keyName);
    }

    public function setKey($key, $value) {
      if($this->keys[$key]) return false;
      else
       return putenv("$key=$value");
    }
  }
?>