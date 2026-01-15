# Cloud Storage Configuration Guide

## Environment Variables

Add these to your `.env` file or Cloud Run environment variables:

```env
# Google Cloud Project ID
GOOGLE_CLOUD_PROJECT_ID=your-project-id

# Google Cloud Storage Bucket Name
GCS_BUCKET_NAME=your-bucket-name

# Path to Google Cloud service account key JSON file
# (For Cloud Run, omit this to use Application Default Credentials)
GOOGLE_APPLICATION_CREDENTIALS=/path/to/service-account-key.json

# Alternative: For Cloud Run, set as JSON string
# GOOGLE_APPLICATION_CREDENTIALS_JSON='{"type":"service_account",...}'
```

## Cloud Run Setup

### 1. Create a GCS Bucket
```bash
gsutil mb -p YOUR_PROJECT_ID gs://your-bucket-name/
```

### 2. Create Service Account for Cloud Run
```bash
gcloud iam service-accounts create cloud-run-storage \
    --project=YOUR_PROJECT_ID \
    --display-name="Cloud Run Storage"

# Grant Storage Admin role
gcloud projects add-iam-policy-binding YOUR_PROJECT_ID \
    --member="serviceAccount:cloud-run-storage@YOUR_PROJECT_ID.iam.gserviceaccount.com" \
    --role="roles/storage.objectAdmin"
```

### 3. Deploy to Cloud Run
```bash
gcloud run deploy localizer-api \
    --source . \
    --platform managed \
    --region us-central1 \
    --service-account=cloud-run-storage@YOUR_PROJECT_ID.iam.gserviceaccount.com \
    --set-env-vars GOOGLE_CLOUD_PROJECT_ID=YOUR_PROJECT_ID,GCS_BUCKET_NAME=your-bucket-name
```

## Local Development Setup

### 1. Install Google Cloud SDK
```bash
brew install google-cloud-sdk
```

### 2. Authenticate
```bash
gcloud auth application-default login
```

### 3. Create a local bucket (optional, for testing)
```bash
gsutil mb gs://your-local-bucket-name/
```

### 4. Set Environment Variables
```bash
export GOOGLE_CLOUD_PROJECT_ID="your-project-id"
export GCS_BUCKET_NAME="your-bucket-name"
```

## API Endpoints

### Create/Update Card with Image
**POST** `/api/cards`
**POST** `/api/cards/{id}`

```bash
curl -X POST http://localhost:8000/api/cards \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "title=My Card" \
  -F "type=government" \
  -F "preview_image=@/path/to/image.jpg"
```

### List Card Images
**GET** `/api/storage/cards/list`

```bash
curl -X GET http://localhost:8000/api/storage/cards/list \
  -H "Authorization: Bearer YOUR_TOKEN"
```

Response:
```json
{
  "success": true,
  "data": [
    {
      "name": "cards/card_1234567890_abc123.jpg",
      "size": 102400,
      "updated": "2024-01-14T10:30:00Z",
      "url": "https://storage.googleapis.com/bucket/cards/card_1234567890_abc123.jpg?X-Goog-Signature=..."
    }
  ],
  "count": 1
}
```

### Get Signed URL
**POST** `/api/storage/signed-url`

```bash
curl -X POST http://localhost:8000/api/storage/signed-url \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"path":"cards/card_1234567890_abc123.jpg","duration":7200}'
```

### Delete Image
**POST** `/api/storage/delete`

```bash
curl -X POST http://localhost:8000/api/storage/delete \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"path":"cards/card_1234567890_abc123.jpg"}'
```

### Get Image Info
**POST** `/api/storage/info`

```bash
curl -X POST http://localhost:8000/api/storage/info \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"path":"cards/card_1234567890_abc123.jpg"}'
```

Response:
```json
{
  "success": true,
  "path": "cards/card_1234567890_abc123.jpg",
  "signed_url": "https://storage.googleapis.com/bucket/...",
  "public_url": "https://storage.googleapis.com/bucket/cards/card_1234567890_abc123.jpg"
}
```

## Delete Card
**DELETE** `/api/cards/{id}`

This will automatically delete the associated image from GCS.

```bash
curl -X DELETE http://localhost:8000/api/cards/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## Important Notes

1. **Signed URLs** are valid for 1 hour by default (configurable)
2. **Image Size Limit** is 2048 KB per image
3. **Supported Formats**: JPEG, PNG, GIF, WebP
4. **Cloud Run Service Account** must have `roles/storage.objectAdmin` or equivalent permissions
5. **Error Handling**: All operations include detailed error logging for debugging

## Troubleshooting

### Images not uploading
- Check GCS bucket name and permissions
- Verify service account has Storage Admin role
- Check Laravel logs: `storage/logs/laravel.log`

### Signed URLs not working
- Ensure bucket CORS settings allow your domain
- Check URL expiration time
- Verify file exists in bucket

### Permission errors
```bash
# Check service account permissions
gcloud projects get-iam-policy YOUR_PROJECT_ID \
    --flatten="bindings[].members" \
    --filter="bindings.members:serviceAccount:*"
```
