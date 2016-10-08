<?php
  /**
   * Debug module
   * v 1.0
   */
  class debug {
    static function all() {
      echo '<pre>';

      if (isset($_SESSION) && ($_SESSION != null)) {
        echo '<h3>Session:</h3>';
        print_r($_SESSION);
      }

      if (isset($_COOKIE) && ($_COOKIE != null)) {
        echo '<h3>Cookie:</h3>';
        print_r($_COOKIE);
      }

      if (isset($_GET) && ($_GET != null)) {
        echo '<h3>Get:</h3>';
        print_r($_GET);
      }

      if (isset($_POST) && ($_POST != null)) {
        echo '<h3>Post:</h3>';
        print_r($_POST);
      }

      echo '</pre>';
    }

    /**
     * Show variable
     */
    static function b($a) {
      if (is_array($a)) {
        if ((isset($a)) && is_array($a)) {
          echo '<div style="position: relative; background: white; font-size: 13px; border: 2px solid red; padding: 5px 15px;"><pre>';
          print_r($a);
          echo '</div></pre>';
        }
      } else {
        echo '<div style="position: relative; background: white; font-size: 13px; border: 2px solid red; padding: 5px 15px;"><pre>';
        print_r($a);
        echo '</div></pre>';
      }
    }

    /**
     * Show variable and exit
     */
    static function be($a) {
      if (is_array($a)) {
        if ((isset($a)) && is_array($a)) {
          echo '<div style="position: relative; background: white; font-size: 13px; border: 2px solid red; padding: 5px 15px;"><pre>';
          print_r($a);
          echo '</div></pre>';
          exit();
        }
      } else {
        echo '<div style="position: relative; background: white; font-size: 13px; border: 2px solid red; padding: 5px 15px;"><pre>';
        print_r($a);
        echo '</div></pre>';
        exit();
      }
    }

    /**
     * Show SESSION
     */
    static function s() {
      echo '<div style="position: relative; background: white; font-size: 13px; border: 2px solid red; padding: 5px 15px;"><pre>';
      print_r($_SESSION);
      echo '</div></pre>';
    }

    /**
     * Show COOKIE
     */
    static function c() {
      echo '<div style="position: relative; background: white; font-size: 13px; border: 2px solid red; padding: 5px 15px;"><pre>';
      print_r($_COOKIE);
      echo '</div></pre>';
    }
    
  }