Add-Type -AssemblyName System.Net.Http
$client = New-Object System.Net.Http.HttpClient
$url = 'http://127.0.0.1:8001/api/login'

Write-Output '=== OPTIONS (preflight) - LOCAL CORS Headers Check ==='
$req = New-Object System.Net.Http.HttpRequestMessage([System.Net.Http.HttpMethod]::Options, $url)
$req.Headers.Add('Origin','http://localhost:5174')
$req.Headers.Add('Access-Control-Request-Method','POST')
$req.Headers.Add('Access-Control-Request-Headers','Content-Type,Authorization')
$res = $client.SendAsync($req).Result
Write-Output ('Status: ' + $res.StatusCode)
Write-Output ''
Write-Output 'Response headers:'
$res.Headers | ForEach-Object { Write-Output ("{0}: {1}" -f $_.Key, ($_.Value -join ',')) }
$res.Content.Headers | ForEach-Object { Write-Output ("{0}: {1}" -f $_.Key, ($_.Value -join ',')) }

Write-Output ''
Write-Output '=== POST (login) - LOCAL ==='
$req2 = New-Object System.Net.Http.HttpRequestMessage([System.Net.Http.HttpMethod]::Post, $url)
$req2.Headers.Add('Origin','http://localhost:5174')
$req2.Content = New-Object System.Net.Http.StringContent('{"email":"test@example.com","password":"password"}', [System.Text.Encoding]::UTF8, 'application/json')
$res2 = $client.SendAsync($req2).Result
Write-Output ('Status: ' + $res2.StatusCode)
Write-Output 'Response headers:'
$res2.Headers | ForEach-Object { Write-Output ("{0}: {1}" -f $_.Key, ($_.Value -join ',')) }
$res2.Content.Headers | ForEach-Object { Write-Output ("{0}: {1}" -f $_.Key, ($_.Value -join ',')) }
Write-Output 'Body:'
Write-Output ($res2.Content.ReadAsStringAsync().Result)
