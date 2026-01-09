$url = 'https://willene-unmiasmatic-tiffaney.ngrok-free.dev/api/login'
Write-Output '=== OPTIONS (preflight) ==='
$h = @{ Origin = 'http://localhost:5173'; 'Access-Control-Request-Method' = 'POST'; 'Access-Control-Request-Headers' = 'Content-Type' }
try {
    $r = Invoke-WebRequest -Uri $url -Method Options -Headers $h -UseBasicParsing -ErrorAction Stop
    Write-Output ("Status: " + $r.StatusCode)
    Write-Output "Headers:"
    $r.Headers.GetEnumerator() | ForEach-Object { Write-Output ("{0}: {1}" -f $_.Name, $_.Value) }
} catch {
    Write-Output "Request failed: $($_.Exception.Message)"
}

Write-Output ''
Write-Output '=== POST (login) ==='
$h2 = @{ Origin = 'http://localhost:5173'; 'Content-Type' = 'application/json' }
$body = '{"email":"test@example.com","password":"password"}'
try {
    $r2 = Invoke-WebRequest -Uri $url -Method Post -Headers $h2 -Body $body -UseBasicParsing -ErrorAction Stop
    Write-Output ("Status: " + $r2.StatusCode)
    Write-Output "Headers:"
    $r2.Headers.GetEnumerator() | ForEach-Object { Write-Output ("{0}: {1}" -f $_.Name, $_.Value) }
    Write-Output "Body:"
    Write-Output $r2.Content
} catch {
    Write-Output "Request failed: $($_.Exception.Message)"
}
