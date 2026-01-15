# Installation Instructions

## Add Google Cloud Storage Package

Run the following command in your Laravel API project root:

```bash
composer require google/cloud-storage
```

This package is required for the Cloud Storage functionality to work.

## Database Migration

After adding the Cloud Storage Service, run:

```bash
php artisan migrate
```

This will add the `preview_path` column to the `cards` table to store the GCS file path.

## Configuration

See [CLOUD_STORAGE_SETUP.md](./CLOUD_STORAGE_SETUP.md) for detailed setup instructions.

## Summary of Changes

### New Files Created:
1. **`app/Services/CloudStorageService.php`** - Service for handling all Google Cloud Storage operations
2. **`app/Http/Controllers/StorageController.php`** - API endpoints for storage management
3. **`database/migrations/2024_01_14_add_preview_path_to_cards.php`** - Database migration

### Files Modified:
1. **`app/Http/Controllers/CardController.php`** - Updated to use CloudStorageService for image uploads/deletions
2. **`app/Models/Card.php`** - Added `preview_path` to fillable fields
3. **`routes/api.php`** - Added new storage management routes

## Features

✅ **Upload Images to GCS** - When creating/updating cards
✅ **Delete Images from GCS** - When updating/deleting cards
✅ **List Card Images** - View all images in the cards folder
✅ **Generate Signed URLs** - Secure, temporary URLs for image access
✅ **Automatic Cleanup** - Old images deleted when cards are updated
✅ **Error Handling** - Comprehensive logging and error responses
✅ **Cloud Run Ready** - Uses Application Default Credentials

## Quick Test

1. **Create a Card with Image:**
```bash
curl -X POST http://localhost:8000/api/cards \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "title=Test Card" \
  -F "type=government" \
  -F "preview_image=@image.jpg"
```

2. **List All Card Images:**
```bash
curl -X GET http://localhost:8000/api/storage/cards/list \
  -H "Authorization: Bearer YOUR_TOKEN"
```

3. **Delete a Card (and its image):**
```bash
curl -X DELETE http://localhost:8000/api/cards/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

For more details, see [CLOUD_STORAGE_SETUP.md](./CLOUD_STORAGE_SETUP.md)
