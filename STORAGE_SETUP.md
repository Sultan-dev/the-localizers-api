# Storage Setup Guide

## Overview
The API stores uploaded files in the `public/storage` directory, which is publicly accessible.

## Directory Structure
```
public/
├── storage/
│   ├── cards/              # Card preview images
│   └── [other uploads]/    # Other file types
```

## How File Storage Works

### Upload Flow
1. **User uploads image** via Dashboard form
2. **API receives file** in CardController
3. **File stored** at: `public/storage/cards/card_[unique_id].png`
4. **URL returned** to frontend: `{API_URL}/storage/cards/card_[unique_id].png`

### Example
- **Stored at**: `/public/storage/cards/card_69660dd8da356.png`
- **Accessible via**: `http://the-localizers-api-155888821034.me-central2.run.app/storage/cards/card_69660dd8da356.png`

## Important Notes

### Local Development
- The `public/storage` directory has been created
- Ensure the directory has write permissions: `chmod -R 755 public/storage`
- Files uploaded during development will be stored here

### Production (Cloud Run)
- The `public/storage` directory needs to **persist** between deployments
- **Option 1**: Use Cloud Storage (GCS) to persist files
- **Option 2**: Use Cloud SQL + file service
- **Option 3**: Mount persistent volume

### Routes
Two routes serve storage files:
1. **Web route** (`/storage/{path}`): Main file serving route
2. **API route** (`/api/storage/{path}`): Fallback API route

Both point to the same `public/storage` directory.

## File Permissions

Make sure the storage directory is writable:
```bash
chmod -R 755 public/storage
chmod -R 755 public/storage/cards
```

## Troubleshooting

### Files Return 404
- [ ] Verify `public/storage` directory exists
- [ ] Check file permissions: `ls -la public/storage/cards/`
- [ ] Ensure files are actually being written to the directory
- [ ] Check API logs for errors

### Files Upload But Don't Appear
- [ ] Check `public/storage/cards` has write permissions
- [ ] Verify the file was actually moved (check with `ls -la`)
- [ ] Ensure the returned URL matches the file location

### In Docker/Cloud Run
- [ ] Use Cloud Storage or persistent volumes for file storage
- [ ] Don't rely on local filesystem for persistence
- [ ] Consider mounting GCS bucket to `/app/public/storage`
