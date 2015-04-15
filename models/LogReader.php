<?php

/**
 * LogReader.php
 * model class for table LogReader
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * @author      Florian Bieringer <florian.bieringer@uni-passau.de>
 * @copyright   2014 Stud.IP Core-Group
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GPL version 2
 * @category    Stud.IP
 * @since       3.0
 */
class LogReader extends SimpleORMap {
    /* protected static function configure($config = array())
      {
      $config['db_table'] = 'log_reader';
      parent::configure($config);
      } */

    public function __construct($id = null) {
        $this->db_table = "log_reader";
        $this->additional_fields['file'] = true;
        parent::__construct($id);
    }

    public static function findAll() {
        return self::findBySQL("1=1");
    }

    public function getFile() {
        
        // Check if location is still active
        if ($this->real_location && !file_exists($this->real_location)) {
            $this->real_location = null;
        }
        
        // Fallback if no file
        if (!$this->real_location) {
            $this->store();
            if (!$this->real_location) {
                return null;
            }
        }
        
        return array_reverse(file($this->real_location));
    }

    public function parseLocation() {

        // Check for absolut path
        if (file_exists($this->location)) {
            return $this->location;
        }

        $trim = "/" . ltrim($this->location, '/');

        $check = array($GLOBALS['STUDIP_BASE_PATH'], $GLOBALS['ABSOLUTE_PATH_STUDIP'], $GLOBALS['PLUGINS_PATH']);

        foreach ($check as $c) {
            $file = $c . $trim;
            if (file_exists($file)) {
                return $file;
            }
        }
    }
    
    public function store() {
        $this->real_location = $this->parseLocation();
        parent::store();
    }

}
