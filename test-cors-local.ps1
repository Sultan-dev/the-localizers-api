Add-Type -AssemblyName System.Net.Http

$url = 'http://127.0.0.1:8001/api/login'
$client = New-Object System.Net.Http.HttpClient

Write-Output "=== Testing CORS on $url ==="
Write-Output ""

# Test OPTIONS (preflight)
Write-Output "1. OPTIONS (Preflight) Request:"
Write-Output "================================"
$req = New-Object System.Net.Http.HttpRequestMessage([System.Net.Http.HttpMethod]::Options, $url)
$req.Headers.Add('Origin', 'http://127.0.0.1:5174')
$req.Headers.Add('Access-Control-Request-Method', 'POST')
$req.Headers.Add('Access-Control-Request-Headers', 'Content-Type,Authorization')

try {
    $res = $client.SendAsync($req).Result
    Write-Output "Status Code: $($res.StatusCode)"
    Write-Output ""
    Write-Output "Response Headers:"
    foreach ($header in $res.Headers) {
        Write-Output "$($header.Key): $($header.Value)"
    }
} catch {
    Write-Output "Error: $_"
}

Write-Output ""
Write-Output ""

# Test POST
Write-Output "2. POST Login Request:"
Write-Output "======================"
$req2 = New-Object System.Net.Http.HttpRequestMessage([System.Net.Http.HttpMethod]::Post, $url)
$req2.Headers.Add('Origin', 'http://127.0.0.1:5174')
$req2.Headers.Add('Content-Type', 'application/json')
$req2.Content = New-Object System.Net.Http.StringContent('{"email":"admin@localier.com","password":"password"}', [System.Text.Encoding]::UTF8, 'application/json')

try {
    $res2 = $client.SendAsync($req2).Result
    Write-Output "Status Code: $($res2.StatusCode)"
    Write-Output ""
    Write-Output "Response Headers:"
    foreach ($header in $res2.Headers) {
        Write-Output "$($header.Key): $($header.Value)"
    }
} catch {
    Write-Output "Error: $_"
}
