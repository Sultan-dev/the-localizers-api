This file explains how to use the `.env.cloudsql` template to run and deploy the Laravel API with a Cloud SQL instance that uses a Private IP.

1. Local setup (quick test using `.env`)

- Copy the template to `.env`:

```bash
cp .env.cloudsql .env
```

- Edit `.env` and replace `YOUR_CLOUD_SQL_PRIVATE_IP`, `DB_USERNAME`, and `DB_PASSWORD` with your Cloud SQL private IP and credentials.

- Generate `APP_KEY`:

```bash
php artisan key:generate --ansi
# OR generate locally and paste into .env:
php -r "echo 'base64:'.base64_encode(random_bytes(32));" ; echo
```

- Run migrations (ensure DB is reachable from your machine/network):

```bash
php artisan migrate --force
```

- Start the dev server:

```bash
php artisan serve --host=0.0.0.0 --port=8080
```

2. Deploying to Cloud Run with Private IP

Requirements:

- Your Cloud SQL instance has Private IP configured (you did this).
- A Serverless VPC Connector in the same region as Cloud Run.
- Cloud Run service configured to route egress to the VPC connector (all traffic or private IPs only).

Steps:

- Create (if not already) a Serverless VPC Connector:

```bash
gcloud compute networks vpc-access connectors create connector-me --region=me-central2 --network=localizer-vpc --range=10.8.0.0/28
```

- Deploy the Cloud Run service and set env-vars (do NOT include secrets in source; prefer Secret Manager):

```bash
gcloud run deploy localizer-api \
  --image gcr.io/localizer-ai-agent-project/localizer-api:TAG \
  --region me-central2 \
  --platform managed \
  --no-allow-unauthenticated \
  --vpc-connector connector-me \
  --vpc-egress all-traffic \
  --set-env-vars "DB_HOST=10.144.208.3,DB_DATABASE=localizer,DB_USERNAME=your_db_user,DB_PASSWORD=your_db_password,APP_ENV=production,APP_KEY=base64:..."
Notes:

- For security, store sensitive values in Secret Manager and reference them in Cloud Run.
- If you prefer service-to-service IAM (recommended), keep `--no-allow-unauthenticated` and grant `roles/run.invoker` to caller service accounts.

3. Testing after deploy

- From another Cloud Run service that has VPC connector and IAM rights, request an ID token and call the API using the service URL.
- For local testing of private IP access you need access to the VPC (VPN or bastion host).

4. Troubleshooting

- If Cloud Run cannot reach Cloud SQL private IP, verify:
  - VPC connector exists and is in the same region.
  - The Cloud Run service uses that VPC connector and egress is configured.
  - Cloud SQL authorized networks and IAM roles.

If you want, I can:

- Add a `scripts/create_env.sh` to auto-fill `.env` from environment variables (for CI/deploy).
- Add a Cloud Run `--set-secrets` example using Secret Manager instead of plain env-vars.

Which would you like next?
```
