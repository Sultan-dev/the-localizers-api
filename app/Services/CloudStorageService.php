<?php

namespace App\Services;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\UploadedFile;
use Exception;

class CloudStorageService
{
    private $storage;
    private $bucket;
    private $projectId;
    private $bucketName;

    public function __construct()
    {
        try {
            $this->projectId = env('GOOGLE_CLOUD_PROJECT_ID');
            $this->bucketName = env('GCS_BUCKET_NAME');

            // Initialize Google Cloud Storage client
            $keyFilePath = env('GOOGLE_APPLICATION_CREDENTIALS');
            
            if ($keyFilePath && file_exists($keyFilePath)) {
                $this->storage = new StorageClient([
                    'projectId' => $this->projectId,
                    'keyFilePath' => $keyFilePath,
                ]);
            } else {
                // Use Application Default Credentials (ADC) for Cloud Run
                $this->storage = new StorageClient([
                    'projectId' => $this->projectId,
                ]);
            }

            $this->bucket = $this->storage->bucket($this->bucketName);
        } catch (Exception $e) {
            \Log::error('Cloud Storage initialization error: ' . $e->getMessage());
            throw new Exception('Failed to initialize Cloud Storage: ' . $e->getMessage());
        }
    }

    /**
     * Upload a file to Google Cloud Storage
     *
     * @param UploadedFile $file
     * @param string $folder The folder path in GCS (e.g., 'cards', 'projects')
     * @return array ['url' => string, 'path' => string, 'filename' => string]
     */
    public function uploadFile(UploadedFile $file, $folder = 'cards'): array
    {
        try {
            $filename = $this->generateFileName($file);
            $path = "{$folder}/{$filename}";

            // Upload to GCS (bucket-level access controls apply)
            $object = $this->bucket->upload(
                fopen($file->getRealPath(), 'r'),
                [
                    'name' => $path,
                    'metadata' => [
                        'uploadedAt' => date('Y-m-d H:i:s'),
                        'originalName' => $file->getClientOriginalName(),
                        'contentType' => $file->getMimeType(),
                    ],
                ]
            );

            // Use public URL directly
            $publicUrl = $this->getPublicUrl($path);

            return [
                'url' => $publicUrl,
                'path' => $path,
                'filename' => $filename,
                'public_url' => $publicUrl,
            ];
        } catch (Exception $e) {
            \Log::error('File upload error: ' . $e->getMessage());
            throw new Exception('Failed to upload file: ' . $e->getMessage());
        }
    }

    /**
     * Delete a file from Google Cloud Storage
     *
     * @param string $path The file path in GCS
     * @return bool
     */
    public function deleteFile(string $path): bool
    {
        try {
            if (!$path || $path === '') {
                return true;
            }

            $object = $this->bucket->object($path);
            if ($object->exists()) {
                $object->delete();
            }

            return true;
        } catch (Exception $e) {
            \Log::error('File deletion error: ' . $e->getMessage());
            throw new Exception('Failed to delete file: ' . $e->getMessage());
        }
    }

    /**
     * Get a signed URL for a file
     *
     * @param string $path The file path in GCS
     * @param int $duration Duration in seconds
     * @return string
     */
    public function getSignedUrl(string $path, int $duration = 3600): string
    {
        try {
            $object = $this->bucket->object($path);
            $signedUrl = $object->signedUrl(
                new \DateTime('+' . $duration . ' seconds')
            );

            return $signedUrl;
        } catch (Exception $e) {
            \Log::error('Signed URL generation error: ' . $e->getMessage());
            throw new Exception('Failed to generate signed URL: ' . $e->getMessage());
        }
    }

    /**
     * Get public URL for a file (requires public access)
     *
     * @param string $path
     * @return string
     */
    public function getPublicUrl(string $path): string
    {
        return "https://storage.googleapis.com/{$this->bucketName}/{$path}";
    }

    /**
     * List files in a folder
     *
     * @param string $folder
     * @return array
     */
    public function listFiles(string $folder = 'cards'): array
    {
        try {
            $objects = $this->bucket->objects(['prefix' => $folder . '/']);
            $files = [];

            foreach ($objects as $object) {
                $files[] = [
                    'name' => $object->name(),
                    'size' => $object->info()['size'] ?? 0,
                    'updated' => $object->info()['timeUpdated'] ?? null,
                    'url' => $this->getSignedUrl($object->name()),
                ];
            }

            return $files;
        } catch (Exception $e) {
            \Log::error('List files error: ' . $e->getMessage());
            throw new Exception('Failed to list files: ' . $e->getMessage());
        }
    }

    /**
     * Check if file exists in GCS
     *
     * @param string $path
     * @return bool
     */
    public function fileExists(string $path): bool
    {
        try {
            return $this->bucket->object($path)->exists();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Generate a unique filename
     *
     * @param UploadedFile $file
     * @return string
     */
    private function generateFileName(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = time();
        $random = substr(uniqid(), -6);

        return "card_{$timestamp}_{$random}.{$extension}";
    }
}
