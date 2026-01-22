<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessConfiguration;
class FbrInvoiceService
{
    protected string $env; // sandbox or production
    protected string $token;
    protected string $baseUrl;
    public function __construct(string $env = 'sandbox')
    {
        $this->env = $env;
        $this->baseUrl = 'https://gw.fbr.gov.pk/di_data/v1/di/';
        $this->setToken();
    }
    public function validateInvoice(array $payload): array
    {
        try {
            $url = $this->baseUrl . ($this->env === 'production' ? 'validateinvoicedata' : 'validateinvoicedata_sb');
            $jsonData = json_encode($payload);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $jsonData,
                CURLOPT_SSL_VERIFYPEER => false, // Added to bypass SSL issues
                CURLOPT_SSL_VERIFYHOST => false, // Added to bypass SSL issues
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->token,
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $curlError = curl_error($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            // Check for cURL errors
            if ($response === false || $curlError) {
                Log::error('FBR Validation cURL Error', [
                    'error' => $curlError,
                    'url' => $url,
                    'response' => $response,
                    'httpCode' => $httpCode 
                ]);
                return [
                    'success' => false,
                    'error' => $curlError ?: 'Failed to connect to FBR API',
                    'statusCode' => null,
                    'status' => null,
                ];
            }
            $data = json_decode($response, true);
            // Check for JSON decode errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'success' => false,
                    'error' => 'Invalid response from FBR API: ' . json_last_error_msg(),
                    'statusCode' => null,
                    'status' => null,
                ];
            }
            $dated = $data['dated'] ?? null;
            $invoiceStatuses = $data['validationResponse']['invoiceStatuses'] ?? [];
            $firstInvoiceStatus = $invoiceStatuses[0] ?? [];
            $error = !empty($data['validationResponse']['error'])
                ? $data['validationResponse']['error']
                : ($firstInvoiceStatus['error'] ?? 'Unknown error');
            $errorCode = !empty($data['validationResponse']['errorCode'])
                ? $data['validationResponse']['errorCode']
                : ($firstInvoiceStatus['errorCode'] ?? null);
            $status = $data['validationResponse']['status'] ?? null;
            $statusCode = $data['validationResponse']['statusCode'] ?? null;
            return [
                'success'         => $statusCode === '00' && $status === 'Valid',
                'dated'           => $dated,
                'data'            => $data,
                'statusCode'      => $statusCode,
                'status'          => $status,
                'errorCode'       => $errorCode,
                'error'           => $error,
                'invoiceStatuses' => $invoiceStatuses,
            ];
        } catch (\Exception $e) {
            Log::error('Invoice Validation Failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
    public function postInvoice(array $payload): array
    {
        try {
            $url = $this->baseUrl . ($this->env === 'production' ? 'postinvoicedata' : 'postinvoicedata_sb');
            // $jsonData = json_encode($payload);
            // $curl = curl_init();
            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => $url,
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 30,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => $jsonData,
            //     CURLOPT_SSL_VERIFYPEER => false, // Added to bypass SSL issues
            //     CURLOPT_SSL_VERIFYHOST => false, // Added to bypass SSL issues
            //     CURLOPT_HTTPHEADER => array(
            //         'Authorization: Bearer ' . $this->token,
            //         'Content-Type: application/json'
            //     ),
            // ));
            // $response = curl_exec($curl);
            // $curlError = curl_error($curl);
            // $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            // curl_close($curl);
            $jsonData = json_encode($payload);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $jsonData,
                CURLOPT_SSL_VERIFYPEER => false, // Added to bypass SSL issues
                CURLOPT_SSL_VERIFYHOST => false, // Added to bypass SSL issues
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->token,
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $curlError = curl_error($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);


            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata_sb',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => 'POST',
            // CURLOPT_POSTFIELDS =>'{
            // "invoiceType": "Sale Invoice",
            // "invoiceDate": "2026-01-21",
            // "sellerNTNCNIC": "8923980",
            // "sellerBusinessName": "Secureism Pvt Ltd",
            // "sellerProvince": "PUNJAB",
            // "sellerAddress": "F3 Center of Technology, Zaraj Society, Islamabad Pakistan",
            // "buyerNTNCNIC": "2906767",
            // "buyerBusinessName": "YUNUS TEXTILE MILLS LIMITED",
            // "buyerProvince": "SINDH",
            // "buyerAddress": "Plot # H-23/1 Landhi Industrial Area Karachi 71500 Pakistan",
            // "buyerRegistrationType": "Registered",
            // "invoiceRefNo": "",
            // "scenarioId": "SN001",
            // "items": [
            //     {
            //     "hsCode": "2202.1010",
            //     "productDescription": "Pepsi 1.5L",
            //     "rate": "18%",
            //     "uoM": "Liter",
            //     "quantity": 1,
            //     "totalValues": 233.64,
            //     "valueSalesExcludingST": 198,
            //     "fixedNotifiedValueOrRetailPrice": 0,
            //     "salesTaxApplicable": 35.64,
            //     "salesTaxWithheldAtSource": 0,
            //     "extraTax": 0,
            //     "furtherTax": 0,
            //     "sroScheduleNo": "",
            //     "fedPayable": 0,
            //     "discount": 0,
            //     "saleType": "Goods at standard rate (default)",
            //     "sroItemSerialNo": ""
            //     }
            // ]
            // }',
            // CURLOPT_HTTPHEADER => array(
            //     'Authorization: Bearer 2ebe4443-4c22-341f-8f4e-aa4002fcffcb',
            //     'Content-Type: application/json',
            //     'Cookie: key=value; JSESSIONID=bpj1mA3i8XLgj3YR26P-eXlvhlIcQpctjj3uV0Ls.i01-irisdmz63; cookiesession1=678B2A2D2F021F2651C41BB24B4032F9'
            // ),
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);
            // echo $response;

            // Check for cURL errors
            if ($response === false || $curlError) {
                Log::error('FBR Post cURL Error', [
                    'error' => $curlError,
                    'url' => $url,
                    'response' => $response,
                    'httpCode' => $httpCode 
                ]);
                return [
                    'success' => false,
                    'error' => $curlError ?: 'Failed to connect to FBR API',
                    'statusCode' => null,
                    'status' => null,
                ];
            }
            $data = json_decode($response, true);
            // Check for JSON decode errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'success' => false,
                    'error' => 'Invalid response from FBR API: ' . json_last_error_msg(),
                    'statusCode' => null,
                    'status' => null,
                ];
            }
            // Extract fields safely
            $dated         = $data['dated'] ?? null;
            $invoiceNumber = $data['invoiceNumber'] ?? null;
            $validationResponse = $data['validationResponse'] ?? [];
            $invoiceStatuses    = $validationResponse['invoiceStatuses'] ?? [];
            $firstInvoiceStatus = $invoiceStatuses[0] ?? [];
            // Error fallback handling
            $error = !empty($validationResponse['error'])
                ? $validationResponse['error']
                : ($firstInvoiceStatus['error'] ?? 'Unknown error');
            $errorCode = !empty($validationResponse['errorCode'])
                ? $validationResponse['errorCode']
                : ($firstInvoiceStatus['errorCode'] ?? null);
            $status     = $validationResponse['status'] ?? null;
            $statusCode = $validationResponse['statusCode'] ?? null;
            return [
                'success'        => $statusCode === '00' && $status === 'Valid' && !empty($invoiceNumber),
                'dated'          => $dated,
                'data'           => $data,
                'statusCode'     => $statusCode,
                'status'         => $status,
                'errorCode'      => $errorCode,
                'error'          => $error,
                'invoiceStatuses' => $invoiceStatuses,
            ];
        } catch (\Exception $e) {
            Log::error('Invoice Posting Failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
    private function callFbrApi(
        string $endpoint,
        string $method = 'POST',
        array $payload = [],
        int $retry = 2,
        int $timeout = 30
    ): array {
        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
        $lastError = null;
        for ($attempt = 1; $attempt <= $retry; $attempt++) {
            try {
                $curl = curl_init();
                $options = [
                    CURLOPT_URL            => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT        => $timeout,
                    CURLOPT_ENCODING       => '',
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                    CURLOPT_HTTPHEADER     => [
                        'Authorization: Bearer ' . $this->token,
                        'Content-Type: application/json',
                        'Accept: application/json',
                    ],
                ];
                if (strtoupper($method) === 'POST') {
                    $options[CURLOPT_CUSTOMREQUEST] = 'POST';
                    $options[CURLOPT_POSTFIELDS]   = json_encode($payload);
                }
                curl_setopt_array($curl, $options);
                $response  = curl_exec($curl);
                $httpCode  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                $curlError = curl_error($curl);
                curl_close($curl);
                // ✅ Logging
                Log::info("FBR Attempt {$attempt}", [
                    'url'      => $url,
                    'method'   => $method,
                    'payload'  => $payload,
                    'response' => $response,
                    'httpCode' => $httpCode
                ]);
                // ❌ Transport failure
                if ($curlError) {
                    $lastError = "curlError: {$curlError}";
                    sleep($attempt);
                    continue;
                }
                // ❌ No response
                if (!$response) {
                    $lastError = "empty response";
                    sleep($attempt);
                    continue;
                }
                // ✅ Decode safely
                $decoded = json_decode($response, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $lastError = "Invalid JSON returned";
                    sleep($attempt);
                    continue;
                }
                // ✅ Success response
                if ($httpCode >= 200 && $httpCode < 300) {
                    return [
                        'success'   => true,
                        'statusCode' => $httpCode,
                        'data'      => $decoded,
                        'error'     => null
                    ];
                }
                // ❌ 401 — No retry
                if ($httpCode === 401) {
                    return [
                        'success'   => false,
                        'statusCode' => $httpCode,
                        'error'     => 'Unauthorized — Token expired/invalid',
                        'data'      => $decoded
                    ];
                }
                // ✅ Retry if server error
                if ($httpCode >= 500) {
                    $lastError = "Server error: {$httpCode}";
                    sleep($attempt);
                    continue;
                }
                // ❌ Client error — stop
                return [
                    'success'   => false,
                    'statusCode' => $httpCode,
                    'error'     => $decoded['message'] ?? "HTTP error {$httpCode}",
                    'data'      => $decoded
                ];
            } catch (\Exception $ex) {
                $lastError = $ex->getMessage();
                sleep($attempt);
            }
        }
        // ❌ Failed after retries
        return [
            'success'   => false,
            'statusCode' => null,
            'error'     => $lastError ?? 'Unknown error',
            'data'      => null
        ];
    }
    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ];
    }
    protected function setToken()
    {
        $busConfigId = Auth::user()->bus_config_id;
        $config = BusinessConfiguration::where('bus_config_id', $busConfigId)->first();
        if (!$config) {
            throw new \Exception("Business configuration not found for tenant ID {$busConfigId}");
        }
        $this->token = $config->fbr_env === 'production'
            ? $config->fbr_api_token_prod
            : $config->fbr_api_token_sandbox;
        $this->env = $config->fbr_env ?? 'sandbox';
    }
    protected function get(string $endpoint, array $query = []): array
    {
        try {
            $url = "https://gw.fbr.gov.pk/pdi/v1/" . ltrim($endpoint, '/');
            $response = Http::withHeaders($this->headers())
                ->timeout(30)
                ->get($url, $query);
            if ($response->failed()) {
                Log::error("FBR API GET failed: {$url}", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return [
                    'success' => false,
                    'error' => $response->body(),
                ];
            }
            return [
                'success' => true,
                'data' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error("FBR API GET exception: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
    public function getItemDescCodes(): array
    {
        return $this->get('itemdesccode');
    }
    public function getDocTypeCodes(): array
    {
        return $this->get('doctypecode');
    }
    public function getProvinces(): array
    {
        return $this->get('provinces');
    }
    public function getSroItemCodes(): array
    {
        return $this->get('sroitemcode');
    }
    public function getTransTypeCodes(): array
    {
        return $this->get('transtypecode');
    }
    public function getUnitsOfMeasure(): array
    {
        return $this->get('uom');
    }
    // SRO Schedule
    public function getSroSchedule(array $params = []): array
    {
        return $this->get('SroSchedule', $params);
    }
    // Sale Type to Rate
    public function getSaleTypeToRate(array $params = []): array
    {
        return $this->get('SaleTypeToRate', $params);
    }
    // HS Code with UOM
    public function getHSUOM(array $params = []): array
    {
        return $this->get('HS_UOM', $params);
    }
    // SRO Item (with SRO ID & Date)
    public function getSroItem(array $params = []): array
    {
        return $this->get('SROItem', $params);
    }
    // STATL (check taxpayer registration status)
    public function checkSTATL(array $payload): array
    {
        return $this->postDist('statl', $payload);
    }
    // STATL Get_Reg_Type
    public function getRegType(array $payload): array
    {
        return $this->postDist('Get_Reg_Type', $payload);
    }
    // ------------------------------
    // Helper for POST calls to /dist
    // ------------------------------
    protected function postDist(string $endpoint, array $payload): array
    {
        try {
            $url = "https://gw.fbr.gov.pk/dist/v1/" . ltrim($endpoint, '/');
            $response = Http::withHeaders($this->headers())
                ->timeout(30)
                ->post($url, $payload);
            if ($response->failed()) {
                $body = $response->body();
                Log::error("FBR API POST failed: {$url}", [
                    'status' => $response->status(),
                    'body'   => $body,
                ]);
                return [
                    'success' => false,
                    'error'   => 'FBR service temporarily unavailable',
                    'debug'   => $body,
                ];
            }
            return [
                'success' => true,
                'data'    => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error("FBR API POST exception: " . $e->getMessage());
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }
}
