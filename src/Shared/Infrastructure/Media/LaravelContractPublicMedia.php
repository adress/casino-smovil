<?php

namespace Src\Shared\Infrastructure\Media;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Src\Shared\Domain\Media\PublicMediaManagerContract;

class LaravelContractPublicMedia implements PublicMediaManagerContract
{

  public function publishTempFile(?string $tempURL, string $subFolder = '', string $name = ''): ?string
  {
    if ($tempURL == null) return null;

    $tempFilename = basename($tempURL);
    $extension = pathinfo($tempFilename, PATHINFO_EXTENSION);
    $finalName = empty($name) ? $tempFilename : $name . '.' . $extension;

    // Construct the destination path, including any subFolder within the public directory
    $destinationPath = (empty($subFolder) ? '' : trim($subFolder, '/') . '/') . $finalName;

    //check if file already exist return path
    if (Storage::disk('public')->exists($destinationPath)) {
      return Storage::url($destinationPath);
    }

    if (!Storage::disk('public')->copy('temp/' . $tempFilename, $destinationPath)) {
      return null;
    }

    return Storage::url($destinationPath);
  }

  public function deleteByUrl(string $url): bool
  {
    // remove /storage/ from the URL if is present
    $url = str_replace('/storage/', '', $url);
    return Storage::disk('public')->delete($url);
  }
}
