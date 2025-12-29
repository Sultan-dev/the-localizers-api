# Deployment Summary & Next Steps

## Current Status

✅ Docker image built and pushed to GCR
✅ Cloud Run service deployed
✅ Cloud SQL instance with private IP created
✅ Database 'localizer' created
✅ Cloud SQL connected via Unix socket (`--add-cloudsql-instances`)
❌ API returning 500 error - likely missing database tables

## Configuration Applied

```bash
Service: the-localizers-api
Region: me-central2
Image: gcr.io/localizer-ai-agent-project/localizer-api:latest
Cloud SQL: localizer-ai-agent-project:me-central2:localizer-db (Unix socket)
```

## Next Steps to Fix 500 Error

### 1. Check Current Environment Variables

```bash
gcloud run services describe the-localizers-api \
  --region me-central2 \
  --format="yaml(spec.template.spec.containers[0].env)"
```

Verify these are set:

- `APP_KEY=base64:2Jn2nERM/UFV9OzAjdcobXOGJtIn1nx4G7ogR8Th1So=`
- `DB_HOST=/cloudsql/localizer-ai-agent-project:me-central2:localizer-db`
- `DB_DATABASE=localizer`
- `DB_USERNAME=root`
- `DB_PASSWORD=Localcontent2025_`

### 2. Run Database Migrations

**Option A: Via Cloud Run Job**

```bash
# Create migration job
gcloud run jobs create localizer-migrate \
  --image gcr.io/localizer-ai-agent-project/localizer-api:latest \
  --region me-central2 \
  --add-cloudsql-instances=localizer-ai-agent-project:me-central2:localizer-db \
  --set-env-vars="APP_ENV=production,APP_KEY=base64:2Jn2nERM/UFV9OzAjdcobXOGJtIn1nx4G7ogR8Th1So=,DB_CONNECTION=mysql,DB_HOST=/cloudsql/localizer-ai-agent-project:me-central2:localizer-db,DB_PORT=3306,DB_DATABASE=localizer,DB_USERNAME=root,DB_PASSWORD=Localcontent2025_" \
  --command php \
  --args artisan,migrate,--force

# Execute migration
gcloud run jobs execute localizer-migrate --region me-central2 --wait
```

**Option B: Via Cloud SQL Proxy (Local)**

```bash
# Download Cloud SQL Proxy
curl -o cloud-sql-proxy https://dl.google.com/cloudsql/cloud_sql_proxy.darwin.arm64
chmod +x cloud-sql-proxy

# Start proxy
./cloud-sql-proxy localizer-ai-agent-project:me-central2:localizer-db &

# Run migrations locally
cd /Users/s_alkhubayzi/vsCodeProjects/web_development/the-localizer-project/the-localizers-api-main
DB_HOST=127.0.0.1 php artisan migrate --force
```

**Option C: Import SQL File**

```bash
# If you have seed data
gcloud sql import sql localizer-db gs://YOUR_BUCKET/localizer_db.sql \
  --database=localizer
```

### 3. View Logs

```bash
# Get recent logs
gcloud logging read "resource.type=cloud_run_revision AND resource.labels.service_name=the-localizers-api" \
  --limit 50 \
  --format="table(timestamp,textPayload,jsonPayload.message)" \
  --project localizer-ai-agent-project

# Or watch logs in real-time
gcloud alpha run services logs tail the-localizers-api --region me-central2
```

### 4. Test After Fixing

```bash
# Test public endpoint
curl https://the-localizers-api-155888821034.me-central2.run.app/api/cards

# Should return JSON array of cards (empty if no data)
```

### 5. Seed Sample Data (Optional)

```bash
php artisan db:seed
```

## Common Issues & Solutions

**500 Error**: Check logs for specific error

- Missing `APP_KEY` → Update env vars
- Can't connect to DB → Verify Cloud SQL connection string
- Tables don't exist → Run migrations

**Permission Denied**: Cloud SQL connection issue

- Check if Cloud SQL instance allows connections
- Verify service account has `cloudsql.client` role

**Empty Response**: Successful but no data

- Run seeder to add sample data

## Quick Command Reference

```bash
# Rebuild & redeploy
docker build -t gcr.io/localizer-ai-agent-project/localizer-api:latest .
docker push gcr.io/localizer-ai-agent-project/localizer-api:latest
gcloud run deploy the-localizers-api --image gcr.io/localizer-ai-agent-project/localizer-api:latest --region me-central2

# Update env vars
gcloud run services update the-localizers-api \
  --region me-central2 \
  --set-env-vars="KEY=value,KEY2=value2"

# View service details
gcloud run services describe the-localizers-api --region me-central2
```
