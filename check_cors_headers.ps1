Add-Type -AssemblyName System.Net.Http
$client = New-Object System.Net.Http.HttpClient
$url = 'https://willene-unmiasmatic-tiffaney.ngrok-free.dev/api/login'

Write-Output '=== OPTIONS (preflight) - CORS Headers Check ==='
$req = New-Object System.Net.Http.HttpRequestMessage([System.Net.Http.HttpMethod]::Options, $url)
$req.Headers.Add('Origin','http://localhost:5174')
$req.Headers.Add('Access-Control-Request-Method','POST')
$req.Headers.Add('Access-Control-Request-Headers','Content-Type,Authorization')

$res = $client.SendAsync($req).Result
Write-Output "Status: $($res.StatusCode)"
Write-Output ""
Write-Output "CORS Headers in Response:"
Write-Output "========================"

$corsHeaders = @('Access-Control-Allow-Origin', 'Access-Control-Allow-Methods', 
                 'Access-Control-Allow-Headers', 'Access-Control-Allow-Credentials',
                 'Access-Control-Max-Age')

foreach ($header in $corsHeaders) {
    if ($res.Headers.Contains($header)) {
        $value = $res.Headers.GetValues($header) -join ','
        Write-Output "$header : $value"
    } else {
        Write-Output "$header : ❌ MISSING"
    }
}

Write-Output ""
Write-Output "All Response Headers:"
Write-Output "===================="
$res.Headers | ForEach-Object { Write-Output "$($_.Key): $($_.Value -join ',')" }
$res.Content.Headers | ForEach-Object { Write-Output "$($_.Key): $($_.Value -join ',')" }
