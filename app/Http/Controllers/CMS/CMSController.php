<?php

namespace App\Http\Controllers\CMS;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Imageupload;

class CMSController extends Controller
{
  public function __construct() {
      $this->middleware('auth');
  }

  function delete_file($destination) {
    if (file_exists($destination) && !is_dir($destination)) unlink($destination);
  }

  // Destination will be always in the uploads folder, the extension in the destination will be ignored
  function file_upload($origin, $destination) {
    if (gettype($origin) === 'string') {
      $extension = pathinfo($origin, PATHINFO_EXTENSION);
      $origin_path = $origin;
    } else {
      $extension = $origin->extension();
      $origin_path = $origin->getRealPath();
    }

    $path_parts = pathinfo($destination);
    $timestamp = microtime(true);
    $timestamp = strtr($timestamp, ".", "_");
    $destination_path = "uploads/{$path_parts['dirname']}/{$path_parts['basename']}_{$timestamp}.{$extension}";
    
    copy($origin_path, $destination_path);

    return $destination_path;
  }
}